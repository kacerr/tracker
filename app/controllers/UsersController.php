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
        return Redirect::to('/user/dashboard')->with('flash_notice', 'You are successfully logged in.');
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

  public function getRecover()
  {
    $input = Input::all();
    if (isset($input['email']))
    {
      $user = User::where('email' , '=', $input['email'])->first();
      //echo "<pre>" . var_dump($user) . "</pre>";
      //die;
      if ($user!=null)
      {
        $passwordRecovery = new PasswordRecovery;
        $passwordRecovery->user_id=$user->id;
        $passwordRecovery->token = uniqid();
        $passwordRecovery->valid_to = (new DateTime())->add(new DateInterval('P1D'));
        $passwordRecovery->save();

        # and we need to send an email also
        $data = array ("token" => $passwordRecovery->token, "user" => $user);
        Mail::send('emails.recovery', $data, function($message) use ($data)
        {
            $message->to($data['user']->email, $data['user']->name . " " . $data['user']->surname)->subject('Tracker APP password recovery');
        });

        return View::make('user.recover')->with(array('user' => $user, 'title' => 'password recovery'));
      }
      else
      {
        return $this->getIndex(); 
      }
    }
    else
    {
        
    }
    
  }

  public function passwordResetForm($token)
  {
    #echo "here we gonna reset the password. Token is: $token";
    $passwordRecovery = PasswordRecovery::where('token', '=', $token)->first();
    if (!is_null($passwordRecovery))
    {
      return View::make('user.reset')->with(array('title' => 'Password reset',  'passwordRecovery' => $passwordRecovery));
    }
    else
    {
      echo "Invalid token, i can't do anything for you!";
    }
  }

  public function passwordReset()
  {
    $input = Input::all();
    $passwordRecovery = PasswordRecovery::where('token', '=', $input['token'])->first();
    if (!is_null($passwordRecovery) && $passwordRecovery->user_id == $input['user_id'] && $passwordRecovery->valid_to < new DateTime())
    {
      $user = User::find($passwordRecovery->user_id);
      $user->password = User::makePassword($input['password']);
      $user->save();
      PasswordRecovery::where('token', '=', $input['token'])->delete();
      return Redirect::to('login')->with('flash_notice', 'Your password was updated!');
    }
    else
    {
      echo "I'm sorry, your request cannot be completed, either token is wrong, or it has expired!";
    }
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
        $password = User::makePassword($input['password']);
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
        return Redirect::to('login')->with('flash_notice', 'New login: ' . $input['email'] . ' was sucessfully created');
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

  public function showDashboard()
  {
    $title = 'user dashboard';
    if (Auth::user()) $user = Auth::user();
    else return Redirect::to('/login');
    $data = compact('user', 'title');
    return View::make('user.dashboard', $data);
  }
}