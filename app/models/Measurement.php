<?php
class Measurement extends Eloquent
{
	protected $table = 'measurements';
	public $timestamps = false;	
	public $perPage = 10;

	public function Author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public static function getUserMeasurementNames($userID)
	{
		/* returns array of existing user measurement names */
		$names = DB::select('SELECT DISTINCT name FROM measurements WHERE user_id=? ', array($userID));
		return ($names);
	}

}
  