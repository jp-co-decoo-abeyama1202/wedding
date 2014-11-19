<?php
/**
 * 各同期処理のログを管理するクラス
 */
class UploadLog extends Eloquent 
{
    protected $guarded = array('id');
    
    const STATE_REGIST = 1;
    const STATE_SUCCESS = 2;
    const STATE_FAILED = 3;
    public static $stateList = array(
        self::STATE_REGIST => '実行待ち',
        self::STATE_SUCCESS => '完了',
        self::STATE_FAILED => '失敗',
    );
    
    const TYPE_FAIR_ADD = 10;
    const TYPE_FAIR_EDIT = 11;
    const TYPE_FAIR_DELETE = 12;
    const TYPE_IMAGE_EDIT = 20;
    const TYPE_IMAGE_GET = 21;
    const TYPE_SPECIAL_EDIT = 30;
    const TYPE_SPECIAL_GET = 31;
    public static $stateList = array(
        self::TYPE_FAIR_ADD => 'フェア追加',
        self::TYPE_FAIR_EDIT => 'フェア更新',
        self::TYPE_FAIR_DELETE => 'フェア削除',
        self::TYPE_IMAGE_EDIT => '画像追加/編集',
        self::TYPE_IMAGE_GET => '画像取得',
        self::TYPE_SPECIAL_EDIT => '特典追加/編集',
        self::TYPE_SPECIAL_GET => '特典取得',
    );
    
}
