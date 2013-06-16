<?php
class BlogsController extends BaseController
{
	public $restful = true;

	public function index()
	{
		$input = Input::all();
		if (isset($input['label']))
		{
			$blogposts = Label::find($input['label'])->blogposts()->get();
		}
		else $blogposts = Blogpost::all();
		$labels = Label::all();

		return View::make('blogpost.index')->with(array("title" => "Blogs listing", "blogposts" => $blogposts, "labels" => $labels));
	}

	public function create()
	{
		return View::Make('blogpost.new')->with(array("title" => "Blogs - add blogpost", "setLabels" => null));;
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
		$setLabels = $blogpost->labels()->get();
		return View::Make('blogpost.new')->with(array("title" => "Blogs - edit blogpost", "action" => "edit", "blogpost" => $blogpost, "setLabels" => $setLabels));
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

    		# we need to "attach" and "detach" labels
    		# seems to be too difficult, easier solution would be calling own sql query
    		$setOfLabels = "(" . implode($input['label'], ',') . ")";
    		# first of all we delete all labels for this post
    		DB::table('blogpost_labels')
    			->where('blogpost_id', '=', $blogpost->id)->delete();
    		# and then we add currently set labels
    		foreach ($input['label'] as $key => $value) {
    			DB::table('blogpost_labels')->insert(array("blogpost_id" => $blogpost->id, "label_id" => $value));
    		}
    		#echo "<pre>" . print_r($setOfLabels, true) . "</pre>";

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