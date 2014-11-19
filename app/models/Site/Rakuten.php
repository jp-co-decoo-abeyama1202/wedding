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
 * もしロックがかかった場合は1～2時間ほど待つ事。
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
    const FAIR_EDIT_CONFIRM_URL = 'https://wedding.rakuten.co.jp/admin/upFair/editConfirm';
    const FAIR_EDIT_CONFIRM_PATTERN = '/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/editConfirm/';
    const FAIR_EDIT_REGIST_URL = 'https://wedding.rakuten.co.jp/admin/upFair/editRegist';
    const FAIR_EDIT_REGIST_PATTERN = '/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/editRegist/';
    
    //フェア登録
    const FAIR_INPUT_URL = "https://wedding.rakuten.co.jp/admin/upFair/newInput/ticket/%%TICKET%%/";
    const FAIR_INPUT_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/newInput\/ticket\/(\d+)\//";
    const FAIR_INPUT_CONFIRM_URL = 'https://wedding.rakuten.co.jp/admin/upFair/newConfirm';
    const FAIR_INPUT_CONFIRM_PATTERN = '/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/newConfirm/';
    const FAIR_INPUT_REGIST_URL = 'https://wedding.rakuten.co.jp/admin/upFair/newRegist';
    const FAIR_INPUT_REGIST_PATTERN = '/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/newRegist/';
    
    //フェア削除
    const FAIR_DELETE_URL = "https://wedding.rakuten.co.jp/admin/upFair/deleteConfirm?ticket=%%TICKET%%&fair_no[]=%%ID%%";
    const FAIR_MULTI_DELETE_URL = "https://wedding.rakuten.co.jp/admin/upFair/deleteConfirm?ticket=%%TICKET";
    const FAIR_DELETE_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/deleteConfirm\?ticket=(\d+)(\&fair_no\[\]=\d+)+/";
    const FAIR_DELETE_REGIST_URL = "https://wedding.rakuten.co.jp/admin/upFair/deleteRegist";
    const FAIR_DELETE_REGIST_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upFair\/deleteRegist/";
    
    //特典取得
    const TOKUTEN_INPUT_URL = "https://wedding.rakuten.co.jp/admin/upTokuten/input/ticket/%%TICKET%%";
    const TOKUTEN_INPUT_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upTokuten\/input\/ticket\/(\d+)/";
    const TOKUTEN_CONFIRM_URL ="https://wedding.rakuten.co.jp/admin/upTokuten/doCheck";
    const TOKUTEN_CONFIRM_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upTokuten\/doCheck/";
    const TOKUTEN_REGIST_URL = "https://wedding.rakuten.co.jp/admin/upTokuten/doUpdate";
    const TOKUTEN_REGIST_PATTERN = "/^https:\/\/wedding.rakuten.co.jp\/admin\/upTokuten\/doUpdate/";
    
    const RELOAD_URL = "https://wedding.rakuten.co.jp/admin/upSessionTimeReload/sessionRelaod?ticket=%%TICKET%%";
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/rakuten.txt';
    
    protected static $_loginParams = array(
        'login_id' => '',
        'pass' => '',
    );
    
    protected static $_inputParams = array(
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
        $this->optionReset();
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
                $this->curlCheck(WorkException::CODE_RAKUTEN_LOGOUT_FAILED);
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
            //チェック
            $this->curlCheck(WorkException::CODE_CONNECT_FAILED,self::FAIR_LIST_PATTERN);
            
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
        $id = 106;
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
            
            //チェック
            $this->curlCheck(WorkException::CODE_FAIR_GET_FAILED,self::FAIR_EDIT_PATTERN);
            
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
        $errorStrPattern = "/エラー/";
        
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            $id = 97;
            //必要データ取得処理
            $work = WorkRakutenFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            
            $params = self::$_inputParams;
            $params['ticket'] = $this->_ticket;
            
            //データチェック
            $validator = WorkRakutenValidation::getFairInputValidation($data);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value). " ===> " .$data[$key] . "<br/>";
                }
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            
            //登録画面から必要値を抽出
            $this->_curl->addUrl(str_replace('%%TICKET%%',$this->_ticket,self::FAIR_INPUT_URL));
            $this->run();
            
            $this->curlCheck(WorkException::CODE_FAIR_ADD_FAILED,self::FAIR_INPUT_PATTERN,$errorStrPattern);

            //echo $this->_curl->getExec();
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
            //イベントリスト
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
            $this->_curl->addUrl(self::FAIR_INPUT_CONFIRM_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            
            $this->curlCheck(WorkException::CODE_FAIR_ADD_FAILED,self::FAIR_INPUT_CONFIRM_PATTERN,$errorStrPattern);

            //---- 登録 ----//
            //必要データ抽出
            $registParams = array();
            preg_match_all('/<input\stype="hidden"\sname="([^"]+)"\sid="[^"]+"\svalue="([\S|\n|\r]+)" \/>/',$this->_curl->getExec(),$matches,PREG_SET_ORDER);
            foreach($matches as $m) {
                $registParams[$m[1]] = $m[2];
            }

            //boundary作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            $body = $this->multipart_build_query($registParams, $boundary);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Expect:",
            );

            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_INPUT_REGIST_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            
            $this->curlCheck(WorkException::CODE_FAIR_ADD_FAILED,self::FAIR_INPUT_REGIST_PATTERN,$errorStrPattern);
            
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
    
    public function updateFair($id,$chClose=true)
    {
        $errorStrPattern = "/エラー/";
        
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            $id = 106;
            //更新データ
            $updateData = array(
                'frm[fair_name]' => 'テストフェア情報_+',
            );
            //データ取得
            $url = str_replace('%%TICKET%%',$this->_ticket,str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            echo $url."<br/>";
            
            $this->_curl->addUrl($url);
            $this->run();
            //チェック
            $this->curlCheck(WorkException::CODE_FAIR_UPDATE_FAILED,self::FAIR_EDIT_PATTERN);
            //input,select,textareaを取得
            $data = $this->getDetailVal($this->_curl->getExec(), array());
            
            //DBのデータをValidate
            $validator = WorkMynaviValidation::getFairUpdateValidation($updateData);
            if ($validator->fails()) {
               $failed = false;
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    if(isset($updateData[$key])) {
                        echo $key ." ： ".implode(",",$value). " ===> " . $updateData[$key] . "<br/>";
                        $failed = true;
                    }
                }
                if($failed) {
                    throw new WorkException(WorkException::CODE_UPDATE_FAILED,$this->_curl);
                }
            }
            //DBのデータで上書き
            $params = array();
            foreach($data as $key => $value) {
                if(!$key||preg_match('/^frm\[event_list\]\[\$\{index\}\]/',$key)) {
                    continue;
                }
                $params[$key] = isset($updateData[$key]) ? $updateData[$key] : $value;
            }
            
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
            $this->_curl->addUrl(self::FAIR_EDIT_CONFIRM_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            $this->curlCheck(WorkException::CODE_FAIR_UPDATE_FAILED,self::FAIR_EDIT_CONFIRM_PATTERN,$errorStrPattern);

            //---- 更新 ----//
            //必要データ抽出
            $registParams = array();
            preg_match_all('/<input\stype="hidden"\sname="([^"]+)"\sid="[^"]+"\svalue="([\S|\n|\r]+)" \/>/',$this->_curl->getExec(),$matches,PREG_SET_ORDER);
            foreach($matches as $m) {
                $registParams[$m[1]] = $m[2];
            }

            //boundary作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            $body = $this->multipart_build_query($registParams, $boundary);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Expect:",
            );

            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_EDIT_REGIST_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            
            $this->curlCheck(WorkException::CODE_FAIR_UPDATE_FAILED,self::FAIR_EDIT_REGIST_PATTERN,$errorStrPattern);
            
            echo $this->_curl->getExec();
            
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
    
    public function deleteFair($id,$chClose=true)
    {
        $errorStrPattern = "/エラー/";
        
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            $id = 101;
            //データ取得
            $url = str_replace('%%TICKET%%',$this->_ticket,str_replace('%%ID%%',$id,self::FAIR_DELETE_URL));
            $this->_curl->addUrl($url);
            $this->run();
            //チェック
            $this->curlCheck(WorkException::CODE_FAIR_DELETE_FAILED,self::FAIR_DELETE_PATTERN);
            //input,select,textareaを取得
            $params = $this->getDetailVal($this->_curl->getExec(), array());
            
            //確定ページへ
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_DELETE_REGIST_URL,$params));
            $this->_curl->methodPost();
            $this->run();
            
            $this->curlCheck(WorkException::CODE_FAIR_DELETE_FAILED,self::FAIR_DELETE_REGIST_PATTERN,$errorStrPattern);
            
            echo $this->_curl->getExec();
            
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
     * 特典情報取得
     * @param type $chClose
     * @return boolean
     */
    public function getTokuten($chClose=true)
    {
        $errorStrPattern = "/[エラー|更新するデータがありません]/";
        
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            $this->_curl->addUrl(str_replace('%%TICKET%%',$this->_ticket,self::TOKUTEN_INPUT_URL));
            $this->run();
            //チェック
            $this->curlCheck(WorkException::CODE_RAKUTEN_TOKUTEN_GET_FAILED,self::TOKUTEN_INPUT_PATTERN,$errorStrPattern);
            //データ内容取得
            $data = $this->getDetailVal($this->_curl->getExec());
            $tokutens = array(
                WorkRakutenTokuten::TYPE_TOKUTEN_1 => array(
                    0 => new WorkRakutenTokuten(),
                    1 => new WorkRakutenTokuten(),
                    2 => new WorkRakutenTokuten(),
                    3 => new WorkRakutenTokuten(),
                    4 => new WorkRakutenTokuten(),
                ),
                WorkRakutenTokuten::TYPE_TOKUTEN_2 => array(
                    0 => new WorkRakutenTokuten(),
                    1 => new WorkRakutenTokuten(),
                    2 => new WorkRakutenTokuten(),
                    3 => new WorkRakutenTokuten(),
                    4 => new WorkRakutenTokuten(),
                ),
            );
            //登録済みデータを持ってくる
            foreach(WorkRakutenTokuten::all() as $tokuten) {
                $tokutens[$tokuten->type][$tokuten->type_no] = $tokuten;
            }
            DB::beginTransaction();
            foreach(array(WorkRakutenTokuten::TYPE_TOKUTEN_1,WorkRakutenTokuten::TYPE_TOKUTEN_2) as $i) {
                
                //position
                foreach($data["position[$i][]"] as $key => $position) {
                    if($position) {
                        $tokutens[$i][$key]->position = $position;
                    }
                }
                //privilege_name
                foreach($data["privilege_name[$i][]"] as $key => $privilegeName) {
                    if($privilegeName) {
                        $tokutens[$i][$key]->privilege_name = $privilegeName;
                    }
                }
                //privilege_content
                foreach($data["privilege_content[$i][]"] as $key => $privilegeContent) {
                    if($privilegeContent) {
                        $tokutens[$i][$key]->privilege_content = $privilegeContent;
                    }
                }
                //privilege_object
                foreach($data["privilege_object[$i][]"] as $key => $privilegeObject) {
                    if($privilegeObject) {
                        $tokutens[$i][$key]->privilege_object = $privilegeObject;
                    }
                }
                //application_method
                foreach($data["application_method[$i][]"] as $key => $applicationMethod) {
                    if($applicationMethod) {
                        $tokutens[$i][$key]->application_method = $applicationMethod;
                    }
                }
                for($j=0;$j<5;$j++) {
                    //fd_span_from
                    if(is_array($data["fd_span_from[$i][$j][]"])) {
                        $tokutens[$i][$j]->fd_span_from = implode("-",$data["fd_span_from[$i][$j][]"]);
                    }
                    //fd_span_to
                    if(is_array($data["fd_span_from[$i][$j][]"])) {
                        $tokutens[$i][$j]->fd_span_to = implode("-",$data["fd_span_to[$i][$j][]"]);
                    }
                    if(isset($data["access_view[$i][$j]"])) {
                        $tokutens[$i][$j]->access_view = $data["access_view[$i][$j]"];
                    }
                }
                
                //privilege_no
                foreach($data["privilege_no[$i][]"] as $key => $privilageNo) {
                    if($privilageNo) {
                        $tokutens[$i][$key]->privilege_no = $privilageNo;
                        $tokutens[$i][$key]->type_no = $key;
                        $tokutens[$i][$key]->type = $i;
                        $tokutens[$i][$key]->save();
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
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
     * 特典情報更新
     * @param type $chClose
     * @return boolean
     */
    public function updateTokuten($chClose=true) 
    {
        $errorStrPattern = "/エラー/";
        
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            $this->_curl->addUrl(str_replace('%%TICKET%%',$this->_ticket,self::TOKUTEN_INPUT_URL));
            $this->run();
            //チェック
            $this->curlCheck(WorkException::CODE_RAKUTEN_TOKUTEN_UPDATE_FAILED,self::TOKUTEN_INPUT_PATTERN,$errorStrPattern);
            //データ内容取得
            $data = $this->getDetailVal($this->_curl->getExec());
            //DBのデータで上書き
            foreach(WorkRakutenTokuten::all() as $tokuten) {
                //position
                $data["position[$tokuten->type][]"][$tokuten->type_no] = $tokuten->position;
                //privilege_name
                $data["privilege_name[$tokuten->type][]"][$tokuten->type_no] = $tokuten->privilege_name . "_t";
                //privilege_content
                $data["privilege_content[$tokuten->type][]"][$tokuten->type_no] = $tokuten->privilege_content;
                //privilege_object
                $data["privilege_object[$tokuten->type][]"][$tokuten->type_no] = $tokuten->privilege_object;
                //application_method
                $data["application_method[$tokuten->type][]"][$tokuten->type_no] = $tokuten->application_method;
                //fd_span_from
                $data["fd_span_from[$tokuten->type][$tokuten->type_no][]"] = explode("-",$tokuten->fd_span_from);
                //fd_span_to
                $data["fd_span_to[$tokuten->type][$tokuten->type_no][]"] = explode("-",$tokuten->fd_span_to);
                //access_view
                $data["access_view[$tokuten->type][$tokuten->type_no]"] = $tokuten->access_view;
            }
            $data['del_privilege_no'] = "";
            $data['ticket'] = $this->_ticket;
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::TOKUTEN_CONFIRM_URL, $data));
            $this->_curl->methodPost();
            $this->run();
            $this->curlCheck(WorkException::CODE_RAKUTEN_TOKUTEN_UPDATE_FAILED,self::TOKUTEN_CONFIRM_PATTERN,$errorStrPattern);
            
            if(!preg_match("/更新するデータがありません/",$this->_curl->getExec())) {
                //データ内容取得
                $updateParams = $this->getDetailVal($this->_curl->getExec());
                $this->optionReset();
                $this->_curl->addUrl(self::TOKUTEN_REGIST_URL);
                $this->_curl->addPostParams($updateParams);
                $this->run();
                echo $this->_curl->getExec();
                $this->curlCheck(WorkException::CODE_RAKUTEN_TOKUTEN_UPDATE_FAILED,self::TOKUTEN_REGIST_PATTERN,$errorStrPattern);
            }
            
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
    
    /**
     * 特典情報更新
     * @param type $chClose
     * @return boolean
     */
    public function getImages($genreId,$chClose=true) 
    {   
        //更新ページログイン処理
        if(!$this->doubleLogin()) {
            return false;
        }
        try {
            $this->_curl->addUrl(str_replace('%%TICKET%%',$this->_ticket,self::TOKUTEN_INPUT_URL));
            $this->run();
            //チェック
            $this->curlCheck(WorkException::CODE_RAKUTEN_TOKUTEN_UPDATE_FAILED,self::TOKUTEN_INPUT_PATTERN,$errorStrPattern);
            //データ内容取得
            $data = $this->getDetailVal($this->_curl->getExec());
            //DBのデータで上書き
            foreach(WorkRakutenTokuten::all() as $tokuten) {
                //position
                $data["position[$tokuten->type][]"][$tokuten->type_no] = $tokuten->position;
                //privilege_name
                $data["privilege_name[$tokuten->type][]"][$tokuten->type_no] = $tokuten->privilege_name . "_t";
                //privilege_content
                $data["privilege_content[$tokuten->type][]"][$tokuten->type_no] = $tokuten->privilege_content;
                //privilege_object
                $data["privilege_object[$tokuten->type][]"][$tokuten->type_no] = $tokuten->privilege_object;
                //application_method
                $data["application_method[$tokuten->type][]"][$tokuten->type_no] = $tokuten->application_method;
                //fd_span_from
                $data["fd_span_from[$tokuten->type][$tokuten->type_no][]"] = explode("-",$tokuten->fd_span_from);
                //fd_span_to
                $data["fd_span_to[$tokuten->type][$tokuten->type_no][]"] = explode("-",$tokuten->fd_span_to);
                //access_view
                $data["access_view[$tokuten->type][$tokuten->type_no]"] = $tokuten->access_view;
            }
            $data['del_privilege_no'] = "";
            $data['ticket'] = $this->_ticket;
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::TOKUTEN_CONFIRM_URL, $data));
            $this->_curl->methodPost();
            $this->run();
            $this->curlCheck(WorkException::CODE_RAKUTEN_TOKUTEN_UPDATE_FAILED,self::TOKUTEN_CONFIRM_PATTERN,$errorStrPattern);
            
            if(!preg_match("/更新するデータがありません/",$this->_curl->getExec())) {
                //データ内容取得
                $updateParams = $this->getDetailVal($this->_curl->getExec());
                $this->optionReset();
                $this->_curl->addUrl(self::TOKUTEN_REGIST_URL);
                $this->_curl->addPostParams($updateParams);
                $this->run();
                echo $this->_curl->getExec();
                $this->curlCheck(WorkException::CODE_RAKUTEN_TOKUTEN_UPDATE_FAILED,self::TOKUTEN_REGIST_PATTERN,$errorStrPattern);
            }
            
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
    
    public function formatInputData($data)
    {
        //テストデータ加工
        if(App::environment("testing")) {
            if(mb_strlen($data['frm[fair_name]']) < 39) {
                $data['frm[fair_name]'].= "_t";
            }
            $data['frm[open_date]'] = date('Y-m-d',strtotime('+1 day'));
        }
        return $data;
    }
}