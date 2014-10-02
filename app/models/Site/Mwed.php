<?php
/**
 * みんなのウェディングのWeb管理画面より
 * データ収集や登録を行う
 * 
 * 文字コードがSJISとなるので注意
 */
class SiteMwed extends Site {
    /**
     * site_logins.idの値
     */
    const SITE_LOGIN_ID = 1;
    const DIR_NAME = 'mwed';
    
    const BASE_URL = 'https://b.mwed.jp';
    //ログイン
    const LOGIN_URL = 'https://b.mwed.jp';
    //ログアウト
    const LOGOUT_URL = 'https://b.mwed.jp/_lo';
    //フェア一覧
    const FAIR_LIST_URL = 'https://b.mwed.jp/_fair_ml?_CID=1107&month=%%Yn%%';
    const FAIR_LIST_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_ml\?_CID=1107&month=\d{5,6}/';
    const FAIR_LIST_OUTPUT_LINK_PATTERN = '/_fair_d\?_CID=1107&fair_id=(\d+)/';
    const FAIR_DETAIL_URL = 'https://b.mwed.jp/_fair_d?_CID=1107&fair_id=%%ID%%';
    const FAIR_DETAIL_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_d\?_CID=1107&fair_id=(\d+)/';
    const FAIR_EDIT_URL = 'https://b.mwed.jp/_fair_i?_CID=1107&fair_id=%%ID%%';
    const FAIR_EDIT_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_i\?_CID=1107&fair_id=(\d+)/';
    //フェア登録
    const FAIR_INPUT_URL = 'https://b.mwed.jp/_fair_i';
    const FAIR_INPUT_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_i/';
    const FAIR_CONFIRM_URL = 'https://b.mwed.jp/_fair_c';
    const FAIR_CONFIRM_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_c/';
    const FAIR_REGIST_URL = 'https://b.mwed.jp/_fair_s';
    const FAIR_REGIST_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_s/';
    const IMAGE_UPLOAD_URL = 'https://b.mwed.jp/_imageUpload?type=fair&size=6&_CID=1107';
    //フェア削除
    const FAIR_DELETE_URL = 'https://b.mwed.jp/_fair_e?_CID=1107&fair_id=%%ID%%';
    const FAIR_DELETE_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_e\?_CID=1107&fair_id=(\d+)/';
    //フェア掲載停止
    const FAIR_SW_URL = 'https://b.mwed.jp/_fair_sw';
    const FAIR_SW_PATTERN = '/^https:\/\/b.mwed.jp\/_fair_sw/';
    /**
     * 式場ID
     */
    const PLACE_ID = 10326;
    const CID = 1107;
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/mwed.txt';
    
    
    protected static $_loginParams = array(
        '_CODE' => 'あ',
        '_from' => 'pclg',
        'login_id' => '',
        'pw' => '',
        'permanent' => 1,
    );
    
    protected function craeteLoginParams()
    {
        $params = self::$_loginParams;
        //ログインIDとパスワードをDBから取得
        $params['login_id'] = $this->_login->login_id;
        $params['pw'] = $this->_login->password;
        return $params;
    }
    
    protected function checkLoginResult() 
    {
        $info = $this->_curl->getInfo();
        if($info['http_code'] !== 200 || preg_match('/ログインのID・PASSが間違っています/',$this->_curl->getExec())) {
            return false;
        }
        return true;
    }
    
    public function getFairs($year,$month)
    {
        if(!$this->login(false)) {
            exit('login failed');
        }
        if($month < 1 || $month > 12) {
            $month = date('n');
        }
        if($year > 2038 || $year < date('Y')-1) {
            $year = date('Y');
        }
        $yn = $year.$month;
        
        $url = str_replace('%%Yn%%',$yn,self::FAIR_LIST_URL);
        //echo $url."<br/>\n";
        $this->_curl->addUrl($url);
        try {
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
        } catch(Exception $e) {
            error_log($e);
            $this->close();
            return false;
        }
        //cURLセッションクローズ
        $this->close();
        return true;
    }
    
