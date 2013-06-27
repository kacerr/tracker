<?php
class Challenge extends Eloquent
{
	protected $table = 'blogposts';
	public $perPage = 6;


	public function Author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function challengers()
	{
	    return $this->belongsToMany('User', 'userChallenges', 'challenge_id', 'user_id');
	}

    public function extendedAttributes()
	{
    	return $this->morphMany('ExtendedAttribute', 'extendable', 'parentType', 'parentID');
    }


	public function newQuery($excludeDeleted = true)
    {
		/* we need to override newQuery method for model, 
		because we went to add type=2 filter everywhere */
    	return parent::newQuery()->where('type','=',2);
	}

	public function getHTMLContent()
	{
		return str_replace("\n", "<br>", $this->content);
	}	
}
  