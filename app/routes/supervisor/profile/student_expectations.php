<?php

use Logbook\User\Supervisor;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/profile/student_expectations', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get student expectations 
	$query = "SELECT student_expectations FROM supervisors WHERE supervisor_id=$supervisor_id";
	$student_expectations = DB::select(DB::raw($query));

	$app->render('supervisor/profile/student_expectations.php',[
		'student_expectations' => $student_expectations
	]);

})->name('supervisor.student_expectations');

$app->post('/supervisor/profile/student_expectations', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get student expectations 
	$query = "SELECT student_expectations FROM supervisors WHERE supervisor_id=$supervisor_id";
	$student_expectations = DB::select(DB::raw($query));

	$request = $app->request;

	//get user input
	$studentExpectations = $request->post('student_expectations');

	//validate user input
	$v = $app->validation;

	$v->addRuleMessage('uniqueExpectations', 'This set of expectations has already been added.');

	$v->addRule('uniqueExpectations', function($value, $input, $args) use($app){

		//supervisor details
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$supervisor_id = '';

		//get supervisor id
		$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$supervisor_id = $row->supervisor_id;
		}

	    $se = DB::table('supervisors')
			    	->select('student_expectations')
			    	->where([
			    		'supervisor_id' => $supervisor_id,
			    		'student_expectations' => $value
			    	])
			    	->first();

		
	    return ! (bool) $se;
	});

	$v->validate([
		'student_expectations' => [$studentExpectations, 'required|min(4)|uniqueExpectations']
	]);

	if($v->passes()){


		//update record into supervisor_interests table
		Supervisor::where('supervisor_id', '=', $supervisor_id)
					->update([
						'student_expectations' => $studentExpectations
					]);

		//flash message and redirect
		$app->flash('success', 'Your student expectations have been added successfully');
		return $app->response->redirect($app->urlFor('supervisor.student_expectations'));

	}

	$app->render('supervisor/profile/student_expectations.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'student_expectations' => $student_expectations
	]);

})->name('supervisor.student_expectations.post');