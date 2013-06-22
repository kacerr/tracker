<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	protected $perPage;

	public function __construct()
	{
		$this->perPage = Config::get('tracker.pagination-home');		
	}	

	public function getIndex()
	{
        $title = "Index page from the view";
        $blogposts = Label::find(1)->blogposts()->where('visible', '=', '1')->orderBy('updated_at', 'desc')->paginate($this->perPage);
        return View::make('index')
        	->with(array(
        		'title' => $title,
        		'blogposts' => $blogposts)
        	);		
	}

	public function toggleDebug()
	{
		if (Session::get('debug')) Session::put('debug', false);
		else Session::put('debug', true);

		return Redirect::to($_SERVER['HTTP_REFERER']);

	}

	public function showWelcome()
	{
		return View::make('hello');
	}
}