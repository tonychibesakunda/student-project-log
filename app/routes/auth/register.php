<?php

use Logbook\User\UserPermission;

$app->get('/register', $authenticated(), function() use ($app){
	$app->render('auth/register.php');
})->name('register');

$app->post('/register', $authenticated(), function() use ($app){
	
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

	//validate user input
	$v = $app->validation;

	$v->validate([
		'first_name' => [$first_name, 'required|alnumDash|max(20)'],
		'last_name' => [$last_name, 'required|alnumDash|max(20)'],
		'other_names' => [$other_names, 'alnumDash|max(20)'],
		'username' => [$username, 'required|alnumDash|max(20)|uniqueUsername'],
		'email' => [$email, 'required|email|uniqueEmail'],
		'password' => [$password, 'required|min(8)'],
		'password_confirm' => [$passwordConfirm, 'required|matches(password)'],
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
		$user->permissions()->create(UserPermission::$studentDefault);

		// Send email
		$app->mail->send('email/auth/registered.php', ['user' => $user, 'identifier' => $identifier], function($message) use($user){
			$message->to($user->email);
			$message->subject('Thanks for registering.');
		});

		$app->flash('success', 'Student successfully added.');
		$app->response->redirect('register');
	}

	//pass errors into view and save previous type info
	$app->render('auth/register.php', [
		'errors' => $v->errors(),
		'request' => $request,
	]);

	

})->name('register.post');