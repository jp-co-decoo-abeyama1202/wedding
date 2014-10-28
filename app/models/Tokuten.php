<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 特典管理用クラス
 * @author admin-97
 */
class Tokuten  extends Eloquent
{
    const TYPE_FAIR = 1;
    const TYPE_CONTRACT = 2;
    public static $typeList = array(
        self::TYPE_FAIR => '下見・フェア特典',
        self::TYPE_CONTRACT => '成約特典',
    );
}
