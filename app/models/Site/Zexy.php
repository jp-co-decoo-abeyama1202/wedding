<?php
/**
 * Zexyから情報を取得・登録を行うためのクラス
 * 
 * Zexyは各作業にトークンの引き渡しが必要になる。
 * 登録画面を開き、最終的な登録まで一つのトークンで行うため、
 * その辺を意識して行う事が必要となる。
 * 
 * また、修正画面が細かく分かれている為
 * 修正画面操作にも注意が必要となる。
 */
class SiteZexy extends Site {
    /**
     * site_logins.idの値
     */
    const SITE_LOGIN_ID = 2;
    const DIR_NAME = 'zexy';
    
    const BASE_URL = 'https://cszebra.zexy.net';
    //ログイン
    const LOGIN_URL = 'https://cszebra.zexy.net/id/login/';
    //ログアウト
    const LOGOUT_URL = 'https://cszebra.zexy.net/id/zebraHeader/doLogout/';
    //フェア一覧
    const FAIR_LIST_URL = 'https://cszebra.zexy.net/nyuko/hallFairList/doSearch?holdDate=%%YMD%%';
    const FAIR_LIST_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairList\/doSearch\?holdDate=\d{4}\/\d{2}\/\d{1,2}/';
    const FAIR_LIST_OUTPUT_LINK_PATTERN = '/\/nyuko\/hallFairRegist\/doChangeConfirm\?nyukoModeKbn=\d{2}&productId=(\d+)/';
    //フェア編集
    const FAIR_EDIT_URL = 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeConfirm?nyukoModeKbn=01&productId=%%ID%%';
    const FAIR_EDIT_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairRegist\/doChangeConfirm\?nyukoModeKbn=01&productId=(\d+)/';
    const FAIR_EDIT_COMPLETE_URL = 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeComplete';
    
    //フェア登録
    const FAIR_INPUT_URL = 'https://cszebra.zexy.net/nyuko/hallFairRegist/doInput';
    const FAIR_INPUT_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairRegist\/doInput/';
    const FAIR_INPUT_DETAIL_URL = 'https://cszebra.zexy.net/nyuko/hallFairRegist/doInputDetail';
    const FAIR_INPUT_DETAIL_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairRegist\/doInputDetail/';
    const FAIR_INPUT_ETC_URL = 'https://cszebra.zexy.net/nyuko/hallFairRegist/doInputEtc';
    const FAIR_INPUT_ETC_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairRegist\/doInputEtc/';
    const FAIR_CONFIRM_URL = 'https://cszebra.zexy.net/nyuko/hallFairRegist/doConfirm';
    const FAIR_CONFIRM_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairRegist\/doConfirm/';
    const FAIR_REGIST_URL = 'https://cszebra.zexy.net/nyuko/hallFairRegist/doComplete';
    const FAIR_COMPLETE_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairRegist\/complete/';
    
    //フェア削除
    const FAIR_DELETE_URL = 'https://cszebra.zexy.net/nyuko/hallFairStatusChange/doDeleteConfirm?nyukoModeKbn=01&productId=%%ID%%';
    const FAIR_DELETE_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairStatusChange\/doDeleteConfirm\?nyukoModeKbn=01&productId=(\d+)/';
    const FAIR_DELETE_COMPLETE_URL = 'https://cszebra.zexy.net/nyuko/hallFairStatusChange/doDeleteComplete';
    const FAIR_DELETE_COMPLETE_PATTERN = '/^https:\/\/cszebra.zexy.net\/nyuko\/hallFairStatusChange\/complete\?nyukoModeKbn=61/';
    
    //画像
    const IMAGE_LIST_TOP = 'https://cszebra.zexy.net/config/photoAlbum/indexReference/';
    const IMAGE_LIST_TOP_PATTERN = '/^https:\/\/cszebra.zexy.net\/config\/photoAlbum\/indexReference\//';
    const IMAGE_LIST_URL = 'https://cszebra.zexy.net/config/photoAlbum/doSearch';
    const IMAGE_LIST_PATTERN = '/^https:\/\/cszebra.zexy.net\/config\/photoAlbum\/doSearch/';
    const IMAGE_PATTERN = '/\/z\/upload\/\d+\/\d{2}\/photo_album\/(\d+).jpg\?q=\d+/';
    //画像アップロード
    const IMAGE_UPLOAD_TOP_URL = 'https://cszebra.zexy.net/config/photoAlbumEdit/indexRegist';
    const IMAGE_UPLOAD_TOP_PATTERN = '/^https:\/\/cszebra.zexy.net\/config\/photoAlbumEdit\/indexRegist/';
    const IMAGE_UPLOAD_URL = 'https://cszebra.zexy.net/config/photoAlbumEdit/';
    const IMAGE_UPLOAD_PATTERN = '/^https:\/\/cszebra.zexy.net\/config\/photoAlbumEdit\//';
    const IMAGE_UPLOAD_CONFIRM_URL = 'https://cszebra.zexy.net/config/photoAlbumEdit/doUpload';
    const IMAGE_UPLOAD_CONFIRM_PATTERN = '/^https:\/\/cszebra.zexy.net\/config\/photoAlbumEdit\/doUpload/';
    const IMAGE_UPLOAD_REGIST_URL = 'https://cszebra.zexy.net/config/photoAlbumEdit/doRegist';
    const IMAGE_UPLOAD_REGIST_PATTERN = '/^https:\/\/cszebra.zexy.net\/config\/photoAlbumEdit\/doRegist/';
    
