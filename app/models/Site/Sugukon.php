<?php
/**
 * すぐ婚naviからフェア情報の取得・登録等をするClass
 * 
 * すぐ婚はログイン時にランダム英数字26文字で構成されるsaという値が必要になる。
 * ログアウトするまでその文字列を引き回し続ける必要があるので注意。
 * 
 */
class SiteSugukon extends Site {
    /**
     * site_logins.idの値
     */
    const SITE_LOGIN_ID = 6;
    const DIR_NAME = "sugukon";
    
    const BASE_URL = 'https://sugukon.com';
    const LOGIN_URL = 'https://sugukon.com/admin/auth/login';
    const LOGOUT_URL = 'https://sugukon.com/admin/auth/logout?sa=%%sa%%';
    
    //フェア一覧
    const FAIR_LIST_URL = 'https://sugukon.com/admin/fair/index/page/%%PAGE%%?&sa=%%SA%%';
    const FAIR_LIST_PATTERN = '/^https:\/\/sugukon.com\/admin\/fair\/index\/page\/(\d+)\?\&sa=([a-z0-9]{26})/';
    const FAIR_LIST_OUTPUT_LINK_PATTERN = '/\/admin\/fair\/edit\/fair_id\/(\d+)\?sa=[a-z0-9]{26}/';
    const FAIR_EDIT_URL = 'https://sugukon.com/admin/fair/edit/fair_id/%%ID%%?sa=%%SA%%';
    const FAIR_EDIT_PATTERN = '/^https:\/\/sugukon.com\/admin\/fair\/edit\/fair_id\/(\d+)\?sa=[a-z0-9]{26}/';
    //フェア登録
    const FAIR_INPUT_URL = 'https://sugukon.com/admin/fair/input?sa=%%SA%%';
    const FAIR_INPUT_PATTERN = '/^https:\/\/sugukon.com\/admin\/fair\/input\?sa=[a-z0-9]{26}/';
    //確認
    const FAIR_CONFIRM_URL = 'https://sugukon.com/admin/fair/dispatch';
    const FAIR_CONFIRM_PATTERN = '/^https:\/\/sugukon.com\/admin\/fair\/dispatch/';
    //確定
    const FAIR_REGIST_URL = 'https://sugukon.com/admin/fair/update';
    const FAIR_REGIST_PATTERN = '/^https:\/\/sugukon.com\/admin\/fair\/list\?sa=[a-z0-9]{26}/';
    //削除
    const FAIR_DELETE_URL = 'https://sugukon.com/admin/fair/delete/fair_id/%%ID%%?sa=%%SA%%';
    
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/sugukon.txt';
    
    protected $_sa = '';
    
    protected static $_loginParams = array(
        'authLogin[login_id]' => '',
        'authLogin[password]' => '',
        'sa' => '',//26文字の英数字ランダム文字列
    );
    
    protected function craeteLoginParams()
    {
        $params = self::$_loginParams;
        //ログインIDとパスワードをDBから取得
        $params['authLogin[login_id]'] = $this->_login->login_id;
        $params['authLogin[password]'] = $this->_login->password;
        $params['sa'] = $this->_sa = strtolower(Str::random(26));
        return $params;
    }
    
    protected function checkLoginResult() 
    {
        $info = $this->_curl->getInfo();
        if($info['http_code'] !== 200 || !preg_match('/sugukon.com\/admin\/page\/top\//',$info['url'])) {
            return false;
        }
        return true;
    }
    
    /**
     * 更新ページを抜ける処理
     * @return boolean
     * @throws WorkException
     */
    public function logout()
    {
        if(!$this->_logined) {
            return true;
        }
        try {
            $this->optionReset();
            $this->_curl->addUrl(str_replace("%%SA%%",$this->_sa,self::LOGOUT_URL));
            $this->run();
            $info = $this->_curl->getInfo();
            //echo $this->_curl->getExec();
            if($info['http_code']!==200) {
                throw new WorkException(WorkException::CODE_LOGOUT_FAILED,$this->_curl);
            }
        } catch(Exception $e) {
            error_log($e);
            return false;
        }
        $this->_logined = false;
        return true;
    }
    
