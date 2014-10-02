<?php
/**
 * WeddingParkの情報を取得・登録を行うためのクラス
 * 
 * パークはフェア情報入力画面を開いた際にtokenが発行される。
 * そのtokenをPOSTパラメータに含ませる必要があるので注意
 * 
 * アップしたファイル名と保存ファイル名の紐付を行い、
 * 同一画像のアップロード処理を省いて処理速度を上げる
 */
class SitePark extends Site {
    /**
     * site_logins.idの値
     */
    const SITE_LOGIN_ID = 3;
    const DIR_NAME = 'park';
    
    const BASE_URL = 'https://wplanet.weddingpark.net';
    const BASE_PATTERN = '/^https:\/\/wplanet.weddingpark.net/';
    //ログイン
    const LOGIN_URL = 'https://wplanet.weddingpark.net/login';
    //ログアウト
    const LOGOUT_URL = 'https://wplanet.weddingpark.net/logout';
    //フェア一覧
    const FAIR_LIST_URL = 'https://pearl.weddingpark.net/hall_fair';
    const FAIR_LIST_PATTERN = '/^https:\/\/pearl.weddingpark.net\/hall_fair/';
    const FAIR_LIST_EDIT_LINK_PATTERN = '/https:\/\/pearl.weddingpark.net\/hall_fair\/edit\/id\/(\d+)/';
    //フェア情報取得・更新
    const FAIR_EDIT_URL = 'https://pearl.weddingpark.net/hall_fair/edit/id/%%ID%%';
    const FAIR_EDIT_PATTERN = '/^https:\/\/pearl.weddingpark.net\/hall_fair\/edit\/id\/(\d+)/';
    //フェア登録
    const FAIR_INPUT_URL = 'https://pearl.weddingpark.net/hall_fair/edit';
    const FAIR_INPUT_PATTERN = '/^https:\/\/pearl.weddingpark.net\/hall_fair\/edit/';
    const FAIR_REGIST_URL = 'https://pearl.weddingpark.net/hall_fair/save';
    //フェア削除
    const FAIR_DELETE_URL = 'https://pearl.weddingpark.net/hall_fair/delete';
    
    //画像をPOSTする際のURL
    const IMAGE_UPLOAD_URL = 'https://pearl.weddingpark.net/upload/image/fair';
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/park.txt';
    
    protected static $_loginParams = array(
        'id' => '',
        'password' => '',
    );
    
    public static $_fair_titles = array(
        1 => 'その他1',
        2 => '模擬挙式',
        3 => '模擬披露宴',
        4 => '試食会(コース)',
        5 => '試食会(プチ)',
        6 => '試食会',
        7 => '試着会',
        8 => '会場コーディネート展示',
        9 => '婚礼アイテム展示 ', //最後の半角スペースに注意
        10 => '相談会',
        11 => 'その他2',
        12 => 'その他3',
    );
    
    protected function craeteLoginParams()
    {
        $params = self::$_loginParams;
        //ログインIDとパスワードをDBから取得
        $params['id'] = $this->_login->login_id;
        $params['password'] = $this->_login->password;
        return $params;
    }
    
    protected function checkLoginResult() 
    {
        $info = $this->_curl->getInfo();
        if($info['http_code'] !== 200 || preg_match('/パスワードを忘れた方/',$this->_curl->getExec())) {
            return false;
        }
        return true;
    }
    
