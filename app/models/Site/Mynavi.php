<?php
class SiteMynavi extends Site {
    /**
     * site_logins.idの値
     */
    const SITE_LOGIN_ID = 7;
    const DIR_NAME = 'mynavi';
    
    const BASE_URL = 'https://wedding.mynavi.jp/client/';
    //ログイン
    const LOGIN_URL = 'https://wedding.mynavi.jp/client/login/';
    //ログアウト
    const LOGOUT_URL = 'https://wedding.mynavi.jp/client/login/?logout=smt';
    //フェア一覧
    const FAIR_LIST_URL = 'https://wedding.mynavi.jp/client/fair/list/';
    const FAIR_LIST_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/fair\/list\//';
    const FAIR_LIST_OUTPUT_LINK_PATTERN = '/..\/edit\/(\d+)/';
    //フェア編集
    const FAIR_EDIT_URL = 'https://wedding.mynavi.jp/client/fair/edit/%%ID%%/';
    const FAIR_EDIT_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/fair\/edit\/(\d+)\//';
    const FAIR_EDIT_CONFIRM_URL = 'https://wedding.mynavi.jp/client/fair/edit/';
    const FAIR_EDIT_CONFIRM_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/fair\/edit\//';
    
    //フェア登録
    const FAIR_INPUT_URL = 'https://wedding.mynavi.jp/client/fair/regist/';
    const FAIR_INPUT_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/fair\/regist\//';
    const FAIR_REGIST_URL = 'https://wedding.mynavi.jp/client/fair/regist/';
    const FAIR_REGIST_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/fair\/regist\//';
    
    //フェア削除
    const FAIR_DELETE_URL = 'https://wedding.mynavi.jp/client/fair/delete/%%ID%%/';
    const FAIR_DELETE_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/fair\/delete\/(\d+)\//';
    const FAIR_DELETED_URL = 'https://wedding.mynavi.jp/client/fair/delete/';
    const FAIR_DELETED_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/fair\/delete\//';
    
    //画像取得
    const IMAGE_LIST_URL = 'https://wedding.mynavi.jp/client/album/list/?pageNo=%%PAGE%%';
    const IMAGE_LIST_PATTERN = '/^https:\/\/wedding.mynavi.jp\/client\/album\/list\/\?pageNo=(\d)+/';
    const IMAGE_URL = 'https://img.wedding.mynavi.jp/thumb/%%PART_1%%/%%PART_2%%/%%IMAGE_ID%%_sd.jpg';
    const IMAGE_PATTERN = '/\/\/img.wedding.mynavi.jp\/thumb\/(.{2})\/(.{2})\/(\d+)_sd.jpg\?(\d+)/';
    
    const COOKIE_PATH = '/home/homepage/html/wedding/app/cookies/mynavi.txt';
    const TOKEN_COLUMN_NAME = 'org.apache.struts.taglib.html.TOKEN';
    
    protected static $_loginParams = array(
        'loginUserName' => '',
        'loginUserPassword' => '',
        'login' => 'ログイン',
        'backUrl' => '',
        'tradeNameId' => '',
        'weddingId' => '',
    );
    
    protected function craeteLoginParams()
    {
        $params = self::$_loginParams;
        //ログインIDとパスワードをDBから取得
        $params['loginUserName'] = $this->_login->login_id;
        $params['loginUserPassword'] = $this->_login->password;
        return $params;
    }
    
    protected function checkLoginResult() 
    {
        $info = $this->_curl->getInfo();
        if($info['http_code'] !== 200 || preg_match('/login/',$info['url'])) {
            return false;
        }
        return true;
    }
    
    public function getFairs($year,$month)
    {
        //ログイン処理
        if(!$this->login(false)) {
            return false;
        }
        
        $params = array(
            'registClientAccountId' => '',
            'status' => array(1,2,3),
            'freeWord' => '',
            'fairPublicationExist' => 1,
            'listBackUrl' => '',
            'sortKey' => 1,
            'search' => 'smt',
        );
        try {
            $this->_curl->addUrl(Site::createGetUrl(self::FAIR_LIST_URL, $params));
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code'] !== 200 || !preg_match(self::FAIR_LIST_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            preg_match_all(self::FAIR_LIST_OUTPUT_LINK_PATTERN,$this->_curl->getExec(),$matches,PREG_SET_ORDER);
            $ids = array();
            foreach($matches as $m) {
                if(!in_array($m[1],$ids)) {
                    $ids[] = $m[1];
                }
            }
            echo $this->_curl->getExec();
            var_dump($ids);
        } catch (Exception $e) {
            error_log($e);
            return false;
        }
        $this->close();
        return true;
    }
    