    const TOKEN_COLUMN_NAME = 'org.apache.struts.taglib.html.TOKEN';
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/zexy.txt';
    
    protected static $_loginParams = array(
        'userId' => '',
        'password' => '',
        'doLogin' => 'zebraにログイン',
        'newWindowOpen' => 'off',
    );
    
    protected static $_inputIframes = array(
        'fair_name' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairName?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
        'yoyaku_config' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairYoyakuUketsukeConfig?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
        'access_data' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairAccessData?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
        'fair_perk' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairPerk?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
        'free_question' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairFreeConfigQuestion?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
        'request_change' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairRequestChangeConfig?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
        'keisai_yotei' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairKeisaiYoteiKikan?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
        'fair_event' => array(
            'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairEvent?org.apache.struts.taglib.html.TOKEN=%%TOKEN%%',
            'https://cszebra.zexy.net/nyuko/hallFairRegist/doChangeFairEventDetail',
        ),
    );
    
    protected static $_editFrames = array(
        'fair_name' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairName',
        'yoyaku_config' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairYoyakuUketsukeConfig',
        'access_data' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairAccessData',
        'fair_perk' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairPerk',
        'free_question' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairFreeConfigQuestion',
        'request_change' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairRequestChangeConfig',
        'keisai_yotei' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairKeisaiYoteiKikan',
        'fair_event_1' => 'https://cszebra.zexy.net/nyuko/hallFairRegist/doReflectFairEventDetail',
    );
    
    /**
     * フェア内容と内部コードの引き合わせ
     * @var type 
     */
    public static $_fairCds = array(
        0 => '004',
        1 => '005',
        2 => '006',
        3 => '007',
        4 => '008',
        5 => '009',
        6 => '010',
        7 => '011',
        8 => '012',
        9 => '013',
    );
    
    
    /**
     * ログイン時に取得出来るトークン。
     * 取得出来なかった場合ログイン失敗扱い。
     * @var type 
     */
    protected $_token = '';
     
    protected function craeteLoginParams()
    {
        $params = self::$_loginParams;
        //ログインIDとパスワードをDBから取得
        $params['userId'] = $this->_login->login_id;
        $params['password'] = $this->_login->password;
        return $params;
    }
    
    protected function checkLoginResult() 
    {
        $info = $this->_curl->getInfo();
        if($info['http_code'] !== 200 || !preg_match('/^https:\/\/cszebra.zexy.net\/top\/*/',$info['url'])) {
            return false;
        }
        //tokenを取得
        $html = str_get_html($this->_curl->getExec());
        foreach($html->find('input') as $input) {
            if($input->name === self::TOKEN_COLUMN_NAME) {
                $this->_token = $input->value;
            }
            break;
        }
        //メモリ開放
        $html->clear();
        if(!$this->_token) {
            throw new WorkException(WorkException::CODE_ZEXY_TOKEN_NOTFOUND,$this->_curl);
        }
        return true;
    }
    
    public function getFairs($year,$month)
    {
        if(!$this->login(false)) {
            return false;
        }
        if($month < 1 || $month > 12) {
            $month = date('m');
        }
        if($year > 2038 || $year < date('Y')-1) {
            $year = date('Y');
        }
        $ym = $year.'-'.$month;
        $first = date('d', strtotime('first day of ' . $ym));
        $last = date('d',strtotime('last day of ' . $ym));
        $ids = array();
        try {
            for($d=$first;$d<=$last;++$d) {
                $ymd = date('Y/m/d',strtotime($ym."-".$d));
                $url = str_replace('%%YMD%%',$ymd,self::FAIR_LIST_URL);
                echo $url."<br/>\n";
                $this->_curl->addUrl($url);
                $this->run();
                $info = $this->_curl->getInfo();
                if($info['http_code']!==200 || !preg_match(self::FAIR_LIST_PATTERN,$info['url'])) {
                    throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
                }
                preg_match_all(self::FAIR_LIST_OUTPUT_LINK_PATTERN,$this->_curl->getExec(),$matches,PREG_SET_ORDER);
                //一覧取得が終わったのでリセット
                foreach($matches as $m) {
                    if(!in_array($m[1],$ids)) {
                        $ids[] = $m[1];
                    }
                }
                sleep(1);
            }
            var_dump($ids);
        } catch(Exception $e) {
            error_log($e);
            error_log("フェア取得処理失敗 > " . get_class($this));
            return false;
        }
        $this->close();
        return true;
    }
    
