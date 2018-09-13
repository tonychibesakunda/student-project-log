<?php
/*
*
*	USED FOR FILTERING ROUTES
*
*/

//authentication check
$authenticationCheck = function($required) use ($app){
	return function() use ($required, $app){

		if((!$app->auth && $required) || ($app->auth && !$required)){
			$app->redirect($app->urlFor('home'));
		}
		
	};
};

//Authenticated users only
$authenticated = function() use ($authenticationCheck){
	return $authenticationCheck(true);
};

//Guest users only
$guest = function() use ($authenticationCheck){
	return $authenticationCheck(false);
};

//Project Coordinator
$coordinator = function() use ($app){
	return function() use ($app){
		if(!$app->auth || !$app->auth->isCoordinator()){
			$app->redirect($app->urlFor('login'));
		}
	};
};

//HOD
$hod = function() use ($app){
	return function() use ($app){
		if(!$app->auth || !$app->auth->isHod()){
			$app->redirect($app->urlFor('login'));
		}
	};
};

//Supervisor
$supervisor = function() use ($app){
	return function() use ($app){
		if(!$app->auth || !$app->auth->isSupervisor()){
			$app->redirect($app->urlFor('login'));
		}
	};
};

//Student
$student = function() use ($app){
	return function() use ($app){
		if(!$app->auth || !$app->auth->isStudent()){
			$app->redirect($app->urlFor('login'));
		}
	};
};