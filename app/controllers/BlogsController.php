<?php
class BlogsController extends BaseController
{
	public $restful = true;

	/*
	protected $perPage;

	public function __construct()
	{
		$this->perPage = Config::get('tracker.pagination-blog');		
	}
	*/

	public function index()
	{
		/* it alreaady starts getting mor complicated
		- view only :: viewOnly == true :: show view only all posts with the label (if set)
		- other :: isAdmin == true :: show editable all items
		- other :: isAdmin == false :: show only users own items
		*/
		if (Auth::user()) $currentUser = Auth::user();
		else $currentUser = null;



		$input = Input::all();
		$urlParams = array();

		if ((isset($input['viewOnly']) && $input['viewOnly']))
		{
			if (isset($input['label']))
			{
				$blogposts = Label::find($input['label'])->blogposts()->orderBy('updated_at', 'desc')->paginate();
				$urlParams["label"] = $input['label'];
			}
			else $blogposts = Blogpost::orderBy('updated_at', 'desc')->paginate();			
		}
		else
		{
			/* TODO: probably move to filter 
				if we don't have logged user -> redirect to login */

			if ($currentUser===NULL) return Redirect::to('/login');

			if ($currentUser!==NULL && $currentUser->isAdmin())
			{
				/* user is admin / has permissions to edit ALL posts */
				if (isset($input['label']))
				{
					$blogposts = Label::find($input['label'])->blogposts()->orderBy('updated_at', 'desc')->paginate();
					$urlParams["label"] = $input['label'];
				}
				#else $blogposts = Blogpost::orderBy('updated_at', 'desc')->get();
				else $blogposts = Blogpost::orderBy('updated_at', 'desc')->paginate();
			}
			else
			{
				/* he can work with his own items only */
				if (isset($input['label']))
				{
					$blogposts = Label::find($input['label'])->blogposts()->where('user_id', '=', $currentUser->id)->orderBy('updated_at', 'desc')->paginate();
				}
				else $blogposts = Blogpost::where('user_id', '=', $currentUser->id)->orderBy('updated_at', 'desc')->paginate();
			}

		}

		$labels = Label::all();

		
		return View::make('blogpost.index')
			->with(array(
				"title" => "Blogs listing",
				 "blogposts" => $blogposts,
				 "labels" => $labels,
				 "urlParams" => $urlParams,
				 "currentUser" => $currentUser));
	}

	public function create()
	{
		return View::Make('blogpost.new')->with(array(
			"title" => "Blogs - add blogpost", 
			"setLabels" => null,
			"action" => "new"
			));
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
	    //$extendedAttributes = $blogpost->extendedAttributes()->with('ExtendedAttributeType')->whereIn('id', Blogpost::$blogTypeExtendedAttributes[$blogpost->type])->get();
	    $extendedAttributes = $blogpost->extendedAttributes()->with('ExtendedAttributeType')->get();
		/* we first fill "main" extended attributes */
	    $attributeTypes = ExtendedAttributeType::whereIn('id', Blogpost::$blogTypeExtendedAttributes[$blogpost->type])->get();
	    /* and so far we omit the rest of available attributes */	
		return View::Make('blogpost.new')->with(array(
			"title" => "Blogs - edit blogpost", 
			"action" => "edit", 
			"blogpost" => $blogpost, 
	        'extendedAttributes' => $extendedAttributes,
	        'attributeTypes' => $attributeTypes,
			"setLabels" => $setLabels));
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
    		$blogpost->type = $input['type'];
    		$blogpost->title = $input['title'];
    		$blogpost->content = $input['content'];
    		if (isset($input['visible']) &&  $input['visible']=="1") $blogpost->visible=true;
    		else $blogpost->visible=false;
    		$blogpost->save();

    		# we need to "attach" and "detach" labels
    		# seems to be too difficult, easier solution would be calling own sql query
    		# first of all we delete all labels for this post
    		DB::table('blogpost_labels')
    			->where('blogpost_id', '=', $blogpost->id)->delete();
    		# and then we add currently set labels
    		if (isset($input['label']))
    		{
				foreach ($input['label'] as $key => $value) {
    				DB::table('blogpost_labels')->insert(array("blogpost_id" => $blogpost->id, "label_id" => $value));
    			}
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