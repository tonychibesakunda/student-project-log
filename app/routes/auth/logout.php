<?php

$app->get('/logout', function() use($app){

	unset($_SESSION[$app->config->get('auth.session')]);

	//remove cookie
	if($app->getCookie($app->config->get('auth.remember'))){
		$app->auth->removeRememberCredentials();
		$app->deleteCookie($app->config->get('auth.remember'));
	}

	$app->flash('info', 'You have been logged out.');
	return $app->response->redirect($app->urlFor('login'));

})->name('logout');