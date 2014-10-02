<?php
/**
 * 楽天ウェディングから情報を取得するためのクラス
 * 
 * ログイン時にトークンが吐きだされるので、それを引き回して各処理を行う。
 * cURLのセッションを切らないように注意する事。
 * 
 * 楽天ウェディングは通常のログインの他、
 * 更新用画面へのログインが必要となる。
 * 通常ログイン(login)→会場を選択してのログイン(doubleLogin)となる。
 * 
 * 更新用画面は他の端末で誰かがログインしている状態だとロックがかかるようになっている。
 * システムから更新用画面にログインした際にログアウト処理を忘れると、
 * ユーザが直接操作出来なくなってしまうので注意が必要。
 * もしロックがかかった場合、再ログイン（doubleLogin)→ログアウト(logout)を行えば解除できる。
 * 
 * また、ユーザが直接操作している間はシステムからの操作が不可になる。注意する事。
 */
class SiteRakuten extends Site {
    /**
     * site_logins.idの値
     */
    const SITE_LOGIN_ID = 5;
    const DIR_NAME = 'rakuten';
    
    const BASE_URL = 'https://wedding.rakuten.co.jp/admin/';
    //ログイン
    const LOGIN_URL = 'https://wedding.rakuten.co.jp/admin/login/dologin';
    const UPDATE_LOGIN_URL = 'https://wedding.rakuten.co.jp/admin/loginUpdate/dologin';
    //ログアウト
    const LOGOUT_URL  = 'https://wedding.rakuten.co.jp/admin/login/logout';
    const LOGOUT_URL2 = 'https://wedding.rakuten.co.jp/admin/loginUpdate/logout/ticket/%%TICKET%%';
    //フェア一覧
    const FAIR_LIST_URL = 'https://wedding.rakuten.co.jp/admin/upFair/search';
    const FAIR_LIST_PATTERN = '/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/search\?ticket=(\d+)(\&\S+)/';
    const FAIR_LIST_OUTPUT_LINK_PATTERN = '/\/admin\/upFair\/editInput\/ticket\/\d+\/fair_no\/(\d+)/';
    //フェア編集
    const FAIR_EDIT_URL = "https://wedding.rakuten.co.jp/admin/upFair/editInput/ticket/%%TICKET%%/fair_no/%%ID%%";
    const FAIR_EDIT_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/editInput\/ticket\/(\d+)\/fair_no\/(\d+)/";
    //フェア登録
    const FAIR_INPUT_URL = "https://wedding.rakuten.co.jp/admin/upFair/newInput/ticket/%%TICKET%%/";
    const FAIR_INPUT_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/newInput\/ticket\/(\d+)\//";
    const FAIR_CONFIRM_URL = 'https://wedding.rakuten.co.jp/admin/upFair/newConfirm';
    const FAIR_CONFIRM_PATTERN = '/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/newConfirm/';
    const FAIR_REGIST_URL = 'https://wedding.rakuten.co.jp/admin/upFair/newRegist';
    const FAIR_REGIST_PATTERN = '/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/newRegist/';
    
    const RELOAD_URL = "https://wedding.rakuten.co.jp/admin/upSessionTimeReload/sessionRelaod?ticket=%%TICKET%%";
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/rakuten.txt';
    
    protected static $_loginParams = array(
        'login_id' => '',
        'pass' => '',
    );
    /**
     * セッション毎に割り当てられる文字列。ログイン成功時に引っ張ってくる。
     * @var str 
     */
    protected $_ticket = null;
    protected $_hollId = 'wed0000412';
    /**
     * 更新用でログインしているかのフラグ
     * ONの場合、close時にログアウト処理を挟む
     * @var bool
     */
    protected $_update = false;
    
    protected function craeteLoginParams()
    {
        $params = self::$_loginParams;
        //ログインIDとパスワードをDBから取得
        $params['login_id'] = $this->_login->login_id;
        $params['pass'] = $this->_login->password;
        return $params;
    }
    
    protected function checkLoginResult() 
    {
        $info = $this->_curl->getInfo();
        if($info['http_code'] !== 200 || !preg_match('/^https:\/\/wedding.rakuten.co.jp\/admin\/hallList\/view\/ticket\/(\d+)/',$info['url'],$matches)) {
            return false;
        }
        $this->_ticket = $matches[1];
        return true;
    }
    
