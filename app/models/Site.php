<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 各サイトへcURLするための親クラス
 *
 * @author admin-97
 */
require_once __DIR__ . "/simple_html_dom.php";
abstract class Site {
    const SITE_LOGIN_ID = 0;
    const COOKIE_PATH = '';
    const RELOGIN_TIME = 360; //再ログインを行う時間
    
    /**
     * cURLセッション
     * @var Curl 
     */
    public $_curl = null;
    /**
     * Cookie保存パス
     * @var string
     */
    protected $_cookie_path = '';
    /**
     * 再ログインを行う必要があるかのフラグ
     * @var bool
     */
    protected $_relogin = false;
    /**
     * site_logins情報
     * @var Site_Login
     */
    protected $_login = null;
    /**
     * ログイン状態かどうか
     * @var bool
     */
    protected $_logined = false;
    /**
     * cURLに設定するオプション
     */
    protected $_options = array();
    /**
     * cURLのデフォルトオプション
     * @var array
     */
    public static $_default_options = array(
        CURLOPT_SSL_VERIFYPEER => true, //SSL検証
        CURLOPT_RETURNTRANSFER => true, //返り値が文字列
        CURLOPT_FOLLOWLOCATION => true, //リダイレクトする
        CURLOPT_MAXREDIRS => 10,//何回までリダイレクトするか
        CURLOPT_AUTOREFERER => true, //リダイレクトにリファラを付ける
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',//IE11
        CURLOPT_COOKIESESSION => true,
        CURLOPT_POST => false,
        CURLINFO_HEADER_OUT => true, //ヘッダ表示
        CURLOPT_VERBOSE => true,
        CURLOPT_FORBID_REUSE => false,
    );
    /**
     * cURLがセッション開始状態か
     * @var type 
     */
    protected $_runnning = false;
    /**
     * 各サイトのデータを取得してくるmodelの一覧
     * @var array
     */
    public static $_site_models = array(
        SiteGnavi::SITE_LOGIN_ID   => 'SiteGnavi',
        SiteMwed::SITE_LOGIN_ID    => 'SiteMwed',
        SiteMynavi::SITE_LOGIN_ID  => 'SiteMynavi',
        SitePark::SITE_LOGIN_ID    => 'SitePark',
        SiteRakuten::SITE_LOGIN_ID => 'SiteRakuten',
        SiteSugukon::SITE_LOGIN_ID => 'SiteSugukon',
        SiteZexy::SITE_LOGIN_ID    => 'SiteZexy',
    );
    
    public static $_site_names = array(
        SiteGnavi::SITE_LOGIN_ID   => 'ぐるナビ',
        SiteMwed::SITE_LOGIN_ID    => 'みんなの',
        SiteMynavi::SITE_LOGIN_ID  => 'マイナビ',
        SitePark::SITE_LOGIN_ID    => 'パーク',
        SiteRakuten::SITE_LOGIN_ID => '楽天',
        SiteSugukon::SITE_LOGIN_ID => 'すぐ婚',
        SiteZexy::SITE_LOGIN_ID    => 'ゼクシィ',
    );
    
    function __construct()
    {
        $this->_curl = new Curl(self::$_default_options);
        if(static::COOKIE_PATH) {
            $this->_curl->addCookiePath(static::COOKIE_PATH);
            if(!file_exists(static::COOKIE_PATH)) {
                touch(static::COOKIE_PATH);
                $this->_relogin = true;
            }
        } else {
            $this->_relogin = true;
        }
        $this->_login = static::getLogin();
        if(!$this->_login) {
            throw new Exception('not created at site_login.id = ' .static::SITE_LOGIN_ID);
        }
        if($this->_login->last_login_at + self::RELOGIN_TIME < time()) {
            $this->_relogin = true;
        }
    }
    
    /**
     * cURLで情報収集開始
     * @return array
     * @throws InvalidArgumentException
     */
    public function run()
    {
        $this->_curl->init();
        $this->_curl->exec();
        if($this->_curl->getErrorNo()) {
            throw new InvalidArgumentException("[".$this->_curl->getErrorNo()."]" .$this->_curl->getError());
        }
        $this->_runnning = true;
    }
    
    /**
     * cURLのオプションを初期状態に戻す
     * @return type
     */
    public function optionReset()
    {
        if(!$this->_runnning) {
            return;
        }
        $this->_curl->resetOptions();
        $this->_curl->setOptions(self::$_default_options);
        if(static::COOKIE_PATH) {
            $this->_curl->addCookiePath(static::COOKIE_PATH);
        }
    }
    
    /**
     * cURLのセッション終了
     */
    public function close()
    {
        if(!$this->_runnning) {
            return;
        }
        //ログアウト処理
        $this->logout();
        
        //curl削除
        $this->_curl->close();
        $this->_curl->setOptions(self::$_default_options);
        if(static::COOKIE_PATH) {
            $this->_curl->addCookiePath(static::COOKIE_PATH);
        }
        //COOKIE削除
        if(static::COOKIE_PATH && file_exists(static::COOKIE_PATH)) {
            //unlink(static::COOKIE_PATH);
        }
        $this->_runnning = false;
    }
    
