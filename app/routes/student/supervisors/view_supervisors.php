<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/supervisors/view_supervisors', $student(), function() use($app){

	//get supervisor details
	$query = "SELECT supervisors.supervisor_id, users.first_name, users.other_names, users.last_name, supervisor_interests.interests FROM supervisors INNER JOIN users ON supervisors.user_id=users.id LEFT JOIN supervisor_interests ON supervisors.supervisor_id=supervisor_interests.supervisor_id";
	$supervisors = DB::select(DB::raw($query));

	$app->render('student/supervisors/view_supervisors.php',[
		'supervisors' => $supervisors
	]);

})->name('student.view_supervisors');

$app->post('/student/supervisors/view_supervisors', $student(), function() use($app){
	
})->name('student.view_supervisors.post');