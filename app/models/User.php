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

  public function challenges()
  {
    return $this->belongsToMany('Challenge', 'userChallenges', 'user_id', 'challenge_id');
  }


  public function measurements()
  {
    return $this->hasMany('Measurement');
  }

  public function extendedAttributes()
  {
    return $this->morphMany('ExtendedAttribute', 'extendable', 'parentType', 'parentID');
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

  public function isAdmin()
  {
    if ($this->user_class>=99) return true;
    else return false;
  }

  public function unacceptChallenge($challengeID)
  {
    DB::table('userChallenges')
          ->where('user_id', '=', $this->id)
          ->where('challenge_id', '=', $challengeID)
          ->delete();    
  }

  public function acceptChallenge($challengeID)
  {
    DB::table('userChallenges')->insert(array(
        'user_id' => $this->id,
        'challenge_id' => $challengeID
      ));
  }
}