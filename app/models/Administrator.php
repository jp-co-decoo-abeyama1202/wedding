<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Administrator extends Eloquent implements UserInterface, RemindableInterface {
    
    use UserTrait, RemindableTrait;
    
    const ROLL_GUEST = 1;
    const ROLL_OPERATOR = 2;
    const ROLL_ADMINISTRATOR = 3;
    const ROLL_DEVELOPER = 4;
    
    public static $_rollList = array(
        self::ROLL_GUEST => '閲覧のみ',
        self::ROLL_OPERATOR => 'オペレーター',
        self::ROLL_ADMINISTRATOR => '管理者',
    );
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'administrators';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }
}