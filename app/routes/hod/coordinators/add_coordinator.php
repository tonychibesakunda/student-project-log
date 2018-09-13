<?php
use Logbook\User\UserPermission;
use Logbook\User\Location;
use Logbook\User\School;
use Logbook\User\Department;

use Illuminate\Database\Capsule\Manager as DB;
$app->get('/hod/coordinators/add_coordinator', $hod(), function() use($app){
	$query = 'SELECT * FROM schools';
	$query2 = 'SELECT * FROM departments';
	$schools = DB::select(DB::raw($query));
	$departments = DB::select(DB::raw($query2));

	$app->render('hod/coordinators/add_coordinator.php',[
		'schools' => $schools,
		'departments' => $departments
	]);

})->name('hod.add_coordinator');

$app->post('/hod/coordinators/add_coordinator', $hod(), function() use($app){
	$query = 'SELECT * FROM schools';
	$query2 = 'SELECT * FROM departments';
	$schools = DB::select(DB::raw($query));
	$departments = DB::select(DB::raw($query2));

	$request = $app->request;

	//get user input
	$username = $request->post('user_name');
	$email = $request->post('email');
	$password = $request->post('password');
	$passwordConfirm = $request->post('password_confirm');
	$school = $request->post('selectSchool');
	$dept = $request->post('selectDept');

	//validate user input
	$v = $app->validation;

	$v->validate([
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
			'username' => $username,
			'email' => $email,
			'password' => $app->hash->password($password),
			'active' => false,
			'active_hash' => $app->hash->hash($identifier)
		]);

		//create permissions record and fill it with student default values
		$user->permissions()->create(UserPermission::$coordinatorDefault);

		// create locations
		$user->locations()->create([
			'school_id' => $school,
			'department_id' => $dept
		]);

		// Send email
		$app->mail->send('email/auth/registered.php', ['user' => $user, 'identifier' => $identifier], function($message) use($user){
			$message->to($user->email);
			$message->subject('Thanks for registering.');
		});

		$app->flash('success', 'Project coordinator successfully added.');
		return $app->response->redirect($app->urlFor('hod.add_coordinator'));
	}

	//pass errors into view and save previous type info
	$app->render('hod/coordinators/add_coordinator.php', [
		'errors' => $v->errors(),
		'request' => $request,
		'schools' => $schools,
		'departments' => $departments
	]);
})->name('hod.add_coordinator.post');