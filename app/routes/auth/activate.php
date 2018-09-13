<?php
//activate user account via link sent in email
$app->get('/activate', $guest(), function() use($app){
	
	$request = $app->request;	

	$email = $request->get('email');
	$identifier = $request->get('identifier');

	$hashedIdentifier = $app->hash->hash($identifier);

	$user = $app->user->where('email', $email)->where('active', false)->first();

	//check if user not found or hash doesn't match
	if(!$user || !$app->hash->hashCheck($user->active_hash, $hashedIdentifier)){
		$app->flash('warning', 'There was a problem activating your account.');
		return $app->response->redirect($app->urlFor('home'));
	}else{
		//activate account
		$user->activateAccount();

		$app->flash('success', 'Your account has been activated and you can sign in.');
		return $app->response->redirect($app->urlFor('login'));
	}

})->name('activate');