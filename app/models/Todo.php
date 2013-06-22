<?php
class Todo extends Eloquent
{
	protected $table = 'todos';
	public static $status = array("1" => "new", "2" => "in progress", "3" => "completed");
	public $perPage = 10;

	public function Author()
	{
		return $this->belongsTo('User', 'user_id');
	}
}
  