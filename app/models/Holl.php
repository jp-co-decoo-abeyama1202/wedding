<?php
/**
 * 会場情報クラス
 * @author admin-97
 */
class Holl extends Eloquent 
{
    protected $guarded = array('id');
    
    const TEL_SYUBETSU_NORMAL = 1;
    const TEL_SYUBETSU_FREE = 2;
    const TEL_SYUBETSU_FAX = 3;
    public static $telSyubetsuList = array(
        self::TEL_SYUBETSU_NORMAL => 'TEL',
        self::TEL_SYUBETSU_FREE => '無料TEL',
        self::TEL_SYUBETSU_FAX => 'FAX',
    );
    
    public static $attrNames = array(
        'address' => '所在地',
        'parking' => '駐車場',
        'address_note' => 'その他',
        'tel1_1' => '電話番号1-1',
        'tel1_2' => '電話番号1-2',
        'tel1_3' => '電話番号1-3',
        'tel1_syubetsu' => '電話番号1種別',
        'tel1_tanto' => '電話番号1担当窓口',
        'tel2_1' => '電話番号2-1',
        'tel2_2' => '電話番号2-2',
        'tel2_3' => '電話番号2-3',
        'tel2_syubetsu' => '電話番号2種別',
        'tel2_tanto' => '電話番号2担当窓口',
        'inquery_time' => '問合せ受付時間',
        'inquery_support_name' => '問合せ担当',
    );
    
    public static function getValidator($inputs)
    {
        $rules = array(
            'address' => array('required','mb_max:100'),
            'parking' => array('required','mb_max:50'),
            'address_note' => array('mb_max:50'),
            'tel1_1' => array('required','numeric','mb_max:4'),
            'tel1_2' => array('required','numeric','mb_max:4'),
            'tel1_3' => array('required','numeric','mb_max:4'),
            'tel1_syubetsu' => array('required','in:'.implode(',',array_keys(self::$telSyubetsuList))),
            'tel1_tanto' => array('required','mb_max:50'),
            'tel2_1' => array('numeric','mb_max:4','required_with:tel2_2,tel2_3'),
            'tel2_2' => array('numeric','mb_max:4','required_with:tel2_1,tel2_3'),
            'tel2_3' => array('numeric','mb_max:4','required_with:tel2_1,tel2_2'),
            'tel2_syubetsu' => array('in:'.implode(',',array_keys(self::$telSyubetsuList)),'required_with:tel2_1,tel2_2,tel2_3'),
            'tel2_tanto' => array('mb_max:50'),
            'inquery_time' => array('required','mb_max:50'),
            'inquery_support_name' => array('required','mb_max:50'),
        );
        $validation = Validator::make($inputs,$rules);
        $validation->setAttributeNames(self::$attrNames);
        return $validation;
    }
}
