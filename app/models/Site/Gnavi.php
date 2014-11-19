<?php
/**
 * ぐるなびウェディングから情報の取得・登録を行うクラス
 * 
 * ぐるなびのフェア登録画面は登録・修正・コピーして作成の全てで共通となる。 /editpage/fair1/editdata/
 * 内部での見分け方は type= new|edit|copy という見分け方。
 * なので修正する際などの項目も分かりやすい。
 * 
 * ・画像はライブラリも備えているが、アップロードするかライブラリから選ぶかの自由選択となる。
 * ・カレンダーは該当のチェックボックスをcheckedにすればOK
 */
class SiteGnavi extends Site {
    /**
     * site_logins.idの値
     */
    const SITE_LOGIN_ID = 4;
    /**
     * ディレクトリ名
     */
    const DIR_NAME = 'gnavi';
    
    const BASE_URL = 'https://wedding.gnavi.co.jp/shopadmin/';
    //ログイン
    const LOGIN_URL = 'https://wedding.gnavi.co.jp/shopadmin//login/index/login/';
    //ログアウト
    const LOGOUT_URL = 'https://wedding.gnavi.co.jp/shopadmin//login/index/logout/';
    //フェア一覧
    const FAIR_LIST_URL = 'https://wedding.gnavi.co.jp/shopadmin//editpage/fair1/index/';
    const FAIR_LIST_PATTERN = '/^https:\/\/wedding.gnavi.co.jp\/shopadmin\/\/editpage\/fair1\/index\//';
    const FAIR_EDIT_URL = 'https://wedding.gnavi.co.jp/shopadmin//editpage/fair1/editdata/';
    const FAIR_EDIT_PATTERN = '/^https:\/\/wedding.gnavi.co.jp\/shopadmin\/\/editpage\/fair1\/editdata\//';
    const IMG_PATTERN = '/^https:\/\/wedding.gnavi.co.jp\/site_k\/1\/gcdf000\/images\/([a-zA-Z0-9]+).(jpg)/';
    //フェア登録・更新ページ（公開無し）
    const FAIR_REGIST_URL = 'https://wedding.gnavi.co.jp/shopadmin//editpage/fair1/registdata/';
    //フェア登録・更新ページ（本番公開）
    const FAIR_PUBLIC_REGIST_URL = 'https://wedding.gnavi.co.jp/shopadmin//editpage/fair1/publicregistdata/';
    //フェア登録完了
    const FAIR_REGIST_SUCCESS_PATTERN = '/^https:\/\/wedding.gnavi.co.jp\/shopadmin\/editpage\/fair1/';
    //フェア削除
    const FAIR_DELETE_URL = 'https://wedding.gnavi.co.jp/shopadmin//editpage/fair1/deletedata';
    
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/gnavi.txt';
    
    protected static $_loginParams = array(
        's_id' => '',
        'fLogin_id' => '',
        'password' => '',
        'sid' => '',
        'login_id' => '',
        'inq_id' => '',
        'c_kbn' => '',
    );
    
    protected function craeteLoginParams()
    {
        $params = self::$_loginParams;
        //ログインIDとパスワードをDBから取得
        $params['s_id'] = $this->_login->login_id;
        $params['fLogin_id'] = $this->_login->login_id;
        $params['password'] = $this->_login->password;
        return $params;
    }
    
    protected function checkLoginResult() 
    {
        $info = $this->_curl->getInfo();
        if($info['http_code'] !== 200 || preg_match('/ID・パスワードを忘れた方/',$this->_curl->getExec())) {
            return false;
        }
        return true;
    }
    