    public function getFairs($year,$month)
    {
        if(!$this->login(false)) {
            return false;
        }
        try {
            $this->_curl->addUrl(self::FAIR_LIST_URL);
            $this->run();
            //ログイン成否をチェック
            $info = $this->_curl->getInfo();
            if($info['http_code'] != 200 || !preg_match(self::FAIR_LIST_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            preg_match_all(self::FAIR_LIST_EDIT_LINK_PATTERN,$this->_curl->getExec(),$matches,PREG_SET_ORDER);
            $ids = array();
            foreach($matches as $m) {
                if(!in_array($m[1],$ids)) {
                    $ids[] = $m[1];
                }
            }
            var_dump($ids);
            //echo $this->_curl->getExec();
        } catch(Exception $e) {
            error_log($e);
            $this->close();
            return false;
        }
        $this->close();
        return true;
    }
    
    public function getFairDetail($id,$chClose=true)
    {
        $id = (int)$id;
        if(!$id) {
            throw new Exception('id is not number');
        }
        if(!$this->login(false)) {
            return false;
        }
        try {
            //必要オプションの設定
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            $this->run();
            //ログイン成否をチェック
            $info = $this->_curl->getInfo();
            if($info['http_code'] != 200 || !preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_GET_FAILED,$this->_curl);
            }

            //input,select,textareaを取得
            $ret = $this->getDetailVal($this->_curl->getExec(), array());
            
            //その他データの取得
            $html = str_get_html($this->_curl->getExec());
            //日付の取得
            //script の days.push('Y-m-d');から取得する
            preg_match_all('/days.push\(\'(\d{4}-\d{2}-\d{2})\'\);/s',preg_replace('/[\r|\n|\t|\s]+/','',$this->_curl->getExec()),$matches,PREG_SET_ORDER);
            $fair_days = array();
            foreach($matches as $m) {
                $fair_days[] = $m[1];
            }
            $ret['fair_days'] = implode(",",$fair_days);
            
            //画像取得
            $imgs = $html->find('div.upload-form > img');
            $img = $imgs ? $imgs[0] : null;
            if($img) {
                $ret['img_filename'] = call_user_func("end", explode('/', $img->src));
                $this->optionReset();
                $this->_curl->addUrl($img->src);
                $this->run();
                if($this->_curl->getInfo()['http_code']==200) {
                    file_put_contents($this->getImgPath($ret['img_filename']) , $this->_curl->getExec());
                }
            }
            //保存
            $work = WorkParkFair::find($id);
            if(!$work) {
                $work = new WorkParkFair();
                $work->id = $id;
            }
            $work->data = serialize($ret);
            $work->save();
            //メモリ開放
            $html->clear();
            var_dump($ret);
            //echo $this->_curl->getExec();
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
    

    
    public function addFair($id, $chClose = true)
    {
        $id = 258806;
        //固定値
        $params = array(
            "save_button" => "", //一時保存用
            //"public_button" => "", //公開用
            "add" => "",
            "recommend_flag" => 0,
            "image_url" => "",
            "token" => "",
            "image-1" => "default",
        );
        if(!$this->login(false)) {
            return false;
        }
        try {
            $work = WorkParkFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            //データチェック
            $validator = WorkParkValidation::getFairInputValidation($data);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value). " ===> " .$data[$key] . "<br/>";
                }
                return false;
            }
            //トークン取得
            $this->_curl->addUrl(self::FAIR_INPUT_URL);
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_INPUT_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_GET_FAILED,$this->_curl);
            }
            $html = str_get_html($this->_curl->getExec());
            $token = "";
            foreach($html->find('input') as $input) {
                if($input->name === "token") {
                    $token = $input->value;
                    break;
                }
            }
            $html->clear();
            if(!$token) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            $params['token'] = $token;
            // 画像アップロード
            if(isset($data['img_filename']) && $data['img_filename']) {
                $params['image-1'] = $this->fairImageUpload($data['img_filename']);
            }
            echo $params['image-1']."<br/>";
            //登録データ抽出
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($data[$key])) {
                    $params[$key] = $data[$key];
                }
            }
            //日付の加工
            //データが存在する場合最後に,が必要
            $params['fair_days'] = isset($data['fair_days']) && $data['fair_days'] ? $data['fair_days'] . "," : '';
            
            //登録処理
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_REGIST_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            if($this->_curl->getInfo()['http_code']!==200) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
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
    
    public function updateFair($id, $chClose = true)
    {
        $id = 258806;
        //固定値
        $params = array(
            "save_button" => "", //一時保存用
            //"public_button" => "", //公開用
            "add" => 0,
            "recommend_flag" => 0,
            "image_url" => "",
            "token" => "",
            "image-1" => "default",
        );
        if(!$this->login(false)) {
            return false;
        }
        try {
            $work = WorkParkFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            //更新するID
            $id = 274322;
            $updateData = array(
                'name' => str_replace("_","+",$data['name']),
            );
            //データチェック
            $validator = WorkParkValidation::getFairUpdateValidation($updateData);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                $failed = false;
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
            //トークン取得
            $this->_curl->addUrl(str_replace("%%ID%%",$id,self::FAIR_EDIT_URL));
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_INPUT_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            $html = str_get_html($this->_curl->getExec());
            $token = "";
            foreach($html->find('input') as $input) {
                if($input->name === "token") {
                    $token = $input->value;
                    break;
                }
            }
            $html->clear();
            if(!$token) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            
            $params['token'] = $token;
            // 画像アップロード
            if(isset($data['img_filename']) && $data['img_filename']) {
                $params['image-1'] = $this->fairImageUpload($data['img_filename']);
            }
            echo $params['image-1']."<br/>";
            //登録データ抽出
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($updateData[$key])) {
                    $params[$key] = $updateData[$key];
                }elseif(isset($data[$key])) {
                    $params[$key] = $data[$key];
                }
            }
            //日付の加工
            //データが存在する場合最後に,が必要
            $params['fair_days'] = isset($data['fair_days']) && $data['fair_days'] ? $data['fair_days'] . "," : '';
            
            $params['id'] = $id;
            
            //更新処理
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_REGIST_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            if($this->_curl->getInfo()['http_code']!==200) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
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
    
    public function deleteFair($id,$chClose = true)
    {
        $id = 274349;
        if(!$this->login(false)) {
            return false;
        }
        try {
            //データが存在するかチェック
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code'] != 200 || !preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
            $html = str_get_html($this->_curl->getExec());
            $token = "";
            foreach($html->find('input') as $input) {
                if($input->name === "token") {
                    $token = $input->value;
                    break;
                }
            }
            $html->clear();
            if(!$token) {
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
            //削除処理
            $params = array(
                'token' => $token,
                'fair_id' => $id,
            );
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_DELETE_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code'] != 200) {
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
            $response = json_decode($this->_curl->getExec(),true);
            if($response["result"] !== "success") {
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
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
    
    public function fairImageUpload($fileName)
    {
        $boundary = '----WebKitFormBoundary' . Str::random(16);
        $files = $this->build_postfield_files(array(
            'image' => $this->getImgPath($fileName),
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
        if($output === "null") {
            throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
        }
        //そのままでは使えないJSONデータなので加工
        preg_match_all('/([a-zA-Z0-9]+):"{0,1}([^,]+)"{0,1},/',$output,$matches,PREG_SET_ORDER);
        $ret = array();
        foreach($matches as $m) {
            $ret[$m[1]] = str_replace("\"","",$m[2]);
        }
        if($ret['success'] != 1) {
            throw new WorkException(WorkException::CODE_IMAGE_UPLOAD_FAILED,$this->_curl);
        }
        return $ret['src'];
    }
    
    public function formatInputData($data)
    {
        //テストデータ加工
        if(App::environment("testing")) {
            if(mb_strlen($data['name']) < 35) {
                $data['name'].= "_";
            }
        }
        return $data;
    }
}