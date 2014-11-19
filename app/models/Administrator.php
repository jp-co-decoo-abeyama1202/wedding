<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Administrator extends Eloquent implements UserInterface, RemindableInterface {
    
    use UserTrait, RemindableTrait, SoftDeletingTrait;
    
    protected $guarded = array('id');
    protected $softDelete = true;
    
    const ROLE_GUEST = 1;
    const ROLE_OPERATOR = 2;
    const ROLE_ADMINISTRATOR = 3;
    const ROLE_DEVELOPER = 4;
    
    public static $roleList = array(
        self::ROLE_GUEST => '閲覧のみ',
        self::ROLE_OPERATOR => 'オペレーター',
        self::ROLE_ADMINISTRATOR => '管理者',
    );
    
    public static $roleListAll = array(
        self::ROLE_GUEST => '閲覧のみ',
        self::ROLE_OPERATOR => 'オペレーター',
        self::ROLE_ADMINISTRATOR => '管理者',
        self::ROLE_DEVELOPER => '開発者',
    );
    
    public static $attrNames = array(
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'confirm' => '確認用パスワード',
        'nickname' => '表示名',
        'role' => '権限',
    );
    
    public static function getValidator($inputs,$password=true)
    {
        $rules = array(
            'email' => array('required','email','max:100'),
            'nickname' => array('required','mb_max:50'),
            'role' => array('required','in:'.implode(',',array_keys(self::$roleListAll))),
        );
        if($password) {
            $rules['password'] = array('required','alpha_dash','between:10,50');
            $rules['confirm'] = array('required','alpha_dash','between:10,50');
        }
        $validation = Validator::make($inputs,$rules);
        $validation->setAttributeNames(self::$attrNames);
        return $validation;
    }
    
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
}