    public function getFairDetail($id, $chClose = true) {
        $id = 281727;
        //ログイン処理
        if(!$this->login(false)) {
            return false;
        }
        if(!$id) {
            throw new Exception('id is not number');
        }
        try {
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!=200||!preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_CONNECT_FAILED,$this->_curl);
            }
            //input,select,textareaを取得
            $ret = $this->getDetailVal($this->_curl->getExec(), array());
            
            $work = WorkMynaviFair::find($id);
            if(!$work) {
                $work = new WorkMynaviFair();
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
    
    /**
     * フェア登録
     * @param int $id
     * @param type $chClose
     * @return boolean
     * @throws WorkException
     */
    public function addFair($id, $chClose = true)
    {
        $id = 281727;
        $token = "";
        //固定値
        $params = array(
            self::TOKEN_COLUMN_NAME => "", //登録画面より取得
            "confirm" => '確認画面へ進む',
            "fairInfoId" => '',
            "weddingId" => 132,
            "isPreview" => "false",
            "listBackUrl" => "/client/fair/list/",
            "weddingDiv" => 1,
        );
        if(!$this->login(false)) {
            return false;
        }
        
        try {
            $work = WorkMynaviFair::findOrFail($id);
            $data = $this->formatInputData(unserialize($work->data));
            //データチェック
            $validator = WorkMynaviValidation::getFairInputValidation($data);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value). " ===> " . $data[$key] . "<br/>";
                }
                return false;
            }
            //トークン取得
            $this->_curl->addUrl(self::FAIR_INPUT_URL);
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_INPUT_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            $html = str_get_html($this->_curl->getExec());
            $token = "";
            foreach($html->find('input[name="'.self::TOKEN_COLUMN_NAME.'"]') as $input) {
                if($input->name === self::TOKEN_COLUMN_NAME) {
                    $token = $input->value;
                    break;
                }
            }
            if(!$token) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            $params[self::TOKEN_COLUMN_NAME] = $token;

            //登録データ抽出
            $keys = array_keys($validator->getRules());
            foreach($keys as $key) {
                if(isset($data[$key])) {
                    $params[$key] = $data[$key];
                }
            }
            
            //確認処理
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_INPUT_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            $info = $this->_curl->getInfo();
            //echo $this->_curl->getExec();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_INPUT_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            //登録データ取得
            $registParams = array();
            $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
            foreach($html->find('input[type="hidden"]') as $input) {
                if($input->disabled || !$input->name) {
                    continue;
                }
                $registParams[$input->name] = $input->value;
            }
            $html->clear();
            //var_dump($addParams);
            $registParams["regist"] = "登録する";
            
