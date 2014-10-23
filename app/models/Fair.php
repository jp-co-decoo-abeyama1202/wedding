<?php
/**
 * フェア情報クラス
 * @author admin-97
 */
class Fair extends Eloquent 
{
    
    protected $softDelete = true;
    
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
    /**
     * フェア開催日付
     * @return type
     */
    public function dates()
    {
        return $this->hasMeny('FairDate');
    }
}
