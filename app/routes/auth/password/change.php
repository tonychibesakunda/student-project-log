<?php

$app->get('/change-password', $authenticated(), function() use($app){
	$app->render('auth/password/change.php');
})->name('password.change');

$app->post('/change-password', $authenticated(), function() use($app){

	//grab request object
	$request = $app->request;

	$passwordOld = $app->request->post('password_old');
	$password = $app->request->post('password');
	$passwordConfirm = $app->request->post('password_confirm');

	//validate user input
	$v = $app->validation;

	$v->validate([
		'password_old' => [$passwordOld, 'required|matchesCurrentPassword'],
		'password' => [$password, 'required|min(8)'],
		'password_confirm' => [$passwordConfirm, 'required|matches(password)']
	]);

	if($v->passes()){

		$user = $app->auth;
		//update and save password in database
		$user->update([
			'password' => $app->hash->password($password)
		]);

		//send email to show that password has been changed
		$app->mail->send('email/auth/password/changed.php', [], function($message) use ($user){
			$message->to($user->email);
			$message->subject('You changed your password.');
		});

		//show flash message that password has changed
		$app->flash('success', 'You have successfully changed your password');
		return $app->response->redirect($app->urlFor('password.change'));
	}

	$app->render('auth/password/change.php', [
		'errors' => $v->errors() 
	]);	

})->name('password.change.post');