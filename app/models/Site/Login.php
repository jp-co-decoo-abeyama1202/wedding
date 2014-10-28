<?php
/**
 * Description of Login
 *
 * @author admin-97
 */
class SiteLogin extends Eloquent {
    
    public $timestamps = false;
    protected $_decoded = false;
    
    public static function find($id, $columns = array('*'))
    {
        $obj = parent::find($id,$columns);
        if($obj) {
            $obj->password = Crypt::decrypt($obj->password);
            $obj->update_password = $obj->update_password ? Crypt::decrypt($obj->update_password) : $obj->update_password;
        }
        return $obj;
    }
    
    public function dummy()
    {
        $this->login_id = '';
        $this->password = '';
        $this->update_password = '';
        $this->last_login_at = 0;
    }
    
    public function save(array $options = array())
    {
        if(!Auth::check()) {
            throw new BadMethodCallException();
        }
        $this->updated_id = Auth::user()->id;
        $this->password = Crypt::encrypt($this->password);
        $this->update_password = $this->update_password ? Crypt::encrypt($this->update_password) : $this->update_password;
        parent::save($options);
        $this->password = Crypt::decrypt($this->password);
        $this->update_password = $this->update_password ? Crypt::decrypt($this->update_password) : $this->update_password;
    }
}
