<?php
/**
 * フェアコンテンツ管理用クラス
 * @author admin-97
 */
class Content extends Eloquent
{
    const TYPE_REGULAR = 1;
    const TYPE_IRREGULAR = 2;
    public static $typeList = array(
        self::TYPE_REGULAR => 'レギュラー',
        self::TYPE_IRREGULAR => 'イレギュラー',
    );
}
