<?php
/**
 * Description of Fair
 *
 * @author admin-97
 */
class Fair extends Eloquent {
    public function gnavi()
    {
        return $this->hasOne('FairGnavi');
    }
    
    public function mwed()
    {
        return $this->hasOne('FairMwed');
    }
    
    public function mynavi()
    {
        return $this->hasOne('FairMynavi');
    }
    
    public function park()
    {
        return $this->hasOne('FairPark');
    }
    
    public function rakuten()
    {
        return $this->hasOne('FairRakuten');
    }
    
    public function sugukon()
    {
        return $this->hasOne('FairSugukon');
    }
    
    public function zexy()
    {
        return $this->hasOne('FairZexy');
    }
    
    public function dates()
    {
        return $this->hasMeny('FairDate');
    }
}
