<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/u/:username', function($username) use($app){
	//check if user exists
	$user = $app->user->where('username', $username)->first();

	$query = "SELECT users.*, locations.user_id, locations.school_id, locations.department_id, schools.school_id, schools.school_name, departments.department_id, departments.department_name FROM users INNER JOIN locations ON users.id=locations.user_id INNER JOIN schools ON locations.school_id=schools.school_id INNER JOIN departments ON locations.department_id=departments.department_id WHERE users.username='$username'";
	$users = DB::select(DB::raw($query));

	//if user doesn't exist show a 404 page not found
	if(!$user){
		$app->notFound();
	}

	//render a view if user exists
	$app->render('user/profile.php', [
		'user' => $user,
		'users' => $users
	]);	
})->name('user.profile');