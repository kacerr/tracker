<?php

#$logger = new Profiler\Logger\Logger;
#$profiler = new Profiler\Profiler($logger);

/* listeners for debugging and understanding */
Event::listen('laravel.query', function($sql)
{
        global $sqlHistory;
        $sqlHistory .= $sql . "<br>";
        #var_dump($sql);
        #echo "COOOOOOO";
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@getIndex');
Route::get('/toggledebug', 'HomeController@toggleDebug');
Route::get('login', 'UsersController@getIndex');
Route::post('login', 'UsersController@postLogin');
Route::get('logout', 'UsersController@getLogout');
Route::get('register', 'UsersController@getRegister');
Route::get('recover', 'UsersController@getRecover');
Route::post('recover', 'UsersController@getRecover');
Route::get('password/reset/{token}', 'UsersController@passwordResetForm');
Route::post('password/reset', 'UsersController@passwordReset');
Route::post('register', 'UsersController@postRegister');
Route::get('profile', 'UsersController@getProfile');
#Route::get('/','HomeController@actionIndex');

Route::resource('blogpost', 'BlogsController');
Route::resource('todo', 'TodosController');
Route::resource('measurement', 'MeasurementsController');
#Route::get('blog', 'BlogsController@show');
#Route::controller('blog', 'BlogsController');
#Route::controller('users', 'UsersController');
#Route::get('/users','UsersController@actionIndex');
Route::get('/codetest', function()
{
        /* flot test */
        $sHTML=<<< EOF
                <html>
                <script src="/js/jquery.js"></script>
                <script src="/js/jquery.flot.js"></script>
                <script language="javascript">
                        $( document ).ready(function() {
                                $.plot($("#placeholder"), [ [[1, 171], [2, 172], [3,170] ] ], { yaxis: { max: 200, min:1 } });
                        });
                </script>
                <body>
                                <div id="placeholder" style="width:600px;height:300px"></div>
                </body>
                </html>
EOF;
        echo ($sHTML);
        die;
        

        #$bp = Blogpost::find(1);
        #$labels = $bp->labels()->get();
        #echo "<pre>" . print_r($labels, true) . "</pre>";
        #$author = $bp->author();
        #$labels = $bp->Labels();
        #$bp->create(array('title' => '1st post','content' => 'blogpost content'));
        # var_dump($author)       ;
        #echo "" . "<br>";
        
        #$blogposts = Blogpost::all();
        #var_dump($blogposts);

        #Event::fire('laravel.query', array('sql' => 'are you going to do something?'));
        #->insert(array('title' => '1st post','content' => 'blogpost content'));
        #return View::make('index')->with('title', 'code:test');

        
        /*$handle = fopen("http://dev.web-goodies.eu/tmp/auta.txt", "r");
        $contents = fread($handle, 10000);
        echo "-------- contents before conversion: <br><hr>";
        echo $contents;
        echo "<br><br> ------- after conversion: <br><hr>";
        $contentsConverted = iconv("Windows-1250", "UTF-8", $contents);
        echo $contentsConverted;
        */
});

Route::get('/index', function()
{
        $title = "Index page from the view";
        return View::make('index')
        	->with('title', $title);
});
/*

Route::get('login', function()
{
        $title = "login";
        return View::make('user.index')
        	->with('title', $title);
});

Route::get('register', function()
{
        $title = "register user";
        return View::make('user.register')
        	->with('title', $title);
});

Route::get('/nonexistent', function()
{
        global $app;
        $sOut = "";
        #$sOut.= print_r($app,true);
        $sOut.= "simplest route modification";

        $sOut .= "<br>";
        $sOut .= "<a href='/users/list'>list users</a><br>";
        return $sOut;

});
*/


