<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mwed
 *
 * @author admin-97
 */
class FairMwed extends FairSite 
{
    public function contents()
    {
        return $this->hasMany('FairMwedContent');
    }
}
