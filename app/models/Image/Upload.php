<?php
/**
 * 画像アップロード管理クラス
 * @author admin-97
 */
class ImageUpload extends Eloquent 
{
    const ID_ZEXY_1 = 11;
    const ID_ZEXY_2 = 12;
    const ID_ZEXY_3 = 13;
    const ID_MYNAVI = 20;
    const ID_RAKUTEN = 30;
    public static $idList = array(
        self::ID_ZEXY_1 => 'ゼクシィ（カテゴリ1）',
        self::ID_ZEXY_2 => 'ゼクシィ（カテゴリ2）',
        self::ID_ZEXY_3 => 'ゼクシィ（カテゴリ3）',
        self::ID_MYNAVI => 'マイナビ',
        self::ID_RAKUTEN => '楽天',
    );
    
    const STATE_RUN = 1;
    const STATE_OFF = 0;
    public static $stateList = array(
        self::STATE_RUN => '取得中',
        self::STATE_OFF => '待機中',
    );
    
    public static function getZexy($kbn)
    {
        $id = 0;
        switch($kbn) {
            case 1:
                $id = self::ID_ZEXY_1;
                break;
            case 2:
                $id = self::ID_ZEXY_2;
                break;
            case 3:
                $id = self::ID_ZEXY_3;
                break;
        }
        if(!$id) {
            throw new InvalidArgumentException();
        }
        return $this->findOrFail($id);
    }
    
    public static function getZexys()
    {
        return self::whereIn('id',array(self::ID_ZEXY_1,self::ID_ZEXY_2,self::ID_ZEXY_3))->get();
    }
    
    public static function getMynavi()
    {
        return $this->findOrFail(self::ID_MYNAVI);
    }
    
    public static function getRakuten()
    {
        return $this->findOrFail(self::ID_RAKUTEN);
    }
    
    public static function checkZexy()
    {
        $uploads = self::whereIn('id',array(self::ID_ZEXY_1,self::ID_ZEXY_2,self::ID_ZEXY_3))->whereState(self::STATE_OFF)->get();
        return count($uploads) === 3;
    }
    
    public static function checkMynavi()
    {
        $upload = self::find(self::ID_MYNAVI);
        return $upload && $upload->state == self::STATE_OFF ? true : false;
    }
    
    public static function checkRakuten()
    {
        $upload = self::find(self::ID_RAKUTEN);
        return $upload && $upload->state == self::STATE_OFF ? true : false;
    }
}
