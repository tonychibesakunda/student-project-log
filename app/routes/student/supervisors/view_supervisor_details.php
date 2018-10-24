<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/supervisors/view_supervisor_details/:id', $student(), function($spID) use($app){

	//get supervisor details
	$query = "SELECT supervisors.supervisor_id, supervisors.student_expectations, users.first_name, users.other_names, users.last_name, supervisor_interests.interests, COUNT(supervisions.student_id) AS numOfStudents FROM supervisors INNER JOIN users ON supervisors.user_id=users.id LEFT JOIN supervisor_interests ON supervisors.supervisor_id=supervisor_interests.supervisor_id LEFT JOIN supervisions ON supervisors.supervisor_id=supervisions.supervisor_id WHERE supervisors.supervisor_id=$spID";
	$supervisor_details = DB::select(DB::raw($query));

	$app->render('student/supervisors/view_supervisor_details.php',[
		'supervisor_details' => $supervisor_details
	]);

})->name('student.view_supervisor_details');

$app->post('/student/supervisors/view_supervisor_details', $student(), function() use($app){
	
})->name('student.view_supervisor_details.post');