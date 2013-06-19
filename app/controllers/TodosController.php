<?php
class TodosController extends BaseController
{
	public $restful = true;

	public function index()
	{
		return View::make('todo.index')->with(array("title" => "Todos listing"));
	}

	public function create()
	{
		return View::Make('todo.new')->with(array("title" => "Todos - add todo"));;
	}

	public function destroy($id)
	{
		$todo = todo::find($id);
		$todo->delete();
		return Redirect::to('todo')->with('flash_notice', "todo $todo->title was deleted !!!");
	}

	public function edit($id)
	{
		$todo = todo::find($id);
		return View::Make('todo.new')->with(array("title" => "Todos - edit todo", "action" => "edit", "todo" => $todo));
	}


	public function show()
	{
		#return "show method, gonna show element: ";
		return View::make('todo.index')->with(array("title" => "Todos listing"));
	}

	public function store()
	{
    	$input = Input::all();
    	$rules = array('topic' => 'required');

	    $validator = Validator::make($input, $rules);

    	if ($validator->fails())
    	{
      		return Redirect::to('/todo/create')->withErrors($validator)->withInput();
   		}
    	else
    	{
    		// gonna save it here
    		if (isset($input['id']))
    		{
    			$todo = todo::find($input['id']);
    		}
    		else
    		{
	    		$todo = new todo;
	    		$todo->user_id = Auth::user()->id;
			}
    		$todo->topic = $input['topic'];
    		$todo->description = $input['description'];
    		$todo->status = $input['status'];
    		if (isset($input['visible']) &&  $input['visible']=="1") $todo->visible=true;
    		else $todo->visible=false;
    		$todo->save();

    		if (isset($input['id']))
    			return Redirect::to('todo')->with('flash_notice', "todo id: $todo->id was updated.");
    		else
    			return Redirect::to('todo')->with('flash_notice', "todo $todo->title saved.");
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