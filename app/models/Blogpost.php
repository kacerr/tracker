<?php
class Blogpost extends Eloquent
{
	protected $table = 'blogposts';

	public function Author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function labels()
	{
		return $this->belongsToMany('Label', 'blogpost_labels', 'blogpost_id', 'label_id');
	}
}
  