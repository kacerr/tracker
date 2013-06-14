<?php
class BlogsController extends BaseController
{
	public $restful = true;

	public function index()
	{
		return View::make('blogpost.index')->with(array("title" => "Blogs listing"));
	}

	public function create()
	{
		return View::Make('blogpost.new')->with(array("title" => "Blogs - add blogpost"));;
	}

	public function destroy($id)
	{
		$blogpost = Blogpost::find($id);
		$blogpost->delete();
		return Redirect::to('blogpost')->with('flash_notice', "Blogpost $blogpost->title was deleted !!!");
	}

	public function edit($id)
	{
		$blogpost = Blogpost::find($id);
		return View::Make('blogpost.new')->with(array("title" => "Blogs - edit blogpost", "action" => "edit", "blogpost" => $blogpost));
	}


	public function show()
	{
		return "show method, gonna show element: ";
		#return View::make('blogpost.index')->with(array("title" => "Blogs listing"));
	}

	public function store()
	{
    	$input = Input::all();
    	$rules = array('title' => 'required');

	    $validator = Validator::make($input, $rules);

    	if ($validator->fails())
    	{
      		return Redirect::to('/blogpost/create')->withErrors($validator)->withInput();
   		}
    	else
    	{
    		// gonna save it here
    		if (isset($input['id']))
    		{
    			$blogpost = Blogpost::find($input['id']);
    		}
    		else
    		{
	    		$blogpost = new Blogpost;
	    		$blogpost->user_id = Auth::user()->id;
			}
    		$blogpost->title = $input['title'];
    		$blogpost->content = $input['content'];
    		if (isset($input['visible']) &&  $input['visible']=="1") $blogpost->visible=true;
    		else $blogpost->visible=false;
    		$blogpost->save();

    		if (isset($input['id']))
    			return Redirect::to('blogpost')->with('flash_notice', "Blogpost id: $blogpost->id was updated.");
    		else
    			return Redirect::to('blogpost')->with('flash_notice', "Blogpost $blogpost->title saved.");
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