    public function getFairs($year,$month)
    {
        if(!$this->login(false)) {
            return;
        }
        if($month < 1 || $month > 12) {
            $month = date('m');
        }
        if($year > date('Y') + 1 || $year < date('Y') - 1) {
            $year = date('Y');
        }
        //2ヶ月先までしか無理
        $ym = $year.'-'.sprintf("%02d",$month);
        if(strtotime('first day of ' . $ym) > strtotime('+2 month')) {
            throw new InvalidArgumentException();
        }
        $params = array(
            'target_month' => str_replace('-','',$ym),
        );
        try {
            $url = self::FAIR_LIST_URL;
            $this->_curl->addUrl($url);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            //echo $this->_curl->getExec();
            if($info['http_code']!==200 || !preg_match(self::FAIR_LIST_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            $ids = array();
            $html = str_get_html($this->_curl->getExec());
            foreach($html->find('div.fair_calendar') as $cal) {
                foreach($cal->find('span.month') as $month) {
                    if(trim($month->plaintext) === date('Y年m月',strtotime($ym))) {
                        foreach($cal->find('div.titleList td.i_edit a') as $link) {
                            $ids[] = $link->name;
                        }
                    }
                }
            }
            $this->optionReset();
            var_dump($ids);
        } catch (Exception $e) {
            error_log($e);
            $this->close();
            return false;
        }
        $this->close();
        return true;
    }
    
    public function getFairDetail($id, $chClose = true) 
    {
        //ぐるナビのIDはコンマ区切りで複数IDが纏まった文字列であることに注意
        if(!$this->login(false)) {
            return;
        }
        $params = array(
            'type' => 'edit',
            'cont_id' => $id,
        );
        try {
            $this->_curl->addUrl(self::FAIR_EDIT_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            //echo $this->_curl->getExec();
            if($info['http_code']!==200 || !preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_GET_FAILED,$this->_curl);
            }
            
            //input,select,textareaを取得
            $ret = $this->getDetailVal($this->_curl->getExec(), array());
            
            //その他情報の取得
            $html = str_get_html($this->_curl->getExec());
            //画像取得
            $imgs = $html->find('img#fair_img');
            $img = $imgs ? $imgs[0] : null;
            if($img) {
                $ret['fair_img'] = call_user_func("end", explode('/', $img->src));
                $this->optionReset();
                $this->_curl->addUrl($img->src);
                $this->run();
                if($this->_curl->getInfo()['http_code']==200) {
                    file_put_contents($this->getImgPath($ret['fair_img']) , $this->_curl->getExec());
                }
            }
            
            //$idを分解する
            $objIds = array();
            $workId = 0;
            foreach(explode(',',$id) as $_id) {
                $obj = WorkGnaviFairId::find($_id);
                if(!$obj) {
                    $obj = new WorkGnaviFairId();
                    $obj->id = $_id;
                } else {
                    if(!$workId) {
                        $workId = $obj->work_gnavi_fairs_id;
                    } else if($workId !== $obj->work_gnavi_fairs_id) {
                        error_log("不穏なエラー : " . get_class($this));
                    }
                }
                $objIds[$_id] = $obj;
            }
            if($workId) {
                $work = WorkGnaviFair::find($workId);
                if(!$work) {
                    $work = new WorkGnaviFair();
                    $work->id = $workId;
                }
            } else {
                $work = new WorkGnaviFair();
            }
            $work->data = serialize($ret);
            $work->save();
            //WorkGnaviFairIdを登録・更新
            foreach($objIds as $obj) {
                if(!isset($obj->work_gnavi_fairs_id) || $obj->work_gnavi_fairs_id != $work->id) {
                    $obj->work_gnavi_fairs_id = $work->id;
                    $obj->save();
                }
            }
            //メモリ開放
            $html->clear();
            
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
    
    public function addFair($id, $chClose = true) 
    {
        $id = 1;
        if(!$this->login(false)) {
            return;
        }
        $params = array(
            'setCnt' => 0,
            'pay_tasting_price_tax_flg' => 0,
            'tax_calculation_type' => 0,
            'cont_id' => '',
            'fair_img_moto' => '',
            'type' => 'new',
            'view_text' => '',
            'fair_group_id' => '',
            'recommend_flg' => '',
            'fair_img_tmp_name' => '',
            'fair_img_lib_name' => '',
            'sid' => 'gcdf000',
            'libimgid' => '',
            'fair_template' => 0,
        );
  
        try {
            $work = WorkGnaviFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            $validator = WorkGnaviValidation::getFairInputValidation($data);
            
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value)."<br/>";
                }
                return false;
            }
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($data[$key])) {
                    $params[$key] = $data[$key];
                    
                }
            }
            //画像取得
            $files = array();
            if($data['fair_img']) {
                $files = $this->build_postfield_files(array(
                    'fair_img' => $this->getImgPath($data['fair_img']),
                ));
            }
            
            //日付データ取得
            foreach($data as $key => $value) {
                if(preg_match('/^fair_date_(\d{4})_(\d{2})_\d{2}/',$key)) {
                    $params[$key] = $value;
                }
            }
            //boundaryをどうにかする
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            
            $body = $this->multipart_build_query($params, $boundary, $files);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Connection:keep-alive",
                "Expect:",
            );
            
