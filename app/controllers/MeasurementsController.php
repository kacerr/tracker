<?php
class MeasurementsController extends BaseController
{
	public $restful = true;

	public function index()
	{
		/* if not specifically called using "json" you see only "your own measurements"
		*/
		if (Auth::user()) $currentUser = Auth::user();
		else $currentUser = null;

		/* TODO: probably move to filter 
			if we don't have logged user -> redirect to login */
		if ($currentUser===NULL) return Redirect::to('/login');

		$urlParams = array();
		$input = Input::all();
		if (isset($input['json']))
		{
			if (isset($input['userID'])) $measurementUser = $input['userID']; else $measurementUser=$currentUser->id;
			if (isset($input['name']))
			{
				foreach ($input['name'] as $name) 
				{
					$measurements = Measurement::whereRaw('user_id = ? and name = ?', array($measurementUser, $name))->orderBy('taken')->get();
					$outMeasurements[$name]=$measurements;
				}
			}
			else
			{
				/* NOTE: makes no real sense, but we want to return some default measurement */
				$measurements = Measurement::whereRaw('user_id = ? and name = ?', array($measurementUser, 'weight'))->orderBy('taken')->get();
				$outMeasurements['weight']=$measurements;
			}

			$outArray = array();
			foreach ($outMeasurements as $key => $value)
			{
				foreach ($outMeasurements[$key] as $measurement)
				{
					$oDate = new DateTime($measurement->taken);
					if (!isset($outArray[$key])) $outArray[$key] = array();
					array_push($outArray[$key], array($oDate->format("U"), $measurement->value));
				}
			}
		
			echo(json_encode($outArray));
		}
		else
		{
			/* now we work with _$REQUEST['name'] array, if it exists, we want filter just these measurements */
			if (isset($input['name']))
			{
				$names = $input['name'];
				$urlParams["name"] = $names;
				$measurements = User::find($currentUser->id)->measurements()->whereIn('name', $names)->paginate();
				$graphsRequest = "/measurement/?json=true&name[]=" . implode("&name[]=", $names);
			}
			else
			{
				$measurements = User::find($currentUser->id)->measurements()->paginate();
				$names=array();
				$graphsRequest="";
			}
			$measurementNames = Measurement::getUserMeasurementNames($currentUser->id);
			return View::make('measurement.index')
			->with(array(
				"title" => "measurements listing", 
				"measurements" => $measurements, 
				"measurementNames" => $measurementNames,
				"names" => $names,
				"urlParams" => $urlParams,
				"graphsRequest" => $graphsRequest)
			);	
		} 
	}

	public function create()
	{
		$measurement = new Measurement;
		return View::Make('measurement.new')->with(array("title" => "measurements - add measurement", "measurement" => $measurement));;
	}

	public function destroy($id)
	{
		$measurement = Measurement::find($id);
		$measurement->delete();
		return Redirect::to('measurement')->with('flash_notice', "measurement $measurement->title was deleted !!!");
	}

	public function edit($id)
	{
		$measurement = Measurement::find($id);
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
	    		$measurement = new Measurement;
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