<?php
/**
 * Description of Exception
 *
 * @author admin-97
 */
class WorkException extends Exception {
    const CODE_OTHER = 0;
    const CODE_LOGIN_FAILED = 1;
    const CODE_LOGOUT_FAILED = 2;
    //取得系
    const CODE_FAIR_GET_FAILED = 10;
    const CODE_IMAGE_GET_FAILED = 11;
    //登録系
    const CODE_FAIR_ADD_FAILED = 20;
    const CODE_IMAGE_UPLOAD_FAILED = 21;
    //更新系
    const CODE_FAIR_UPDATE_FAILED = 30;
    //削除系
    const CODE_FAIR_DELETE_FAILED = 40;
    //Zexy系
    const CODE_ZEXY_TOKEN_NOTFOUND = 101;
    //楽天系
    const CODE_RAKUTEN_UPDATE_LOCK = 501;
    const CODE_RAKUTEN_LOGOUT_FAILED = 502;
    //その他
    const CODE_CONNECT_FAILED = 999;
    
    protected $_messages = array(
        self::CODE_OTHER => 'その他の例外',
        self::CODE_LOGIN_FAILED => 'ログイン失敗',
        self::CODE_LOGOUT_FAILED => 'ログアウト失敗',
        self::CODE_FAIR_GET_FAILED => 'フェア取得失敗',
        self::CODE_IMAGE_GET_FAILED => '画像取得失敗',
        self::CODE_FAIR_ADD_FAILED => 'フェア登録失敗',
        self::CODE_IMAGE_UPLOAD_FAILED => '画像アップロード失敗',
        self::CODE_FAIR_UPDATE_FAILED => 'フェア更新失敗',
        self::CODE_FAIR_DELETE_FAILED => 'フェア削除失敗',
        self::CODE_ZEXY_TOKEN_NOTFOUND => 'Zexy:token取得失敗',
        self::CODE_RAKUTEN_UPDATE_LOCK => '楽天：更新画面ロック中',
        self::CODE_RAKUTEN_LOGOUT_FAILED => '楽天：更新画面ログアウト失敗',
        self::CODE_CONNECT_FAILED => '接続失敗',
    );
    
    /**
     * @var Curl
     */
    protected $_curl;
    
    public function __construct($code = self::CODE_OTHER, Curl $curl = null) {
        $message = null;
        if(array_key_exists($code,$this->_messages)) {
            $message = $this->_messages[$code];
        }
        $this->_curl = $curl;
        parent::__construct($message, $code, null);
    }
    
    // オブジェクトの文字列表現を独自に定義する
    public function __toString() {
        $ret = __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        if($this->_curl && $this->_curl->getInfo()) {
            $info = $this->_curl->getInfo();
            $ret.= 'CURL_INFO > http_code: ['.$info['http_code'].'] url: [' .$info['url'] ."]\n";
        }
        $ret .= $this->getTraceAsString();
        return $ret;
    }
}
