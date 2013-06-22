<?php
class Blogpost extends Eloquent
{
	protected $table = 'blogposts';
	public $perPage = 6;

	public function Author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function labels()
	{
		return $this->belongsToMany('Label', 'blogpost_labels', 'blogpost_id', 'label_id');
	}

	public function getHTMLContent()
	{
		return str_replace("\n", "<br>", $this->content);
	}
}
  