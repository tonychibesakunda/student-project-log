<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/myproject/edit_project/:id', $student(), function($projectId) use($app){

	$query = 'SELECT * FROM project_categories';
	$query2 = 'SELECT * FROM project_types';
	$project_categories = DB::select(DB::raw($query));
	$project_types = DB::select(DB::raw($query2));

	//get project details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$query3 = "SELECT projects.*, students.project_start_date, students.project_end_date, students.project_aims FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.user_id=$user_id";
	$projects = DB::select(DB::raw($query3));

	$app->render('student/myproject/edit_project.php',[
		'projects' => $projects,
		'project_categories' => $project_categories,
		'project_types' => $project_types
	]);

})->name('student.edit_project');

$app->post('/student/myproject/edit_project', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.edit_project.post');