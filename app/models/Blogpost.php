<?php
class Blogpost extends Eloquent
{
	protected $table = 'blogposts';

	public function Author()
	{
		return $this->belongsTo('User', 'user_id');
	}
}
  