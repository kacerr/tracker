<?php
class UsersController extends BaseController
{


  public function getIndex()
  {
    $title = "login";
    return View::make('user.index')
      ->with('title', $title);
    #return print_r($_REQUEST, true) . "<br><br> This is the users index";
  }

  public function postLogin()
  {
    $input = Input::all();

    $rules = array(
      'email' => 'required|email',
      'password' => 'required'
      );

    $oValidator = Validator::make($input, $rules);

    if ($oValidator->fails())
    {
      return Redirect::to('login')->withErrors($oValidator)->withInput();
    }
    else
    {
      $credentials = array('email' => $input['email'], 'password' => $input['password']);
      if (Auth::attempt($credentials))
      {
        return Redirect::to('profile')->with('flash_notice', 'You are successfully logged in.');
      }
      else
      {
        $oMB = $oValidator->getMessageBag();
        $oValidator->getMessageBag()->Add('Auth', 'Authentication failed: Your username/password combination was incorrect.');
        #var_dump($oMB);
        return Redirect::to('login')->withErrors($oValidator)->withInput();
      }
    }


    $title = "login";
    return View::make('user.index')
      ->with('title', $title);    
  }

  public function getRegister()
  {
    $title = "register user";
    return View::make('user.register')
      ->with('title', $title);
  } 

  public function postRegister()
  {
    $input = Input::all();

    if (isset($input['action']) && $input['action']=='update-profile')
    {
      $rules = array('email' => 'required');
    }
    else
    {
      $rules = array(
        'email' => 'required|unique:users|email',
        'password' => 'required'
        );
    }

    $oValidator = Validator::make($input, $rules);

    if ($oValidator->fails())
    {
      return Redirect::to('register')->withErrors($oValidator)->withInput();
    }
    else
    {
      if (isset($input['action']) && $input['action']=='update-profile')
      {
        $user = User::where('email', '=', $input['email'])->first();
      }
      else 
      {
        $user = new User;
        $password = Hash::make($input['password']);
        $user->password = $password;
        $user->email = $input['email'];
      }
      $user->name = $input['name'];
      $user->surname = $input['surname'];
      $user->save();

      if (isset($input['action']) && $input['action']=='update-profile')
      {
        return Redirect::to('login')->with('flash_notice', 'User profile was sucessfully updated');
      }
      else
      {
        return Redirect::to('login')->with('flash_notice', 'New login: ' . $input['email'] . ' was sucessfully created');;
      }
    }
  }

 public function getProfile()
  {
    $title = "PROFILE";
    return View::make('user.profile')
      ->with('title', $title);
  } 


  public function getList()
  {
        $user = new User();
        $users = User::all();
        foreach ($users as $user)
		{
		    echo $user->email . " : " . $user->name . " " . $user->surname . "<br>";
		}  
  }

  public function getLogout()
  {
    Auth::logout();
    return Redirect::to('/');
  }
}