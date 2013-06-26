<?php
class ExtendedAttributesController extends BaseController
{
	public $restful = true;

	public function index()
	{
		if (Request::isJson)
		{
			return "json BABY!";
		}
		else
		{
			return "oh yeah!";	
		}
	}

	public function store()
	{
		$input = Input::all();
		$extendedAttribute = new extendedAttribute;
		$extendedAttribute->attributeId = $input['attributeTypeID'];
		$extendedAttribute->parentId = $input['parentID'];
		$extendedAttribute->parentType = $input['parentType'];
		$extendedAttribute->value = $input['value'];
		$extendedAttribute->save();

		return Response::json(array( 'success' => true, 'input' => $input));
		# return "gonna save it ... " . var_dump($_POST);
	}

	public function destroy($id)
	{
		/* should be more secured, but at least we check if there is someone logged in */
		if (Auth::user())
		{
			$extendedAttribute = extendedAttribute::find($id);
			$extendedAttribute->delete();
		return Response::json(array( 
			'success' => true,
			'message' => 'Extended attribute was deleted!'
			));

		}
	}
	public function missingMethod($parameters)
	{
		return "finally we got into the MISSING METHOD";
	}	
}	