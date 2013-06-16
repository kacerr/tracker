<?php
class Label extends Eloquent
{
	protected $table = 'labels';
	public $timestamps = false;	

	public function blogposts()
	{
		return $this->belongsToMany('Blogpost','blogpost_labels', 'label_id', 'blogpost_id');
	}

	public static function isLabelSet($label_id, $labels)
	{
		if ($labels === null) return false;
		foreach ($labels as $label)
		{
			if ($label->id == $label_id) return true;
		}
		return false;
	}
}
  