    public function getFairs($year,$month)
    {
        //ログイン
        if(!$this->login(false)) {
            return;
        }
        try {
            $page = 1;
            $url = str_replace('%%PAGE%%',$page, str_replace('%%SA%%',$this->_sa,self::FAIR_LIST_URL));
            $this->_curl->addUrl($url);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200||!preg_match(self::FAIR_LIST_PATTERN,$info['url'])) {
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
    
    public function getFairDetail($id, $chClose = true) {
        //ログイン
        if(!$this->login(false)) {
            return;
        }
        $id = 92;
        
        $id = (int)$id;
        if(!$id) {
            throw new Exception('id is not number');
        }
        try {
            $url = str_replace('%%ID%%', $id, str_replace('%%SA%%',$this->_sa,self::FAIR_EDIT_URL));
            $this->_curl->addUrl($url);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200||!preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            //input,select,textareaを取得
            $ret = $this->getDetailVal($this->_curl->getExec(), array());
            
            //その他情報の取得
            $html = str_get_html($this->_curl->getExec());
            //開催日取得 JSで作ってるっぽいので本文解析してJSONを抜き取る
            $check_str = preg_replace('/[\r|\n|\t|\s]+/','',$this->_curl->getExec());
            if(preg_match('/{selected:"(([0-9]{2}\/[0-9]{2}\/[0-9]{4}),{0,1})*"}/s',preg_replace('/[\r|\n|\t|\s]+/','',$this->_curl->getExec()),$m)) {
                preg_match_all('/([0-9]{2}\/[0-9]{2}\/[0-9]{4})/',$m[0],$cals,PREG_SET_ORDER);
                $i = 0;
                foreach($cals as $c) {
                    $ret["date[$i]"] = date('Y/m/d',strtotime($c[1]));
                    ++$i;
                }
            }
            
            //画像取得
            $imgs = $html->find('div.table_wrapper_inner > img');
            $img = $imgs ? $imgs[0] : null;
            if($img) {
                $ret['image'] = preg_replace("/\?\d+/",'',call_user_func("end", explode('/', $img->src)));
                $this->optionReset();
                $this->_curl->addUrl(self::BASE_URL . $img->src);
                $this->run();
                if($this->_curl->getInfo()['http_code']==200) {
                    file_put_contents($this->getImgPath($ret['image']) , $this->_curl->getExec());
                }
            }
            $work = WorkSugukonFair::find($id);
            if(!$work) {
                $work = new WorkSugukonFair();
                $work->id = $id;
            }
            $work->data = serialize($ret);
            $work->save();
        } catch (Exception $e) {
            error_log($e);
            return false;
        }
        if($chClose) {
            $this->close();
        }
        return true;
    }
    
    public function addFair($id,$chClose=true)
    {
        $id = 92;
        
        if(!$this->login(false)) {
            return false;
        }
        $success = false;
        try {
            $params = array(
                'sa' => $this->_sa,
            );
            $work = WorkSugukonFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            //データチェック
            $validator = WorkSugukonValidation::getFairInputValidation($data);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value). " ===> " .$data[$key] . "<br/>";
                }
                return false;
            }
            //登録データ抽出
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($data[$key])) {
                    $params[$key] = $data[$key];
                } else if(preg_match('/^reserve_time_fix/',$key)) {
                    $params[$key] = '';
                }
            }
            
            $files = array();
            if(isset($data['image'])) {
                $files = $this->build_postfield_files(array('image'=>$this->getImgPath($data['image'])));
            }
            
            //---- 確認ページへPOST ----//
            //boundary作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            $body = $this->multipart_build_query($params, $boundary,$files);
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
            //---- 登録ページへPOST ----//
            if(isset($params['draft'])) {
                $params = array(
                    'sa' => $this->_sa,
                    'commit' => '    下書き保存    ',
                );
            } else {
                $params = array(
                    'sa' => $this->_sa,
                    'commit' => '登録',
                );
            }
            
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_REGIST_URL, $params));
            $this->_curl->methodPost();
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_REGIST_PATTERN,$info['url'])) {
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
            $success = true;
            
        } catch (Exception $e) {
            error_log($e);
        }
        if($chClose) {
            $this->logout();
        }
        return $success;
    }
    
    public function updateFair($id,$chClose=true)
    {
        //ログイン
        if(!$this->login(false)) {
            return;
        }
        $id = 93;
        $success = false;
        try {
            $updateData = array(
                'title' => 'ウエディングフェアが初めての方へ♪【平日】+',
            );
            // 存在確認&データ取得
            $url = str_replace('%%ID%%', $id, str_replace('%%SA%%',$this->_sa,self::FAIR_EDIT_URL));
            $this->_curl->addUrl($url);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200||!preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            //input,select,textareaを取得
            $params = $this->getDetailVal($this->_curl->getExec(), array());
            $dates = array();
            //その他情報の取得
            $html = str_get_html($this->_curl->getExec());
            //開催日取得 JSで作ってるっぽいので本文解析してJSONを抜き取る
            $check_str = preg_replace('/[\r|\n|\t|\s]+/','',$this->_curl->getExec());
            if(preg_match('/{selected:"(([0-9]{2}\/[0-9]{2}\/[0-9]{4}),{0,1})*"}/s',preg_replace('/[\r|\n|\t|\s]+/','',$this->_curl->getExec()),$m)) {
                preg_match_all('/([0-9]{2}\/[0-9]{2}\/[0-9]{4})/',$m[0],$cals,PREG_SET_ORDER);
                $i = 0;
                foreach($cals as $c) {
                    $time = strtotime($c[1]);
                    if($time >= strtotime(date('Y/m/d'))) {
                        $params["date[$i]"] = $dates["date[$i]"] = date('Y/m/d',$time);
                        ++$i;
                    }
                }
            }
            foreach($updateData as $key => $value) {
                $params[$key] = $value;
            }
            
            if(App::environment("testing")) {
                $params['draft'] = '下書き保存';
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
            $this->_curl->addUrl(self::FAIR_CONFIRM_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            
            $info = $this->_curl->getInfo();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_CONFIRM_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            //---- 登録ページへPOST ----//
            if(isset($params['draft'])) {
                $params = array(
                    'sa' => $this->_sa,
                    'commit' => '    下書き保存    ',
                );
            } else {
                $params = array(
                    'sa' => $this->_sa,
                    'commit' => '更新',
                );
            }
            foreach($dates as $key => $value) {
                $params[$key] = $value;
            }
            
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_REGIST_URL, $params));
            $this->_curl->methodPost();
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_REGIST_PATTERN,$info['url'])) {
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
            $success = true;
            
        } catch (Exception $e) {
            error_log($e);
        }
        if($chClose) {
            $this->logout();
        }
        return $success;
    }
    
    public function deleteFair($id,$chClose=true)
    {
        //ログイン
        if(!$this->login(false)) {
            return;
        }
        $id = 93;
        $success = false;
        try {
            // 削除処理
            $url = str_replace('%%ID%%', $id, str_replace('%%SA%%',$this->_sa,self::FAIR_DELETE_URL));
            $this->_curl->addUrl($url);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200||!preg_match(self::FAIR_REGIST_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_DELETE_FAILED,$this->_curl);
            }
            $success = true;
        } catch (Exception $e) {
            error_log($e);
        }
        if($chClose) {
            $this->logout();
        }
        return $success;
    }
    
    public function formatInputData($data)
    {
        //テストデータ加工
        if(App::environment("testing")) {
            if(mb_strlen($data['title']) < 39) {
                $data['title'] = $data['title'] . "_t";
            }
            $data['draft'] = '下書き保存';
            //$params['input'] = '上記内容でフェアを掲載する';
        }
        return $data;
    }
}