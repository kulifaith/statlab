<?php

namespace  App\Models;

//use Zizaco\Entrust\HasRole;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Spatie\Permission\Models\Role;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

//class User extends Model implements UserInterface, RemindableInterface {
class User extends Model implements AuthenticatableContract, CanResetPasswordContract, Authorizable{

    use SoftDeletes;
	use HasRoles;
    use Authenticatable, CanResetPassword;

    const EXTERNAL_SYSTEM_USER = 2;
	const MALE = 0;
	const FEMALE = 1;

	//Set Laravel Spatie guard property
    protected $guard_name = 'web';
	/**
	 * Enabling soft deletes on the user table.
	 *
	 */
	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

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
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

    /**
     * Set the token value for the "remember me" session.
     *
     * @param $value
     * @return void
     */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return "remember_token";
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

	/**
	 * Get the admin user currently the first user
	 *
	 * @return User model
	 */
	public static function getAdminUser()
	{
		return User::find(1);
	}

    public static function getAdminRole()
    {
        return Role::find(1);
    }

    public function can($ability, $arguments = [])
    {
        // TODO: Implement can() method.
    }


}