    public function getFairDetail($id,$chClose=true)
    {
        if(!$this->login(false)) {
            return false;
        }
        $id = (int)$id;
        if(!$id) {
            throw new Exception('id is not number');
        }
        
        try {
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!==200 || !preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_GET_FAILED,$this->_curl);
            }
            //input,select,textareaを取得
            $ret = $this->getDetailVal($this->_curl->getExec(), array());
            //その他取得
            $html = str_get_html($this->_curl->getExec());
            //画像取得
            $imgs = $html->find('div#imgfile1_thumb > img');
            $img = $imgs ? $imgs[0] : null;
            if($img) {
                $ret['imgfile1'] = call_user_func("end", explode('/', $img->src));
                $this->optionReset();
                $this->_curl->addUrl(self::BASE_URL . $img->src);
                $this->run();
                if($this->_curl->getInfo()['http_code']==200) {
                    file_put_contents($this->getImgPath($ret['imgfile1']) , $this->_curl->getExec());
                }
            }
            $work = WorkMwedFair::find($id);
            if(!$work) {
                $work = new WorkMwedFair();
                $work->id = $id;
            }
            $work->data = serialize($ret);
            $work->save();
            //メモリ開放
            $html->clear();
            var_dump($ret);
        } catch (Exception $e) {
            error_log($e);
            if($chClose) {
                //cURLセッションクローズ
                $this->close();
            }
            return false;
        }
        if($chClose) {
            //cURLセッションクローズ
            $this->close();
        }
        return true;
    }
    
    public function addFair($id, $chClose = true) 
    {
        $id = 2425515;
        $success = false;
        if(!$this->login(false)) {
            return false;
        }
        
        $params = array(
            'place_id' => self::PLACE_ID,
            'fair_id' => '',
            'cp_fair_id' => '',
            'pg_flg' => 1,
            'pg_sts' => '',
            'imgfile1_oname' => '',
            'imgfile1_tpath' => '',
            'cp_image_id' => '',
            'base_image_id' => '',
            '_CID' => self::CID,
            'p' => 'fair_i',
        );
        
        try {
            $work = WorkMwedFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            
            //データチェック
            $validator = WorkMwedValidation::getFairInputValidation($data);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value). " ===> " .$data[$key] . "<br/>";
                }
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            // 画像アップロード
            if(isset($data['imgfile1']) && $data['imgfile1']) {
                list($params['imgfile1_oname'],$params['imgfile1_tpath']) = $this->fairImageUpload($data['imgfile1']);
            }
            //登録データ抽出
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($data[$key])) {
                    $params[$key] = $data[$key];
                }
            }
            $time = strtotime($data['st_year']."-".$data['st_month']."-".$data['st_day'] ."00:00:00");
            $params['st_date'.$time] = $time;
            
            //---- 確認ページへ ----//
            //boundary作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            $body = $this->multipart_build_query($params, $boundary);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Expect:",
            );

            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_CONFIRM_URL);
            $this->_curl->addPostParams(mb_convert_encoding($body,'sjis'));
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            $info = $this->_curl->getInfo();
            
            if($info['http_code']!=200 || !preg_match(self::FAIR_CONFIRM_PATTERN,$info['url']) || preg_match('/エラー/',$this->_curl->getExec())) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            
            $params = array();
            $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
            foreach($html->find('form[action="_fair_s"]') as $form) {
                foreach($form->find('input') as $input) {
                    $key = $value = null;
                    if(in_array($input->type,array('checkbox','radio'))) {
                        if($input->checked == 'checked') {
                            $key = $input->name;
                            $value = mb_convert_encoding($input->value,'sjis');
                        }
                    } else {
                        $key = $input->name;
                        $value = mb_convert_encoding($input->value,'sjis');
                    }
                    if($key && !is_null($value)) {
                        $params[$key] = $value;
                    }
                }
            }
            //var_dump($params);
            
            //---- 登録ページへ ----//
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_REGIST_URL, $params));
            $this->_curl->methodPost();
            $this->run();
            $info = $this->_curl->getInfo();
            
            echo $this->_curl->getExec();
            
            if($info['http_code']!=200 || !preg_match(self::FAIR_REGIST_PATTERN,$info['url'])|| preg_match('/エラー/',$this->_curl->getExec())) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            
            $success = true;
        } catch (Exception $e) {
            error_log($e);
            $success = false;
        }
        if($chClose) {
            $this->close();
        }
        return $success;
    }
    
    public function updateFair($id, $chClose = true) 
    {
        $id = 2505623;
        $success = false;
        if(!$this->login(false)) {
            return false;
        }
        
        try {
            $work = WorkMwedFair::findOrFail(2425515);
            $data = $this->formatInputData(unserialize($work->data));
            $updateData = array(
                'fair_name' => '【検討中の方に】*季節のハーフコース試食×大聖堂模擬挙式+',
            );
            
            //存在確認＆データ取得
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            $this->run();
            if($this->_curl->getInfo()['http_code']!=200||!preg_match(self::FAIR_EDIT_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            
            //hiddenデータ取得
            $params = array();
            $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
            foreach($html->find('input[type="hidden"]') as $input) {
                if($input->disabled || !$input->name) {
                    continue;
                }
                $params[$input->name] = $input->value;
            }
            $html->clear();
            
            //データチェック
            $validator = WorkMwedValidation::getFairUpdateValidation($updateData);
            if ($validator->fails()) {
                $failed = false;
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    if(isset($updateData[$key])) {
                        echo $key ." ： ".implode(",",$value). " ===> " .$data[$key] . "<br/>";
                        $failed = true;
                    }
                }
                if($failed) {
                    throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
                }
            }
            //日付生成
            if(isset($updateData['st_year']) && isset($updateData['st_month']) && isset($updateData['st_day'])) {
                $time = strtotime($updateData['st_year']."-".$updateData['st_month']."-".$updateData['st_day'] ."00:00:00");
                $data['st_date'.$time] = $time;
            }
            // 画像アップロード
            if(isset($updateData['imgfile1']) && $updateData['imgfile1']) {
                list($params['imgfile1_oname'],$params['imgfile1_tpath']) = $this->fairImageUpload($updateData['imgfile1']);
            }
            //更新データ抽出
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($updateData[$key])) {
                    $params[$key] = $updateData[$key];
                }elseif(isset($data[$key])) {
                    $params[$key] = $data[$key];
                }
            }
            
            //---- 確認ページへ ----//
            //boundary作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            $body = $this->multipart_build_query($params, $boundary);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Expect:",
            );

            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_CONFIRM_URL);
            $this->_curl->addPostParams(mb_convert_encoding($body,'sjis'));
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            $info = $this->_curl->getInfo();
            
            if($info['http_code']!=200 || !preg_match(self::FAIR_CONFIRM_PATTERN,$info['url']) || preg_match('/エラー/',$this->_curl->getExec())) {
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            
            $params = array();
            $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
            foreach($html->find('form[action="_fair_s"]') as $form) {
                foreach($form->find('input[type="hidden"]') as $input) {
                    $params[$input->name] = mb_convert_encoding($input->value,'sjis');
                }
            }
            
            //---- 確定ページへ ----//
            $this->optionReset();
            $this->_curl->addUrl($this->createGetUrl(self::FAIR_REGIST_URL, $params));
            $this->_curl->methodPost();
            $this->run();
            $info = $this->_curl->getInfo();
            
            if($info['http_code']!=200 || !preg_match(self::FAIR_REGIST_PATTERN,$info['url'])||preg_match('/エラー/',$this->_curl->getExec())) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            
            $success = true;
        } catch (Exception $e) {
            error_log($e);
            $success = false;
        }
        if($chClose) {
            $this->close();
        }
        return $success;
    }
    
    public function deleteFair($id,$chClose=true)
    {
        $id = 2506008;
        $success = false;
        if(!$this->login(false)) {
            return false;
        }
        try {
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_DELETE_URL));
            $this->run();
            if($this->_curl->getInfo('http_code')!=200||!preg_match(self::FAIR_DELETE_PATTERN,$this->_curl->getInfo('url'))) {
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
        } catch (Exception $e) {
            error_log($e);
            $success = false;
        }
        if($chClose) {
            $this->close();
        }
        return $success;
    }
    
    public function swFair($id,$chClose=true)
    {
        $id = 2506110;
        $success = false;
        if(!$this->login(false)) {
            return false;
        }
        try {
            $params = array(
                '_CID' => self::CID,
                'fair_id' => $id,
                '_' => '',
            );
            $this->_curl->addUrl(self::FAIR_SW_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            if($this->_curl->getInfo('http_code')!=200||!preg_match(self::FAIR_SW_PATTERN,$this->_curl->getInfo('url'))) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
        } catch (Exception $e) {
            error_log($e);
            $success = false;
        }
        if($chClose) {
            $this->close();
        }
        return $success;
    }
    
    public function fairImageUpload($fileName)
    {
        $boundary = '----WebKitFormBoundary' . Str::random(16);
        $files = $this->build_postfield_files(array(
            'imgfile1' => $this->getImgPath($fileName),
        ));
        $body = $this->multipart_build_query(array(), $boundary, $files);
        $header = array(
            "Content-Type:multipart/form-data; boundary=$boundary",
            "Expect:",
        );
        $this->_curl->addUrl(self::IMAGE_UPLOAD_URL);
        $this->_curl->addPostParams($body);
        $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
        $this->run();
        $info = $this->_curl->getInfo();
        if($info['http_code']!==200) {
            throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
        }
        $output = $this->_curl->getExec();
        //<pre></pre>で囲まれているので外す
        $output = preg_replace('/<\/*pre>/', '',$output);
        $ret = json_decode($output,true);
        if(!$ret || !is_null($ret['err'])) {
           throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
        }
        return array($ret['imgfile_oname'],$ret['imgfile_tpath']);
    }
    
    public function formatInputData($data)
    {
        //テストデータ加工
        if(App::environment("testing")) {
            if(mb_strlen($data['fair_name']) < 29) {
                $data['fair_name'] = $data['fair_name']."_b";
            }
            //掲載スタート日時
            $data['stpb_year'] = (int)date('Y',strtotime('+1 day'));
            $data['stpb_month'] = (int)date('m',strtotime('+1 day'));
            $data['stpb_day'] = (int)date('d',strtotime('+1 day'));
            $data['stpb_hour'] = 0;
            
            $data['stpb_year'] = (int)date('Y',strtotime('+0 day'));
            $data['stpb_month'] = (int)date('m',strtotime('+0 day'));
            $data['stpb_day'] = (int)date('d',strtotime('+0 day'));
            $data['stpb_hour'] = 0;
        }
        return $data;
    }
}