    /**
     * 更新用パスワードでのログイン処理
     * @return boolean
     * @throws WorkException
     */
    public function doubleLogin()
    {
        if(!$this->login(false) && !$this->_ticket) {
            return false;
        }
        $params = array(
            'act' => 'admin_loginupdate_dologin',
            'hall_id' => $this->_hollId,
            'login_id' => $this->_hollId,
            'ticket' => $this->_ticket,
            'pass' => $this->_login->update_password,
        );
        try {
            //var_dump($params);
            $this->_curl->addUrl(self::UPDATE_LOGIN_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200 || !preg_match('/^https:\/\/wedding.rakuten.co.jp\/admin\/upTop\/view\?hall_id='.$this->_hollId.'\&act=admin_updatetop_view\&ticket='.$this->_ticket.'/',$info['url'])) {
                $code = preg_match('/他の端末でログイン中です/',preg_replace('/[\r|\n|\t|\s]+/','',$this->_curl->getExec())) ? WorkException::CODE_RAKUTEN_UPDATE_LOCK : WorkException::CODE_CONNECT_FAILED;
                throw new WorkException($code,$this->_curl);
            }
        } catch(Exception $e) {
            error_log($e);
            return false;
        }
        $this->_update = true;
        return true;
    }
    
    /**
     * 更新ページを抜ける処理
     * やらないと更新ページがロックされるので注意。
     * @return boolean
     * @throws WorkException
     */
    public function logout()
    {
        try {
            if($this->_update) {
                //var_dump($params);
                $this->_curl->addUrl(str_replace('%%TICKET%%',$this->_ticket,self::LOGOUT_URL2));
                $this->run();
                $info = $this->_curl->getInfo();
                //echo $this->_curl->getExec();
                if($info['http_code']!==200) {
                    throw new WorkException(WorkException::CODE_RAKUTEN_LOGOUT_FAILED,$this->_curl);
                }
            }
            $this->_update = false;
        } catch(Exception $e) {
            error_log($e);
        }
        return parent::logout();
    }
    
    public function getFairs($year,$month)
    {
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            //検索パラメータ
            $params = array(
                'ticket' => $this->_ticket,
                'd_fair_no' => '',
                'page_no' => '',
                'open_date_from_year' => '',
                'open_date_from_month' => '',
                'open_date_from_day' => '',
                'open_date_to_year' => '',
                'open_date_to_month' => '',
                'open_date_to_day' => '',
                'fair_name' => '',
                'point_flg' => 0,
                'view_flg[]' => array(0,1),
                'fairNo' => '#search_result',
            );
            $get = array();
            foreach($params as $key => $p) {
                if(is_array($p)) {
                    foreach($p as $value) {
                        $get[] = $key."=".$value;
                    }    
                } else {
                    $get[] = $key."=".$p;
                }
            }
            $url = self::FAIR_LIST_URL . "?" . implode('&',$get);
            echo $url."<br/>";
            $this->_curl->addUrl($url);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200 || !preg_match(self::FAIR_LIST_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            preg_match_all(self::FAIR_LIST_OUTPUT_LINK_PATTERN,$this->_curl->getExec(),$matches,PREG_SET_ORDER);
            $ids = array();
            foreach($matches as $m) {
                if(!in_array($m[1],$ids)) {
                    $ids[] = $m[1];
                }
            }
            var_dump($ids);
        } catch (Exception $e) {
            error_log($e);
            return false;
        }
        $this->close();
        return true;
    }
    