    public function getFairDetail($id,$chClose=true)
    {
        $id = 400013736257;
        if(!$this->login(false)) {
            return false;
        }
        $id = (int)$id;
        if(!$id) {
            throw new Exception('id is not number');
        }
        $url = str_replace('%%ID%%',$id,self::FAIR_EDIT_URL);
        echo $url."<br/>\n";
        $this->_curl->addUrl($url);
        try {
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200 || !preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            //データの取得
            $html = str_get_html($this->_curl->getExec());
            $inputs = $html->find('input');
            $ret = array();
            $token = '';
            foreach($inputs as $input) {
                if($input->name === 'org.apache.struts.taglib.html.TOKEN') {
                    $token = $input->value;
                } else {
                    $ret[$input->name] = $input->value;
                }
            }
            //開催日取得
            foreach($html->find("span#holdDate") as $span) {
                $ret['holdDateList'] = date("Y/m/d",strtotime(trim($span->plaintext)));
            }
            
            //画像ID取得
            $imgs = $html->find('div#img_preview_photoAlbum > div > img');
            $img = $imgs ? $imgs[0] : null;
            if($img) {
                $ret['photoAlbumId'] = call_user_func("end", explode('/', $img->src));
                $ret['photoAlbumId'] = explode(".",$ret['photoAlbumId'])[0];
            }
            //メモリ開放
            $html->clear();
            
            if($token) {
                //トークンが取得出来ないと各修正画面が取得出来ない
                foreach(self::$_inputIframes as $key => $_url) {
                    $list = array();
                    if(is_array($_url)) {
                        $list = $_url;
                        $_url = $_url[0];
                    }
                    $this->optionReset();
                    $url = str_replace('%%TOKEN%%',$token,$_url);
                    $this->_curl->addUrl($url);
                    $this->run();
                    $info = $this->_curl->getInfo();
                    if($info['http_code']!==200 || preg_match('/処理が続行できません/',$this->_curl->getExec())) {
                        error_log($info['http_code']);
                        error_log($info['url']);
                        throw new Exception('get failed > ' .$id . " > ".$key);
                    }
                    //データの取得
                    //input,select,textareaを取得
                    $retNew = $this->getDetailVal($this->_curl->getExec(), array());
                    $ret = $ret + $retNew;
                    sleep(1);
                    
                    //継続取得データ
                    for($i=1;$i<count($list);$i++) {
                        $url = $list[$i];
                        $this->optionReset();
                        $this->_curl->addUrl($this->createGetUrl($url,$retNew));
                        $this->_curl->methodPost();
                        $this->run();
                        if($info['http_code']!==200 || preg_match('/処理が続行できません/',$this->_curl->getExec())) {
                            error_log($info['http_code']);
                            error_log($info['url']);
                            throw new Exception('get failed > ' .$id . " > ".$key);
                            //データの取得
                            //input,select,textareaを取得
                            $retNew = $this->getDetailVal($this->_curl->getExec(), array());
                            $ret = $ret + $retNew;
                            sleep(1);
                        }
                    }
                }
            } else {
                throw new Exception('no token > ' .$id);
            }
            $work = WorkZexyFair::find($id);
            if(!$work) {
                $work = new WorkZexyFair();
                $work->id = $id;
            }
            $work->data = serialize($ret);
            $work->save();
        } catch (Exception $e) {
            error_log($e);
            error_log("get fair detail failed > " . get_class($this) . " id=".$id);
            return false;
        }
        if($chClose) {
            $this->close();
        }
        return true;
    }
    /**
     * フェアの登録を行う。
     * 3画面にそれぞれ入力していく必要がある。
     * @param int $id
     * @param type $chClose
     * @return boolean
     * @throws WorkException
     */
    public function addFair($id,$chClose=true)
    {
        $id = 400013736257;
        //ログイン
        if(!$this->login(false)) {
            return false;
        }
        try {
            $work = WorkZexyFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            
            //パラメータ
            $fairParams = array(
                self::TOKEN_COLUMN_NAME => '',
                'nyukoModeKbn' => '',
                'previewSize' => 'big',
            );
            $fairDetailParams = array(
                self::TOKEN_COLUMN_NAME => '',
                'previewSize' => 'big',
            );
            
            $fairEtcParams = array(
                self::TOKEN_COLUMN_NAME => '',
                'holdHall' => '0000115695',
                'nyukoModeKbn' => '01',
                'previewSize' => 'big',
                'keisaiStartDate' => date('Y/m/d', strtotime('+1 day')),
                'keisaiEndDate' => date('Y/m/d', strtotime('+1 day')),
            );
            
            //まず新規作成画面を開きTOKENを取得する
            $this->_curl->addUrl(self::FAIR_INPUT_URL);
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200 || !preg_match(self::FAIR_INPUT_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            //TOKEN取得
            $token = "";
            $html = str_get_html($this->_curl->getExec());
            foreach($html->find('input[type="hidden"]') as $input) {
                if($input->name === self::TOKEN_COLUMN_NAME) {
                    $token = $input->value;
                }
            }
            $html->clear();
            if(!$token) {
                throw new WorkException(WorkException::CODE_ZEXY_TOKEN_NOTFOUND,$this->_curl);
            }
            
            $fairParams[self::TOKEN_COLUMN_NAME] = $token;
            $fairDetailParams[self::TOKEN_COLUMN_NAME] = $token;
            $fairEtcParams[self::TOKEN_COLUMN_NAME] = $token;
            
            $list = array(
                1 => array(
                    'url' => self::FAIR_INPUT_DETAIL_URL,
                    'pattern' => self::FAIR_INPUT_DETAIL_PATTERN,
                    'params' => $fairParams,
                ),
                2 => array(
                    'url' => self::FAIR_INPUT_ETC_URL,
                    'pattern' => self::FAIR_INPUT_ETC_PATTERN,
                    'params' => $fairDetailParams,
                ),
                3 => array(
                    'url' => self::FAIR_CONFIRM_URL,
                    'pattern' => self::FAIR_CONFIRM_PATTERN,
                    'params' => $fairEtcParams,
                )
            );
            for($i=1;$i<4;$i++) {
                //1個1個処理していく
                
                //データチェック
                $validator = $this->getFairInputValidation($data,$i);
                if ($validator->fails()) {
                    $messages = json_decode($validator->messages());
                    foreach($messages as $key => $value) {
                        echo $key ." ： ".implode(",",$value). " ===> " . $data[$key] . "<br/>";
                    }
                    throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
                }
                //登録データ抽出
                $keys = array_keys($validator->getRules());
                foreach($keys as $key) {
                    if(isset($data[$key])) {
                        $list[$i]['params'][$key] = $data[$key];
                    }
                }
                if($i===1) {
                    //開催日付
                    $list[$i]['params']['holdDateList'] = $data['holdDateList'];
                }
                
                //登録
                $row = $list[$i];
                $this->optionReset();
                $this->_curl->addUrl($this->createGetUrl($row['url'],$row['params']));
                $this->_curl->methodPost();
                $this->run();
                if($this->_curl->getInfo()['http_code']!==200 || !preg_match($row['pattern'],$this->_curl->getInfo()['url']) || preg_match('/入力エラー/',$this->_curl->getExec())) {
                    //var_dump($list[$i]['params']);
                    //echo $this->_curl->getExec();
                    throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
                }
                if($i === 2) {
                    preg_match_all('/var([a-zA-Z0-9]+)_0000115695="([^"]*)";/s',preg_replace('/[\r|\n|\t|\s]+/','',$this->_curl->getExec()),$matches,PREG_SET_ORDER);
                    foreach($matches as $m) {
                        $list[3]['params'][$m[1]] = $m[2];
                    }
                }
            }
            //echo $this->_curl->getExec();
            //登録完了
            $params = array(
                self::TOKEN_COLUMN_NAME => $token,
                'previewSize' => 'big',
            );
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_REGIST_URL,$params));
            $this->_curl->methodPost();
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200 || !preg_match(self::FAIR_COMPLETE_PATTERN,$this->_curl->getInfo()['url']) || preg_match('/入力エラー/',$this->_curl->getExec())) {
                var_dump($params);
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
        } catch (Exception $e) {
            error_log($e);
            return false;
        }
        if($chClose) {
            $this->close();
        }
        return true;
    }
    
    public function updateFair($id,$chClose=true)
    {
        $id = 400013736257;
        //ログイン
        if(!$this->login(false)) {
            return false;
        }
        try {
            $work = WorkZexyFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            //更新データだけ抽出
            $updateData = array(
                'fairNm' => $data['fairNm']."+",
            );
            $id = 400014129716;
            
            //まず編集画面を開きTOKENを取得する
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200 || !preg_match(self::FAIR_EDIT_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            //TOKEN取得
            $token = "";
            $html = str_get_html($this->_curl->getExec());
            foreach($html->find('input[type="hidden"]') as $input) {
                if($input->name === self::TOKEN_COLUMN_NAME) {
                    $token = $input->value;
                }
            }
            $html->clear();
            if(!$token) {
                throw new WorkException(WorkException::CODE_ZEXY_TOKEN_NOTFOUND,$this->_curl);
            }
            echo $token."<br/>";
            
            foreach(self::$_editFrames as $key => $url) {
                $validator = WorkZexyValidation::getFairUpdateValidation($updateData, $key);
                if ($validator && $validator->fails()) {
                    $failed = false;
                    $messages = json_decode($validator->messages());
                    foreach($messages as $key => $value) {
                        if(isset($updateData[$key])) {
                            echo $key ." ： ".implode(",",$value). " ===> " . isset($updateData[$key]) ? $updateData[$key] : '[not found]' . "<br/>";
                            $failed = true;
                        }
                    }
                    if($failed) {
                        throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
                    }
                }
                //登録データ抽出
                
                $params = array(
                    self::TOKEN_COLUMN_NAME => $token,
                );
                $update = false;
                if($key !== 'keisai_yotei') {
                    $keys = array_keys($validator->getRules());
                } else {
                    $keys = array('keisaiStartDate','keisaiEndDate');
                }
                foreach($keys as $key) {
                    if(isset($updateData[$key])) {
                        $params[$key] = $updateData[$key];
                        $update = true;
                    } else if (isset($data[$key])) {
                        $params[$key] = $data[$key];
                    }
                }
                if(!$update) {
                    continue;
                }
                
                //更新
                $this->optionReset();
                $this->_curl->addUrl($this->createGetUrl($url,$params));
                $this->_curl->methodPost();
                $this->run();
                if($this->_curl->getInfo()['http_code']!==200 || preg_match('/入力エラー/',$this->_curl->getExec()) || preg_match('/処理が続行できません/',$this->_curl->getExec())) {
                    echo $this->_curl->getExec();
                    throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
                }
            }
            //echo $this->_curl->getExec();
            //更新完了
            $params = array(
                self::TOKEN_COLUMN_NAME => $token,
                'nyukoModeKbn' => '01',
            );
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_EDIT_COMPLETE_URL,$params));
            $this->_curl->methodPost();
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200 || !preg_match(self::FAIR_COMPLETE_PATTERN,$this->_curl->getInfo()['url']) || preg_match('/処理が続行できません/',$this->_curl->getExec())) {
                var_dump($params);
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
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
    
    public function deleteFair($id,$chClose=true)
    {
        $id = 400014129716;
        //ログイン
        if(!$this->login(false)) {
            return false;
        }
        try {
            //まず削除画面を開きTOKENを取得する
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_DELETE_URL));
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200 || !preg_match(self::FAIR_DELETE_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
            //TOKEN取得
            $token = "";
            $html = str_get_html($this->_curl->getExec());
            foreach($html->find('input[type="hidden"]') as $input) {
                if($input->name === self::TOKEN_COLUMN_NAME) {
                    $token = $input->value;
                }
            }
            $html->clear();
            if(!$token) {
                throw new WorkException(WorkException::CODE_ZEXY_TOKEN_NOTFOUND,$this->_curl);
            }
            
            //削除完了
            $params = array(
                self::TOKEN_COLUMN_NAME => $token,
                'productId' => $id,
                'nyukoModeKbn' => '61',//削除
            );
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_DELETE_COMPLETE_URL,$params));
            $this->_curl->methodPost();
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200 || !preg_match(self::FAIR_DELETE_COMPLETE_PATTERN,$this->_curl->getInfo()['url']) || preg_match('/処理が続行できません/',$this->_curl->getExec())) {
                var_dump($params);
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
            
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
        //まとめて予約受付ON
        if(isset($data['packYoyakuFlg'])) {
            for($i=0;$i<10;++$i) {
                if(isset($data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"])) {
                    //予約区分は「要予約」に
                    $data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] = $data["packYoyakuKbn"];
                }
            }
        }
        //フェアの時間データ生成
        for($i=0;$i<10;++$i) {
            if(isset($data["hallFairTkchRegistDtoList[$i].fairTkchCd"])) {
                $data["hallFairTkchRegistDtoList[$i].fairTkchCd"] = self::$_fairCds[$i];
                if(!isset($data["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[0].startHour"])) {
                    $data["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[0].startHour"] = "";
                    $data["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[0].startMinute"] = "";
                    $data["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[0].endHour"] = "";
                    $data["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[0].endMinute"] = "";
                }
            }
        }
        //会場
        if(isset($data['holdHall']) && $data['holdHall'] == 'ikou_') {
            $data['holdHall'] = '0000115695';
        }
        
        //テストデータ加工
        if(App::environment("testing")) {
            if(mb_strlen($data['fairNm']) < 100) {
                $data['fairNm'].= "_";
            }
            $data["holdDateList"] = array('2014/11/29','2014/11/30');
        }
        
        return $data;
    }
    
     /**
     * フェア登録をする際のValidate内容
     * @param type $data
     * @return Validation
     */
    public function getFairInputValidation($data,$type=1)
    {
        switch($type) {
            case 3:
                return $this->getFairInputValidationEtc($data);
                break;
            case 2:
                return $this->getFairInputValidationDetail($data);
                break;
            case 1:
            default:
                return $this->getFairInputValidationDefault($data);
        }
    }
    
    /**
     * フェア入力画面でのValidate
     * @param type $data
     * @return Validator
     */
    private function getFairInputValidationDefault($data)
    {
        $hour  = array();
        $min   = array();
        $min5  = array();
        for($i=0;$i<60;++$i){
            if($i<24) {
                $hour[] = $i;
            }
            if($i%5===0) {
                $min5[] = $i;
            }
            $min[] = $i;
        }
        $hour = implode(",",$hour);
        $min =  implode(",",$min);
        $min5 = implode(",",$min5);
                
        $v = array(
            'fairStartHour' => array('required','numeric','in:'.$hour),
            'fairStartMinute' => array('required','numeric','in:'.$min),
            'fairEndHour' => array('required','numeric','in:'.$hour),
            'fairEndMinute' => array('required','numeric','in:'.$min),
            'requiredMinute' => array('numeric','between:0,999'),
            'secretFlg' => array('required','numeric','in:0,1'),
            'headFairFlg' => array('numeric','in:1'),
            'fairNm' => array('required','mb_max:30'),
            'mainCatch' => array('required','mb_max:100'),
            'tourFlg' => array('numeric','in:1'),
            'packYoyakuFlg' => array('numeric','in:1'),
            'packYoyakuKbn' => array('in:02,03'),
            'packYoyakuRealTimeYoyakuUnitKbn' => array('in:01,02'),
            'packYoyakuUketsukeCnt' => array('numeric','between:1,99999'),
            'photoAlbumId' => array("numeric"),
        );
        //複数部の場合
        for($i=0;$i<=4;++$i) {
            $v["tourRegistDtoList[$i].tourPart"] = array('numeric','between:1,5');
            $v["tourRegistDtoList[$i].tourStartHour"] = array('numeric','in:'.$hour);
            $v["tourRegistDtoList[$i].tourStartMinute"] = array('numeric','in:'.$min5);
            $v["tourRegistDtoList[$i].tourEndHour"] = array('numeric','in:'.$hour);
            $v["tourRegistDtoList[$i].tourEndMinute"] = array('numeric','in:'.$min5);
        }
        //フェア内容
        for($i=0;$i<=9;++$i) {
            $v["hallFairTkchRegistDtoList[$i].fairTkchCd"] = array('in:'.self::$_fairCds[$i]);
            if($i>=8) {
                $v["hallFairTkchRegistDtoList[$i].fairTkchEtcNm"] = array('mb_max:200',"required_with:hallFairTkchRegistDtoList[$i].fairTkchCd");
            }
            $v["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] = array('in:01,02,03','required_without:packYoyakuFlg');
            $v["hallFairTkchRegistDtoList[$i].yuryoFlg"] = array('numeric','in:0,1',"required_with:hallFairTkchRegistDtoList[$i].fairTkchCd");
            $v["hallFairTkchRegistDtoList[$i].realTimeYoyakuUnitKbn"] = array('in:01,02');
            $v["hallFairTkchRegistDtoList[$i].entryNinzu"] = array('numeric','between:0,999');
            $v["hallFairTkchRegistDtoList[$i].entryCharge"] = array('numeric');
            $v["hallFairTkchRegistDtoList[$i].detail"] = array('mb_max:100');
        }
        return Validator::make($data,$v);
    }
    
    /**
     * フェア詳細入力でのValidate
     * @param type $data
     * @return Validator
     */
    private function getFairInputValidationDetail($data)
    {
        $hour  = array();
        $min5  = array();
        for($i=0;$i<60;++$i){
            if($i<24) {
                $hour[] = $i;
            }
            if($i%5===0) {
                $min5[] = $i;
            }
        }
        $hour = implode(",",$hour);
        $min5 = implode(",",$min5);
                
        $v = array(
            'packYoyakuRealTimeYoyakuUnitKbn' => array('in:01,02'),
            'packYoyakuUketsukeCnt' => array('numeric','between:1,99999'),
        );
        //フェア内容
        for($i=0;$i<=9;++$i) {
            if(isset($data["hallFairTkchRegistDtoList[$i].fairTkchCd"])) {
                $v["hallFairTkchRegistDtoList[$i].fairTkchCd"] = array('in:'.self::$_fairCds[$i]);
                if($i>=8) {
                    $v["hallFairTkchRegistDtoList[$i].fairTkchEtcNm"] = array('mb_max:200',"required_with:hallFairTkchRegistDtoList[$i].fairTkchCd");
                }
                $v["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] = array('in:01,02,03','required_without:packYoyakuFlg');
                $v["hallFairTkchRegistDtoList[$i].yuryoFlg"] = array('numeric','in:0,1',"required_with:hallFairTkchRegistDtoList[$i].fairTkchCd");
                $v["hallFairTkchRegistDtoList[$i].realTimeYoyakuUnitKbn"] = array('in:01,02');
                $v["hallFairTkchRegistDtoList[$i].entryNinzu"] = array('numeric','between:0,999');
                $v["hallFairTkchRegistDtoList[$i].entryCharge"] = array('numeric');
                $v["hallFairTkchRegistDtoList[$i].detail"] = array('mb_max:100');
                //開催時間
                for($t=0;$t<12;++$t) {
                    $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startHour"] = array('numeric','in:'.$hour);
                    $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].startMinute"] = array('numeric','in:'.$min5);
                    $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endHour"] = array('numeric','in:'.$hour);
                    $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].endMinute"] = array('numeric','in:'.$min5);
                    $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].title"] = array('mb_max:100');
                    if(isset($data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"]) && $data["hallFairTkchRegistDtoList[$i].fairYoyakuShubetsuCd"] == '03') {
                        //要予約、予約優先の場合のみ
                        $v["hallFairTkchRegistDtoList[$i].hallHoldTimeRegistDtoList[$t].yoyakuCnt"] = array('numeric','between:0,99999');
                    }
                }
            }
        }
        return Validator::make($data,$v);
    }
    
    /**
     * フェア詳細入力でのValidate
     * @param type $data
     * @return Validator
     */
    private function getFairInputValidationEtc($data)
    {
        $v = array(
            'fairPerkNaiyo' => array('mb_max:50'),
            'fairPerkPeriod' => array('mb_max:50'),
            'fairPerkRemarks' => array('mb_max:50'),
            'freeConfigQuestion' => array('mb_max:200'),
            'freeConfigAnswerMustFlg' => array('numeric',"in:1"),
            'holdHall' => array('numeric'),
            'inputAddress' => array('required','mb_max:100'),
            'parking' => array('mb_max:50'),
            'targetPerson' => array('mb_max:50'),
            'etc' => array('mb_max:100'),
            'tel11' => array('required','max:4'),
            'tel21' => array('required','max:11'),
            'tel31' => array('required','max:11'),
            'telShubetsuKbn1' => array('numeric','in:0,1'),
            'telTantoNm1' => array('max:100'),
            'tel12' => array('max:4'),
            'tel22' => array('max:11'),
            'tel32' => array('max:11'),
            'telShubetsuKbn2' => array('numeric','in:0,1,2'),
            'telTantoNm2' => array('mb_max:100'),
            'toiawase' => array('mb_max:50'),
            'tanto' => array('mb_max:50'),
            'yoyakuUketsukeHowKbn' => array('numeric','in:1,2'),
            'yoyakuUketsukePossibleNissuNet' => array('numeric','between:0,99'),
            'yoyakuUketsukeEndTimeNet' => array('numeric','in:10,12,14,16,18,20,22,24'),
            'yoyakuUketsukePossibleNissuTel' => array('numeric','between:0,99'),
        );
        return Validator::make($data,$v);
    }
    
    /**
     * imagesの指定IDのSC画像情報を元にZexyに画像をアップロードする。
     * アップロードするとimagesにzexy_idが追加される。
     * また、work_zexy_imagesに、取得したzexy_idを元にレコードが追加される。
     * @param int $id images.id
     * @param bool $chClose
     * @return boolean
     * @throws WorkException
     */
    public function uploadImages($id,$chClose=true)
    {
        //ログイン
        if(!$this->login(false)) {
            return false;
        }
        try {
            $image = Image::findOrFail($id);
            //まず接続
            $this->_curl->addUrl(self::IMAGE_LIST_TOP);
            $this->run();
            if($this->_curl->getInfo('http_code')!==200 || !preg_match(self::IMAGE_LIST_TOP_PATTERN,$this->_curl->getInfo('url'))) {
                throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
            }
            $this->_curl->addUrl(self::IMAGE_UPLOAD_TOP_URL);
            $this->run();
            if($this->_curl->getInfo('http_code')!==200 || !preg_match(self::IMAGE_UPLOAD_TOP_PATTERN,$this->_curl->getInfo('url'))) {
                throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
            }
            
            //画像アップ処理
            $filepath = $image->getFilePath();
            $fileInfo = new FInfo(FILEINFO_MIME_TYPE);
            //PHP5.5から使える憎いやつ
            $curlFile = new CurlFile($filepath,$fileInfo->file($filepath),$image->getFileName());
            
            $imgParams = array(
                'doAjaxUpload' => '1',
                'photoFile' => $curlFile,
            );
            
            $this->_curl->addUrl(self::IMAGE_UPLOAD_URL);
            $this->_curl->addPostParams($imgParams);
            $this->run();
            if($this->_curl->getInfo('http_code')!==200) {
                throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
            }
            $ret = json_decode($this->_curl->getExec());
            if(!$ret || !$ret->result) {
                throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
            }
            //他情報入力
            $params = array(
                'cropWidth' => '',
                'cropHeight' => '',
                'cropOffsetX' => '',
                'cropOffsetY' => '',
                'photoTitle' => 'sc_image_id='.$image->id,
                'photoCaption' => 'テスト画像です。後程削除します。',
                'photoKbn' => sprintf('%02d',$image->zexy_photo_kbn),
            );
            $this->optionReset();
            $this->_curl->addUrl(self::IMAGE_UPLOAD_CONFIRM_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            if($this->_curl->getInfo('http_code')!==200 || !preg_match(self::IMAGE_UPLOAD_CONFIRM_PATTERN,$this->_curl->getInfo('url'))) {
                throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
            }
            $this->_curl->addUrl(self::IMAGE_UPLOAD_REGIST_URL);
            $this->_curl->methodPost();
            $this->run();
            if($this->_curl->getInfo('http_code')!==200) {
                throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
            }
            //ID取得処理
            $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
            foreach($html->find('td.vaTop') as $td) {
                $table = $td->find('table')[0];
                $photoId = $photoTitle = $photoCaption = $photoFileUrl = null;
                foreach($table->find('input') as $input) {
                    switch($input->name){
                        case 'photoAlbumId':
                            $photoId = (int)$input->value;
                            break;
                        case 'photoTitle':
                            $photoTitle = $input->value;
                            break;
                        case 'photoCaption':
                            $photoCaption = $input->value;
                            break;
                        case 'photoFileUri':
                            $photoFileUrl = $input->value;
                            break;
                        default:
                            break;
                    }
                }
                if($photoTitle !== 'sc_image_id='.$id) {
                    continue;
                }
                if(!$photoId) {
                    throw new WorkException(WorkException::CODE_IMAGE_GET_FAILED,$this->_curl);
                }
                $work = WorkZexyImage::find($photoId);
                if(!$work) {
                    $work = new WorkZexyImage();
                }
                $work->id = $photoId;
                $work->photo_title = $photoTitle;
                $work->photo_caption = $photoCaption;
                $work->photo_kbn = $image->zexy_photo_kbn;
                //画像取得
                $filename = $photoId . ".jpg";
                $this->optionReset();
                $url = self::BASE_URL . $photoFileUrl;
                $this->_curl->addUrl($url);
                $this->run();
                if($this->_curl->getInfo('http_code')==200) {
                    file_put_contents($this->getImgPath($filename) , $this->_curl->getExec());
                }
                //保存
                $work->save();
                //imagesも更新
                $image->zexy_id = $photoId;
                $image->save();
                break;
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
     * 画像取得処理
     * @param type $chClose
     * @return boolean
     * @throws WorkException
     */
    public function getImages($startPage=0,$kbn=1,$chClose = true)
    {
        //ログイン
        if(!$this->login(false)) {
            return false;
        }
        $page = $startPage;
        $kbn = in_array($kbn,array(1,2,3)) ? $kbn : 1;
        $end = false;
        try {
            while(true) {
                //まずTOPへアクセス
                $this->_curl->addUrl(self::IMAGE_LIST_TOP);
                $this->run();
                if($this->_curl->getInfo('http_code')!==200 || !preg_match(self::IMAGE_LIST_TOP_PATTERN,$this->_curl->getInfo('url'))) {
                    throw new WorkException(WorkException::CODE_IMAGE_GET_FAILED,$this->_curl);
                }
                //ページXの一覧取得
                $params = array(
                    'kbn' => sprintf("%02d",$kbn),
                    'pn' => $page,
                );
                $this->_curl->addUrl(self::IMAGE_LIST_URL);
                $this->_curl->addPostParams($params);
                $this->run();
                if($this->_curl->getInfo('http_code')!==200 || !preg_match(self::IMAGE_LIST_PATTERN,$this->_curl->getInfo('url'))) {
                    throw new WorkException(WorkException::CODE_IMAGE_GET_FAILED,$this->_curl);
                }
                //必要データをかき集める
                $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
                foreach($html->find('td.vaTop') as $td) {

                    $count = 0;
                    $table = $td->find('table')[0];
                    $photoId = $photoTitle = $photoCaption = $photoFileUrl = null;
                    foreach($table->find('input') as $input) {
                        echo $input."\n";
                        switch($input->name){
                            case 'photoAlbumId':
                                $photoId = (int)$input->value;
                                break;
                            case 'photoTitle':
                                $photoTitle = $input->value;
                                break;
                            case 'photoCaption':
                                $photoCaption = $input->value;
                                break;
                            case 'photoFileUri':
                                $photoFileUrl = $input->value;
                                break;
                            default:
                                break;
                        }
                    }
                    if(!$photoId) {
                        throw new WorkException(WorkException::CODE_IMAGE_GET_FAILED,$this->_curl);
                    }
                    $image = WorkZexyImage::find($photoId);
                    if(!$image) {
                        $image = new WorkZexyImage();
                    }
                    $image->id = $photoId;
                    $image->photo_title = $photoTitle;
                    $image->photo_caption = $photoCaption;
                    $image->photo_kbn = $kbn;
                    //画像取得
                    $filename = $photoId . ".jpg";
                    $this->optionReset();
                    $url = self::BASE_URL . $photoFileUrl;
                    $this->_curl->addUrl($url);
                    $this->run();
                    if($this->_curl->getInfo('http_code')==200) {
                        file_put_contents($this->getImgPath($filename) , $this->_curl->getExec());
                    }
                    //保存
                    $image->save();
                }
                //終了判定
                $divs = $html->find('div.sf');
                if(!$divs) {
                    throw new WorkException(WorkException::CODE_IMAGE_GET_FAILED,$this->_curl);
                }
                $max = $now = null;
                foreach($divs[0]->find('span') as $span) {
                    if(preg_match('/(\d+)件中 \d+ - (\d+)件を表示/',$span->innertext(),$m)) {
                        $max = (int)$m[1];
                        $now = (int)$m[2];
                    }
                }
                if($max === $now) {
                    $end = true;
                }
                $html->clear();
                if($end) {
                    error_log("end");
                    break;
                }
                ++$page;
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
}