            //データの貼り付け
            //$this->optionReset();
            $this->_curl->addUrl(self::FAIR_REGIST_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            
            $info = $this->_curl->getInfo();
            
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_REGIST_SUCCESS_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            //成功した場合IDを取得
            $html = str_get_html($this->_curl->getExec());
            $table = $html->find('table#search_result_table')[0];
            $id = 0;
            foreach($table->find('tr') as $tr) {
                $num = $tr->find('.i_number')[0];
                if($num->plaintext == 1) {
                    $id = $tr->find('td.i_edit a')[0]->name;    
                    break;
                }
            }
            var_dump($id);
        } catch(Exception $e) {
            error_log($e);
            if($chClose) {
                //$this->close();
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
        $id = "755129";
        if(!$this->login(false)) {
            return false;
        }
        try {
            $updateData = array(
                'fair_title' => "【検討中の方に】季節のハーフコース試食＆１８名の生演奏挙式♪_t2",
            );
            $editParams = array(
                'type' => 'edit',
                'cont_id' => $id,
            );
            $this->_curl->addUrl(self::FAIR_EDIT_URL);
            $this->_curl->addPostParams($editParams);
            $this->run();
            $info = $this->_curl->getInfo();
            //echo $this->_curl->getExec();
            if($info['http_code']!==200 || !preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            
            //input,select,textareaを取得
            $params = $this->getDetailVal($this->_curl->getExec(), array());
            //更新データで上書き
            foreach($updateData as $key => $value) {
                $params[$key] = $value;
            }
            //MutipartなフォームへPOST
            //boundaryを作成
            $boundary = '----WebKitFormBoundary' . Str::random(16);
            
            $body = $this->multipart_build_query($params, $boundary);
            //headerを作る
            $header = array(
                "Content-Type:multipart/form-data; boundary=$boundary",
                "Connection:keep-alive",
                "Expect:",
            );
            
            //データの貼り付け
            //$this->optionReset();
            $this->_curl->addUrl(self::FAIR_REGIST_URL);
            $this->_curl->addPostParams($body);
            $this->_curl->addOption(CURLOPT_HTTPHEADER, $header);
            $this->run();
            $info = $this->_curl->getInfo();
            
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_REGIST_SUCCESS_PATTERN,$info['url'])) {
                //echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
        } catch (Exception $e) {
            error_log($e);
            if($chClose) {
                $this->logout();
            }
            return false;
        }
        if($chClose) {
            $this->logout();
        }
        return true;
    }
    
    public function deleteFair($id,$chClose=true)
    {
        $id = "755261,755262";
        if(!$this->login(false)) {
            return false;
        }
        try {
            $params = array(
                'cont_id' => $id,
            );
            $this->_curl->addUrl(self::FAIR_DELETE_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_REGIST_SUCCESS_PATTERN,$info['url'])) {
                //echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
            //echo $this->_curl->getExec();
        } catch (Exception $e) {
            error_log($e);
            if($chClose) {
                $this->logut();
            }
        }
        if($chClose) {
            $this->logout();
        }
        return true;
    }
    
    public function formatInputData($data)
    {
        //テストデータ加工
        if(App::environment("testing")) {
            if(mb_strlen($data['fair_title']) < 34) {
                $data['fair_title'].= "_t";
            }
        }
        return $data;
    }
}