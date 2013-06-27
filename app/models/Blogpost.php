<?php
class Blogpost extends Eloquent
{
	/* blogpost types:
		type = 1 : regular blogpost
		type = 2 : challenge

		*/
	public static $blogPostTypes = array(
		1 => "blogpost",
		2 => "challenge"
		);

	/* each blog type can have "main" extended attributes */
	public static $blogTypeExtendedAttributes = array(
		1 => array(1,2,3),
		2 => array(101,102)
		);

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

    public function extendedAttributes()
	{
    	return $this->morphMany('ExtendedAttribute', 'extendable', 'parentType', 'parentID');
    }

	public function getHTMLContent()
	{
		return str_replace("\n", "<br>", $this->content);
	}
}
  