            //登録処理
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_REGIST_URL);
            $this->_curl->addPostParams($registParams);
            $this->run();
            $info = $this->_curl->getInfo();
            //echo $this->_curl->getExec();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_REGIST_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_ADD_FAILED,$this->_curl);
            }
            //IDを取得する
            $addId = 0;
            if(preg_match("/fairInfoId=(\d*)/",$this->_curl->getExec(),$matches)) {
                $addId = $matches[1];
            }
            var_dump($addId);
        } catch (Exception $e) {
            error_log($e);
            if($chClose) {
                $this->close();
            }
            return false;
        }
        $this->close();
        return true;
    }
    
    public function updateFair($id,$chClose=true)
    {
        $id = 282503;
        $token = "";
        if(!$this->login(false)) {
            return false;
        }
        try {
            //存在確認&必要データ抽出
            $this->_curl->addUrl(str_replace('%%ID%%',$id,self::FAIR_EDIT_URL));
            $this->run();
            $info = $this->_curl->getInfo();
            if($info['http_code']!=200||!preg_match(self::FAIR_EDIT_PATTERN,$info['url'])) {
                throw new WorkException(WorkException::CODE_UPDATE_FAILED,$this->_curl);
            }
            //既存データを取得
            $params = $this->getDetailVal($this->_curl->getExec(), array());
            //トークン取得
            $token = $params[self::TOKEN_COLUMN_NAME];
            
            //DBのデータを取得
            $work = WorkMynaviFair::findOrFail(281727);
            $data = $this->formatInputData(unserialize($work->data));
            unset($data['fairInfoId']);
            
            //DBのデータをValidate
            $validator = WorkMynaviValidation::getFairUpdateValidation($data);
            if ($validator->fails()) {
                $messages = json_decode($validator->messages());
                foreach($messages as $key => $value) {
                    echo $key ." ： ".implode(",",$value). " ===> " . $data[$key] . "<br/>";
                }
                throw new WorkException(WorkException::CODE_UPDATE_FAILED,$this->_curl);
            }
            //DBのデータで上書き
            foreach($data as $key => $value) {
                $params[$key] = $value;
            }
            
            //確認処理
            $params['confirm'] = "確認画面へ進む";
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_EDIT_CONFIRM_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            //echo $this->_curl->getExec();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_EDIT_CONFIRM_PATTERN,$this->_curl->getInfo()['url'])) {
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            
            //hiddenな更新データ取得
            $registParams = array();
            $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
            foreach($html->find('input[type="hidden"]') as $input) {
                if($input->disabled || !$input->name) {
                    continue;
                }
                $registParams[$input->name] = $input->value;
            }
            $html->clear();
            //var_dump($addParams);
            $registParams["regist"] = "登録する";
            
            //確定処理
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_EDIT_CONFIRM_URL);
            $this->_curl->addPostParams($registParams);
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_EDIT_CONFIRM_PATTERN,$this->_curl->getInfo()['url'])) {
                echo $this->_curl->getExec();
                throw new WorkException(WorkException::CODE_FAIR_UPDATE_FAILED,$this->_curl);
            }
            echo $this->_curl->getExec();
        } catch (Exception $e) {
            error_log($e);
            if($chClose) {
                $this->close();
            }
            return false;
        }
        $this->close();
        return true;
    }
    
    public function deleteFair($id,$chClose=true)
    {
        $id = 282506;
        $token = "";
        if(!$this->login(false)) {
            return false;
        }
        try {
            //確認画面から必要データを集める必要がある。
            $this->_curl->addUrl(str_replace("%%ID%%",$id,self::FAIR_DELETE_URL));
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_DELETE_PATTERN,$this->_curl->getInfo()['url'])) {
                throw new WorkException(WorkException::CODE_FAIR_DELETE_FAILED,$this->_curl);
            }
            //必要データをかき集める
            $params = array();
            $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
            foreach($html->find('input[type="hidden"]') as $input) {
                if($input->disabled || !$input->name) {
                    continue;
                }
                $params[$input->name] = $input->value;
            }
            $html->clear();
            $params['delete'] = "削除する";
            
            //削除実行
            $this->optionReset();
            $this->_curl->addUrl(self::FAIR_DELETED_URL);
            $this->_curl->addPostParams($params);
            $this->run();
            if($this->_curl->getInfo()['http_code']!==200||!preg_match(self::FAIR_DELETED_PATTERN,$this->_curl->getInfo()['url'])) {
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
        $this->close();
        return true;
    }
    
    public function formatInputData($data)
    {
        //テストデータ加工
        if(App::environment("testing")) {
            if(mb_strlen($data['title']) < 99) {
                $data['title'].= "_t";
            }
        }
        return $data;
    }
    
    /**
     * 画像の取得処理
     * @param type $chClose
     * @return boolean
     * @throws WorkException
     */
    public function getImages($chClose=true)
    {
        if(!$this->login(false)) {
            return false;
        }
        try {
            $end = false;
            $i = 1;
            while(true) {
                //確認画面から必要データを集める必要がある。
                $this->_curl->addUrl(str_replace("%%PAGE%%",$i,self::IMAGE_LIST_URL));
                $this->run();
                if($this->_curl->getInfo('http_code')!==200||!preg_match(self::IMAGE_LIST_PATTERN,$this->_curl->getInfo('url'))) {
                    throw new WorkException(WorkException::CODE_MYNAVI_IMAGE_LIST_FAILED,$this->_curl);
                }
                //必要データをかき集める
                $html = str_get_html($this->_curl->getExec(),true,true,DEFAULT_TARGET_CHARSET,false);
                foreach($html->find('table.listTableL') as $table) {
                    $image = new WorkMynaviImage();
                    $tags = array();
                    $count = 0;
                    foreach($table->find('tr') as $tr) {
                        $count++;
                        switch($count) {
                            case 1:
                                //カテゴリID
                                foreach($tr->find('td') as $td) {
                                    if($td->class === 'btn') {
                                        continue;
                                    }
                                    if($td->class === 'min') {
                                        $imgUrl = $td->firstChild()->src;
                                        if(preg_match(self::IMAGE_PATTERN,$imgUrl,$m)) {
                                            $id = (int)$m[3];
                                            $work = WorkMynaviImage::find($id);
                                            if($work) {
                                                $image = $work;
                                            }
                                            $image->id = $id;
                                            $image->part_1 = $m[1];
                                            $image->part_2 = $m[2];
                                        }
                                    } else {
                                        //画像名
                                        $image->name = $td->innertext();
                                    }
                                }
                                break;
                            case 2:
                                //キャプションタイトル
                                foreach($tr->find('td') as $td) {
                                    $image->title = $td->innertext();
                                }
                                break;
                            case 3:
                                //フォトギャラリーに表示
                                foreach($tr->find('td') as $td) {
                                    $image->photo_show_flg = $td->innertext() == '表示する' ? 1 : 0;
                                }
                                break;
                            case 4:
                                //ウェディングフォト診断
                                foreach($tr->find('td') as $td) {
                                    $image->inspiration_search_flg = $td->innertext() == '対象' ? 1 : 0;
                                }
                                break;
                            case 5:
                                //カテゴリ
                                foreach($tr->find('td') as $td) {
                                    foreach(WorkMynaviImage::$imageCategoryList as $key => $value) {
                                        if($value === $td->innerText()) {
                                            $image->image_category_id = $key;
                                        }
                                    }
                                }
                                break;
                            case 6:
                                //フォト診断キーワード
                                foreach($tr->find('td') as $td) {
                                    foreach(explode('/',$td->innertext()) as $tagValue) {
                                        foreach(WorkMynaviImageTag::$imageTagList as $key => $value) {
                                            if($value === $tagValue) {
                                                $tag = new WorkMynaviImageTag();
                                                $tag->tag_id = $key;
                                                $tags[] = $tag;
                                            }
                                        }
                                    }
                                }
                                break;
                            default:
                                break;
                        }
                    }
                    $image->save();
                    foreach($tags as $tag) {
                        $tag->work_mynavi_image_id = $id;
                        $tag->save();
                    }
                    //画像取得処理
                    if($id) {
                        $filename = $id . "_sd.jpg";
                        $this->optionReset();
                        $url = str_replace('%%PART_1%%',$image->part_1,self::IMAGE_URL);
                        $url = str_replace('%%PART_2%%',$image->part_2,$url);
                        $url = str_replace('%%IMAGE_ID%%',$id,$url);
                        $this->_curl->addUrl($url);
                        $this->run();
                        if($this->_curl->getInfo()['http_code']==200) {
                            file_put_contents($this->getImgPath($filename) , $this->_curl->getExec());
                        }
                    }
                }
                //終了チェック
                $divs = $html->find('div.paging');
                if(!$divs) {
                    throw new WorkException(WorkException::CODE_MYNAVI_IMAGE_LIST_FAILED,$this->_curl);
                }
                $count = 0;
                $max = $last = null;
                foreach($divs[0]->find('span') as $span) {
                    $count++;
                    echo "$count :".$span."\n";
                    if($count === 1) {
                        $max = (int)$span->innertext();
                    }
                    if($count === 3) {
                        $last = (int)$span->innertext();
                    }
                }
                if($max === $last) {
                    $end = true;
                }
                
                $html->clear();
                ++$i;
                if($end) {
                    break;
                }
            }
        } catch (Exception $e) {
            error_log($e);
            if($chClose) {
                $this->close();
            }
            return false;
        }
        $this->close();
        return true;
    }
}