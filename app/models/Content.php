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
    
    public function getContentName() 
    {
        $name = $this->rakuten_name_1;
        if($this->rakuten_name_2) {
            $name.= ':'.$this->rakuten_name_2;
        }
        if($this->rakuten_name_3) {
            $name.= ':'.$this->rakuten_name_3;
        }
        return $name;
    }
}
