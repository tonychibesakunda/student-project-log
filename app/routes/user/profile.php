<?php

$app->get('/u/:username', function($username) use($app){
	//check if user exists
	$user = $app->user->where('username', $username)->first();

	//if user doesn't exist show a 404 page not found
	if(!$user){
		$app->notFound();
	}

	//render a view if user exists
	$app->render('user/profile.php', [
		'user' => $user
	]);	
})->name('user.profile');