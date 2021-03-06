<?php
use Logbook\User\UserPermission;
use Logbook\User\Location;
use Logbook\User\School;
use Logbook\User\Department;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/supervisors/add_supervisor', $coordinator(), function() use($app){

	$query = 'SELECT * FROM schools';
	$query2 = 'SELECT * FROM departments';
	$schools = DB::select(DB::raw($query));
	$departments = DB::select(DB::raw($query2));

	$app->render('coordinator/supervisors/add_supervisor.php',[
		'schools' => $schools,
		'departments' => $departments
	]);

})->name('coordinator.add_supervisor');

$app->post('/coordinator/supervisors/add_supervisor', $coordinator(), function() use($app){

	$query = 'SELECT * FROM schools';
	$query2 = 'SELECT * FROM departments';
	$schools = DB::select(DB::raw($query));
	$departments = DB::select(DB::raw($query2));
	
	//store everything sent to this route
	$request = $app->request;

	//get user input
	$first_name = $request->post('first_name');
	$last_name = $request->post('last_name');
	$other_names = $request->post('other_names');
	$username = $request->post('user_name');
	$email = $request->post('email');
	$password = $request->post('password');
	$passwordConfirm = $request->post('password_confirm');
	$school = $request->post('selectSchool');
	$dept = $request->post('selectDept');

	//validate user input
	$v = $app->validation;

	$v->validate([
		'first_name' => [$first_name, 'required|alnumDash|max(150)'],
		'last_name' => [$last_name, 'required|alnumDash|max(150)'],
		'other_names' => [$other_names, 'alnumDash|max(150)'],
		'username' => [$username, 'required|alnumDash|max(150)|uniqueUsername'],
		'email' => [$email, 'required|email|uniqueEmail'],
		'password' => [$password, 'required|min(8)'],
		'password_confirm' => [$passwordConfirm, 'required|matches(password)'],
		'selectSchool' => [$school, 'int'],
		'selectDept' => [$dept, 'int']
	]);

	if ($v->passes()){

		//random string
		$identifier = $app->randomlib->generateString(128);

		//use user model(Logbook/User/User.php) to create user record using eloquent
		$user = $app->user->create([
			'first_name' => $first_name,
			'last_name' => $last_name,
			'other_names' => $other_names,
			'username' => $username,
			'email' => $email,
			'password' => $app->hash->password($password),
			'active' => false,
			'active_hash' => $app->hash->hash($identifier)
		]);

		//create permissions record and fill it with student default values
		$user->permissions()->create(UserPermission::$supervisorDefault);

		//insert records in locations table
		$user->locations()->create([
			'school_id' => $school,
			'department_id' => $dept
		]);

		//insert records in supervisors table
		$user->supervisors()->create();

		//die('Form Posted');
		// Send email
		$app->mail->send('email/auth/registered.php', ['user' => $user, 'identifier' => $identifier], function($message) use($user){
			$message->to($user->email);
			$message->subject('Thanks for registering.');
		});

		$app->flash('success', 'Supervisor successfully added.');
		return $app->response->redirect($app->urlFor('coordinator.add_supervisor'));
	}

	//pass errors into view and save previous type info
	$app->render('coordinator/supervisors/add_supervisor.php', [
		'errors' => $v->errors(),
		'request' => $request,
		'schools' => $schools,
		'departments' => $departments
	]);
})->name('coordinator.add_supervisor.post');