<?php
class Measurement extends Eloquent
{
	protected $table = 'measurements';
	public $timestamps = false;	

	public function Author()
	{
		return $this->belongsTo('User', 'user_id');
	}
}
  