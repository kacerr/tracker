<?php
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface
{
  protected $table = 'users';

  public static function makePassword($textPassword)
  {
    return Hash::make($textPassword);
  }

  /* relationships */
  public function blogposts()
  {
    return $this->hasMany('Blogpost');
  }

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