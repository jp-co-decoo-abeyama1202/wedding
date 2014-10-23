<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mynavi
 *
 * @author admin-97
 */
class FairMynavi extends FairSite 
{
    //put your code here
    public function contents()
    {
        return $this->hasMany('FairMynaviContent');
    }
}
