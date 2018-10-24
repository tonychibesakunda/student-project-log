<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/projects/student_projects', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get student projects
	$query = "SELECT supervisions.supervision_id, students.is_final_project_report_approved ,users.first_name,users.last_name,users.other_names,projects.project_name FROM supervisions INNER JOIN students ON supervisions.student_id =students.student_id INNER JOIN  users ON students.user_id=users.id LEFT JOIN projects ON students.project_id=projects.project_id WHERE supervisions.supervisor_id=$supervisor_id";
	$student_projects = DB::select(DB::raw($query));

	$app->render('supervisor/projects/student_projects.php',[
		'student_projects' => $student_projects
	]);

})->name('supervisor.student_projects');

$app->post('/supervisor/projects/student_projects', $supervisor(), function() use($app){
	
})->name('supervisor.student_projects.post');