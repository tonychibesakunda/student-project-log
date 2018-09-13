<?php
/*
*
*	LOGIN ROUTE AND LOGIC
*
*/

use Carbon\Carbon;

use Logbook\User\UserPermission;

$app->get('/login', $guest(), function() use($app){
	$app->render('auth/login.php');
})->name('login');

$app->post('/login', $guest(), function() use($app){
	//request object
	$request = $app->request;

	$username = $request->post('username');
	$password = $request->post('password');
	$remember = $request->post('remember');

	//validate user input
	$v = $app->validation;

	$v->validate([
		'username' => [$username, 'required'],
		'password' => [$password, 'required']
	]);

	if($v->passes()){
		//log the user in
		$user = $app->user->where('username', $username)->where('active', true)->first();//->orWhere('email', $username);
		$inactiveUser = $app->user->where('username', $username)->where('active', false)->first();

		if($user && $app->hash->passwordCheck($password, $user->password)){
			$_SESSION[$app->config->get('auth.session')] = $user->id;

			//check if remember me has been checked
			if($remember = 'on'){
				$rememberIdentifier = $app->randomlib->generateString(128);
				$rememberToken = $app->randomlib->generateString(128);

				$user->updateRememberCredentials(
					$rememberIdentifier,
					$app->hash->hash($rememberToken)
				);

				//set a cookie
				$app->setCookie(
					$app->config->get('auth.remember'),
					"{$rememberIdentifier}___{$rememberToken}",
					Carbon::parse('+1 week')->timestamp 
				);
			}

			if($user->isCoordinator()){
				$app->flash('success', 'You are now signed in!');
				return $app->response->redirect($app->urlFor('coordinator.dashboard'));
			}elseif($user->isStudent()){
				$app->flash('success', 'You are now signed in!');
				return $app->response->redirect($app->urlFor('student.dashboard'));
			}elseif($user->isSupervisor()){
				$app->flash('success', 'You are now signed in!');
				return $app->response->redirect($app->urlFor('supervisor.dashboard'));
			}elseif($user->isHod()){
				$app->flash('success', 'You are now signed in!');
				return $app->response->redirect($app->urlFor('hod.dashboard'));
			}

			
			
		}elseif ($inactiveUser) {
			$app->flash('warning', 'Your account has not been activated!');
			return $app->response->redirect($app->urlFor('login'));
		}else{
			$app->flash('error', 'Invalid user credentials!');
			return $app->response->redirect($app->urlFor('login'));
		}


	}
	//show errors 
	$app->render('auth/login.php', [
		'errors' => $v->errors(),
		'request' => $request
	]);

})->name('login.post');