    public function getFairDetail($id, $chClose = true) 
    {
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        $id = (int)$id;
        if(!$id) {
            throw new Exception('id is not number');
        }
        try {
            $this->optionReset();
            
            //データ取得
            $url = str_replace('%%TICKET%%',$this->_ticket,str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            echo $url."<br/>";
            
            $this->_curl->addUrl($url);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200||!preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            //input,select,textareaを取得
            $ret = $this->getDetailVal($this->_curl->getExec(), array());
            //保存
            $work = WorkRakutenFair::find($id);
            if(!$work) {
                $work = new WorkRakutenFair();
                $work->id = $id;
            }
            $work->data = serialize($ret);
            $work->save();
            var_dump($ret);
        } catch (Exception $e) {
            error_log($e);
            if($chClose) {
                $this->close();
            }
            return false;
        }
        if($chClose) {
            $this->close();
        }
        return true;
    }
    
    public function addFair($id,$chClose=true)
    {
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            $id = 97;
            //必要データ取得処理
            $work = WorkRakutenFair::findOrFail($id);
            $data = unserialize($work->data);
            $key_str = "";
            $params = array(
                'fairEventListUrl' => '/admin/upFair/fairEventList',
                'fairEventListUrlAll' => '/admin/upFair/fairEventListAll',
                'fairEventViewFlg' => 0,
                'ticket' => $this->_ticket,
                'key_str' => '',
                'photo_category' => 98,
                'frm[only_online_reserve]' => '',
                'frm[registered_open_date]' => '',
                'frm[hall_id]' => $this->_hollId,
                'frm[open_date]' => '',
                'frm[reserve_cd]' => 1,
            );
            //データチェック
            $validator = $this->getFairInputValidation($data);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value). " ===> " .$data[$key] . "<br/>";
                }
                return false;
            }
            //登録画面から必要値を抽出
            $this->_curl->addUrl(str_replace('%%TICKET%%',$this->_ticket,self::FAIR_INPUT_URL));
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_INPUT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            $html = str_get_html($this->_curl->getExec());
            foreach($html->find("input") as $input) {
                if(in_array($input->name,array('key_str','frm[only_online_reserve]','frm[registered_open_date]'))) {
                    $params[$input->name] = $input->value;
                }
            }
            $html->clear();
            
            //登録データ抽出
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($data[$key])) {
                    $params[$key] = $data[$key];
                }
            }
            foreach($data as $key => $param) {
                if(preg_match('/^frm\[event_list\]\[(\d+)\]\[([a-zA-Z0-9_]+)\]\[\]/',$key,$m)) {
                    $num = ((int)$m[1]) + 100000;
                    $key = 'frm[event_list]['.$num.']['.$m[2].'][]';
                    $params[$key] = $param;
                }else if(preg_match('/^frm\[event_list\]\[(\d+)\]\[([a-zA-Z0-9_]+)\]/',$key,$m)) {
                    $num = ((int)$m[1]) + 100000;
                    $key = 'frm[event_list]['.$num.']['.$m[2].']';
                    $params[$key] = $param;
                }
                
            }
            //日付データ取得
            $params['frm[reserve_method_cd][]'] = $data['frm[reserve_method_cd][]'];
            $params['frm[open_date]'] = $data['frm[open_date]'];
            //test
            $params['frm[fair_name]'] = $params['frm[fair_name]'] . "_";
            //---- 確認ページへPOST ----//
            //boundary作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            $body = $this->multipart_build_query($params, $boundary);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Expect:",
            );
            
            //データの貼り付け
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_CONFIRM_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            
            $info = $this->_curl->getInfo();
            //var_dump($info);
            //echo $this->_curl->getExec();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_CONFIRM_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }

            //---- 登録 ----//
            //必要データ抽出
            $params = array();
            preg_match_all('/<input\stype="hidden"\sname="([^"]+)"\sid="[^"]+"\svalue="([\S|\n|\r]+)" \/>/',$this->_curl->getExec(),$matches,PREG_SET_ORDER);
            foreach($matches as $m) {
                $params[$m[1]] = $m[2];
            }

            //boundary作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            $body = $this->multipart_build_query($params, $boundary);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Expect:",
            );

            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_REGIST_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            
            echo $body."\n<br/>";
            $info = $this->_curl->getInfo();
            var_dump($info);
            echo $this->_curl->getExec();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_REGIST_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            
        } catch(Exception $e) {
            error_log($e);
            if($chClose) {
                $this->close();
            }
            return false;
        }
        if($chClose) {
            $this->close();
        }
        return true;
    }
    
    /**
     * フェア登録をする際のValidate内容
     * @param type $data
     * @return type
     */
    public function getFairInputValidation($data)
    {
        $hour = array();
        $min  = array();
        for($i=0;$i<60;$i+=5){
            $min[] = sprintf('%02d',$i);
        }
        $hour = '8,9,10,11,12,13,14,15,16,17,18,19,20';
        $min = implode(",",$min);
        
        $v = array(
            'frm[fair_name]' => array('required','max:40'),
            'frm[introduction]' => array('required','max:200'),
            'frm[reception_cd]' => array('numeric','in:1,2,3,4,5'),
            'frm[photo_id]' => array('required','numeric'),
            'frm[same_event_time_flg]' => array('numeric','in:0'),
        );
        if(isset($data['frm[same_event_time_flg]'])) {
            $v['frm[same_event_time][event_time_from_hour]'] = array('numeric','in:'.$hour,'required_with:foo:frm[same_event_time_flg]');
            $v['frm[same_event_time][event_time_from_minute]'] = array('numeric','in:'.$min,'required_with:foo:frm[same_event_time_flg]');
            $v['frm[same_event_time][event_time_to_hour]'] = array('numeric','in:'.$hour,'required_with:foo:frm[same_event_time_flg]');
            $v['frm[same_event_time][event_time_to_minute]'] = array('numeric','in:'.$min,'required_with:foo:frm[same_event_time_flg]');
        }
        return Validator::make($data,$v);
    }
}