    /**
     * Curlで取得したデータのチェック処理
     * @param int $ecode WorkExceptionのエラーコード
     * @param string $urlPattern 合致URLパターン
     * @param string $notStrPattern 含まれてはいけない文字列パターン
     * @throws WorkException
     */
    protected function curlCheck($ecode=WorkException::CODE_CONNECT_FAILED,$urlPattern="",$notStrPattern="")
    {
        if ($this->_curl->getInfo('http_code') !== 200) {
            throw new WorkException($ecode,$this->_curl);
        }
        if ($urlPattern && !preg_match($urlPattern,$this->_curl->getInfo('url'))) {
            throw new WorkException($ecode,$this->_curl);
        }
        if ($notStrPattern && preg_match($notStrPattern,$this->_curl->getExec())) {
            throw new WorkException($ecode,$this->_curl);
        }
    }
    
    /**
     * site_loginsに登録を行う。
     * @param type $loginId
     * @param type $password
     * @return boolean
     */
    public static function createLogin($loginId,$password)
    {
        try {
            $login = SiteLogin::find(static::SITE_LOGIN_ID);
            if(!$login) {
                $login = new SiteLogin();
                $login->id = static::SITE_LOGIN_ID;
                $login->login_id = $loginId;
                $login->password = $password;
                $login->last_login_at = 0;
                $login->save();
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    
    public static function updateLogin($loginId,$password)
    {
        try {
            $login = SiteLogin::findOrFail(static::SITE_LOGIN_ID);
            $login->login_id = $loginId;
            $login->password = $password;
            $login->last_login_at = 0;
            $login->save();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    
    public static function createGetUrl($url,$params)       
    {
        $get = array();
        foreach($params as $key => $p) {
            if(is_array($p)) {
                foreach($p as $value) {
                    $get[] = urlencode($key)."=".urlencode($value);
                }
            } else {
                $get[] = urlencode($key)."=".urlencode($p);
            }
        }
        $url .= strpos('?',$url) === false ? '?' : '&';
        return $url . implode('&',$get);
    }
    
    /**
     * モデルに対応したSiteLoginオブジェクトを取得する
     * @return SiteLogin
     */
    public static function getLogin()
    {
        return SiteLogin::find(static::SITE_LOGIN_ID);
    }
    
    public function isRunnning()
    {
        return $this->_runnning;
    }
    
    /**
     * ログイン処理を行う
     */
    public function login($chClose=true,$relogin=true)
    {
        if(!$this->_relogin && !$relogin) {
            return true;
        }
        //必要オプションの設定
        $this->_curl->addUrl(static::LOGIN_URL);
        $this->_curl->addPostParams($this->craeteLoginParams());
        try {
            $this->run();
            //ログイン成否をチェック
            if(!$this->checkLoginResult()) {
                throw new WorkException(WorkException::CODE_LOGIN_FAILED,$this->_curl);
            }
            //最終ログイン成功時間を更新
            $this->_login->last_login_at = time();
            $this->_login->save();
        } catch(Exception $e) {
            error_log($e);
            $this->_relogin = true;
            //最終ログイン成功時間を0に
            $this->_login->last_login_at = 0;
            $this->_login->save();
            return false;
        }
        $this->_logined = true;
        if($chClose) {
            $this->close();
        }
        $this->optionReset();
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
            $this->_curl->addUrl(static::LOGOUT_URL);
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
    
    /**
     * 詳細情報の必要な内容をかき集める
     * 第二引数に取得用の配列を渡し、それを戻す
     * @param string $text html文字列
     * @param array $ret
     * @param string $head 各項目名の頭につける文字 Zexyで使ったりする
     * @return array
     */
    protected function getDetailVal($text,$ret=array(),$head="")
    {
        $html = str_get_html($text,true,true,DEFAULT_TARGET_CHARSET,false);
        foreach($html->find('input') as $input) {
            if($input->disabled) {
                continue;
            }
            if(!in_array($input->type,array('button','file','submit'))) {
                $key = $value = null;
                if(in_array($input->type,array('checkbox','radio'))) {
                    if($input->checked == 'checked') {
                        $key = $head.$input->name;
                        $value = $input->value;
                    }
                } else {
                    $key = $head.$input->name;
                    $value = $input->value;
                }
                if(!is_null($key) && !is_null($value)) {
                    if(array_key_exists($key,$ret)) {
                        //同名カラムが存在する場合は配列にして取得
                        if(!is_array($ret[$key])) {
                            $wk = $ret[$key];
                            $ret[$key] = array();
                            $ret[$key][] = $wk;
                        }
                        $ret[$key][] = trim($value);
                    } else {
                        $ret[$key] = trim($value);
                    }
                }
            }
        }
        //select
        foreach($html->find('select') as $select) {
            foreach($select->find('option') as $option) {
                $key = $value = null;
                if($option->selected) {
                    $key = $head.$select->name;
                    $value = trim($option->value);
                }
                if(!is_null($key) && !is_null($value)) {
                    if(array_key_exists($key,$ret)) {
                        //同名カラムが存在する場合は配列にして取得
                        if(!is_array($ret[$key])) {
                            $wk = $ret[$key];
                            $ret[$key] = array();
                            $ret[$key][] = $wk;
                        }
                        $ret[$key][] = trim($value);
                    } else {
                        $ret[$key] = trim($value);
                    }
                }
            }
        }
        //textarea
        foreach($html->find('textarea') as $textarea) {
            $key = $head.$textarea->name;
            $value = trim($textarea->plaintext);
            if(!is_null($key) && !is_null($value)) {
                if(array_key_exists($key,$ret)) {
                    //同名カラムが存在する場合は配列にして取得
                    if(!is_array($ret[$key])) {
                        $wk = $ret[$key];
                        $ret[$key] = array();
                        $ret[$key][] = $wk;
                    }
                    $ret[$key][] = trim($value);
                } else {
                    $ret[$key] = trim($value);
                }
            }
        }
        
        $html->clear();
        return $ret;
    }
    
    public function getSiteModel($id)
    {
        $model = isset(self::$_site_models[$id]) ? self::$_site_models[$id] : null;
        if(!$model) {
            throw new Exception("model not found > ".$id);
        }
        return $model;
    }
    
    public function getImgPath($filename)
    {
        return Config::get('application.work.img_path') . static::DIR_NAME . DIRECTORY_SEPARATOR . $filename;
    }
    
    /**
     * multipart/form-dataに飛ばすためのデータを作成する
     * @param array $fields
     * @param string $boundary
     * @param array $files
     * @return string postするための文字列データ
     */
    protected function multipart_build_query($fields, $boundary, $files=array()){
        $retval = '';
        foreach($fields as $key => $value){
            if(is_array($value)) {
                foreach($value as $v) {
                    $retval .= "--$boundary\n";
                    $retval .= "Content-Disposition: form-data; name=\"$key\"\n";
                    $retval .= "\n";
                    $retval .= $v."\n";
                }
            } else {
                $retval .= "--$boundary\n";
                $retval .= "Content-Disposition: form-data; name=\"$key\"\n";
                $retval .= "\n";
                $retval .= $value."\n";
            }
            
        }
        foreach($files as $key => $v){
            $retval .= "--$boundary\n";
            $retval .= "Content-Disposition: form-data; name=\"$key\"; filename=\"". $v['file_name'] ."\"\n";
            $retval .= "Content-Type: ". $v['content_type'] ."\n";
            $retval .= "\n";
            $retval .= $v['data'] . "\n";
        }
        $retval .= "--$boundary--";
        return $retval;
    }
    
    /**
     * 画像ファイルをmultipart/form-dataに保存できる形に成形する
     * $files = array(
     *    {$key} => {$file_path},
     *    ...
     * )
     * return array(
     *     {$key} => array(
     *             'file_name' => "実ファイル名",
     *             'content_type' => "ファイルのcontent-type",
     *             'data' => "file_get_contentsした文字データ",
     *         ),
     *     ...
     * )
     * @param array $files
     * @return array
     * @throws InvalidArgumentException
     */
    protected function build_postfield_files($files)
    {
        $ret = array();
        foreach($files as $name => $filepath) {
            switch(true) {
                case !is_file($filepath):
                case !is_readable($filepath):
                    throw new InvalidArgumentException($filepath." is not use");
            }
            $data = file_get_contents($filepath); //ファイル自体を取得
            $filename = call_user_func("end", explode(DIRECTORY_SEPARATOR, $filepath)); //ファイル名取得
            $fileInfo = new FInfo(FILEINFO_MIME_TYPE);
            $ret[$name] = array(
                'file_name' => call_user_func("end", explode(DIRECTORY_SEPARATOR, $filepath)), //ファイル名
                'content_type' => $fileInfo->file($filepath),
                'data' => $data,
            );
        }
        return $ret;
    }
    
    /**
     * ログインパラメータを作成する
     * @return array
     */
    abstract protected function craeteLoginParams();
    /**
     * ログインの成否を判定する
     * @return bool
     */
    abstract protected function checkLoginResult();
    
    /**
     * フェア一覧取得を行う
     */
    abstract public function getFairs($year,$month);
    
    /**
     * フェアの詳細情報を取得する
     */
    abstract public function getFairDetail($id,$chClose=true);
    
    /**
     * フェアの登録処理を行う
     */
    abstract public function addFair($id,$chClose=true);
    
    /**
     * フェアの更新処理を行う
     */
    abstract public function updateFair($id,$chClose=true);
    
    /**
     * フェアの削除処理を行う
     */
    abstract public function deleteFair($id,$chClose=true);
}
