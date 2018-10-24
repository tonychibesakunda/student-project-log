<?php

use Logbook\User\SupervisorInterest;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/profile/interests', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get supervisor interests 
	$query = "SELECT * FROM supervisor_interests WHERE supervisor_id=$supervisor_id";
	$supervisor_interests = DB::select(DB::raw($query));

	$app->render('supervisor/profile/interests.php',[
		'supervisor_interests' => $supervisor_interests
	]);

})->name('supervisor.interests');

$app->post('/supervisor/profile/interests', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get supervisor interests 
	$query = "SELECT * FROM supervisor_interests WHERE supervisor_id=$supervisor_id";
	$supervisor_interests = DB::select(DB::raw($query));

	$request = $app->request;

	//get user input
	$supervisorInterests = $request->post('supervisor_interests');

	//validate user input
	$v = $app->validation;

	$v->addRuleMessage('uniqueInterests', 'This set of interests has already been added.');

	$v->addRule('uniqueInterests', function($value, $input, $args) use($app){

		//supervisor details
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$supervisor_id = '';

		//get supervisor id
		$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$supervisor_id = $row->supervisor_id;
		}

	    $si = DB::table('supervisor_interests')
			    	->select('interests')
			    	->where([
			    		'supervisor_id' => $supervisor_id,
			    		'interests' => $value
			    	])
			    	->first();

		
	    return ! (bool) $si;
	});

	$v->validate([
		'supervisor_interests' => [$supervisorInterests, 'required|min(4)|uniqueInterests']
	]);

	if($v->passes()){

		//if record exists in database
		if(count($supervisor_interests) == 0){

			//insert record into supervisor_interests table
			DB::table('supervisor_interests')
				->insert([
					'supervisor_id' => $supervisor_id,
					'interests' => $supervisorInterests
				]);

			//flash message and redirect
			$app->flash('success', 'Your interests having been added to the system');
			return $app->response->redirect($app->urlFor('supervisor.interests'));
		}elseif(count($supervisor_interests) > 0){

			//update record into supervisor_interests table
			SupervisorInterest::where('supervisor_id', '=', $supervisor_id)
						->update([
							'interests' => $supervisorInterests
						]);

			//flash message and redirect
			$app->flash('success', 'Your interests have been updated successfully');
			return $app->response->redirect($app->urlFor('supervisor.interests'));
		}


	}

	

	$app->render('supervisor/profile/interests.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'supervisor_interests' => $supervisor_interests
	]);

})->name('supervisor.interests.post');