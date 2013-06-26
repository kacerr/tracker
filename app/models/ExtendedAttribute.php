<?php
class ExtendedAttribute extends Eloquent
{
	protected $table = 'extendedAttribute';
	public $timestamps = false;	

	public function ExtendedAttributeType()
	{
		return $this->belongsTo('ExtendedAttributeType', 'attributeId', 'id');
	}

	public function extendable()
	{
		return $this->morphTo();
	}
}

class ExtendedAttributeType extends Eloquent
{
	protected $table = 'extendedAttributeType';
	public $timestamps = false;	

	public function ExtendedAttribute()
	{
		return $this->hasMany('ExtendedAttribute');
	}
}