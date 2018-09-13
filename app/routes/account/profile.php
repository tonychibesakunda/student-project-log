<?php

$app->get('/account/profile', $authenticated(), function() use($app){
	$app->render('account/profile.php');
})->name('account.profile');

$app->post('/account/profile', $authenticated(), function() use($app){

	$request = $app->request;

	$email = $request->post('email');

	$v = $app->validation;

	$v->validate([
		'email' => [$email, 'required|email|uniqueEmail']
	]);

	if($v->passes()){
		$app->auth->update([
			'email' => $email
		]);

		$app->flash('success', 'Your details have been updated.');
		return $app->response->redirect($app->urlFor('account.profile'));
	}

	$app->render('account/profile.php', [
		'errors' => $v->errors(),
		'request' => $request
	]);


})->name('account.profile.post');