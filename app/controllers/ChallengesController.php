<?php
class ChallengesController extends BaseController
{
	public function index()
	{
		if (Auth::user()) $currentUser = Auth::user();
		else return Redirect::to('/');

		$challenges = Challenge::orderBy('created_at','desc')->paginate();
		# we figure out which challenges has user accepted
		$acceptedChallenges = $currentUser->challenges()->get();
		$aAcceptedChallenges = array();
		foreach ($acceptedChallenges as $challenge)
		{
			array_push($aAcceptedChallenges, $challenge->id);
		}
		return View::make('challenge.index')
			->with(array(
				"title" => "Challenges listing",
				 "challenges" => $challenges,
				 "aAcceptedChallenges" => $aAcceptedChallenges,
				 "urlParams" => array(),
				 "currentUser" => $currentUser));		
	}

	public function process()
	{
		if (Auth::user()) $currentUser = Auth::user();
		else return Redirect::to('/');
		$input = Input::all();
		if (isset($input['action']))
		{
			if ($input['action']=='unaccept')
			{
				# over here we are going to unnaccept challenge for current user
				$currentUser->unacceptChallenge($input['challengeID']);
				return Response::json(array( 'success' => true, 'input' => $input));			
			}
			elseif ($input['action']=='accept')
			{
				# over here we are going to unnaccept challenge for current user
				$currentUser->acceptChallenge($input['challengeID']);
				return Response::json(array( 'success' => true, 'input' => $input));			
			}
		}
		return var_dump($input) . "<br> gonna process that!";
	}
}