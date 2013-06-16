<?php
class MeasurementsController extends BaseController
{
	public $restful = true;

	public function index()
	{
		return View::make('measurement.index')->with(array("title" => "measurements listing"));
	}

	public function create()
	{
		$measurement = new Measurement;
		return View::Make('measurement.new')->with(array("title" => "measurements - add measurement", "measurement" => $measurement));;
	}

	public function destroy($id)
	{
		$measurement = measurement::find($id);
		$measurement->delete();
		return Redirect::to('measurement')->with('flash_notice', "measurement $measurement->title was deleted !!!");
	}

	public function edit($id)
	{
		$measurement = measurement::find($id);
		return View::Make('measurement.new')->with(array("title" => "measurements - edit measurement", "action" => "edit", "measurement" => $measurement));
	}


	public function show()
	{
		return "show method, gonna show element: ";
		#return View::make('measurement.index')->with(array("title" => "measurements listing"));
	}

	public function store()
	{
    	$input = Input::all();
    	$rules = array('name' => 'required', 'value' => 'required');

	    $validator = Validator::make($input, $rules);

    	if ($validator->fails())
    	{
      		return Redirect::to('/measurement/create')->withErrors($validator)->withInput();
   		}
    	else
    	{
    		// gonna save it here
    		if (isset($input['id']) && $input['id']!="")
    		{
    			$measurement = measurement::find($input['id']);
    		}
    		else
    		{
	    		$measurement = new measurement;
	    		$measurement->user_id = Auth::user()->id;
			}
    		$measurement->name = $input['name'];
    		$measurement->value = $input['value'];
    		$measurement->taken = $input['taken'];
    		$measurement->save();

    		if (isset($input['id']))
    			return Redirect::to('measurement')->with('flash_notice', "measurement id: $measurement->id was updated.");
    		else
    			return Redirect::to('measurement')->with('flash_notice', "measurement $measurement->title saved.");
    	}
    }

	public function getAdd()
	{
		return "and now we are going to add some posts!";
	}
	public function missingMethod($parameters)
	{
		return "finally we got into the MISSING METHOD";
	}
}