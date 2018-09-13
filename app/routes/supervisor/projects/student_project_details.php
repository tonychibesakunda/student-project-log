<?php

$app->get('/supervisor/projects/student_project_details', $supervisor(), function() use($app){

	$app->render('supervisor/projects/student_project_details.php');

})->name('supervisor.student_project_details');

$app->post('/supervisor/projects/student_project_details', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.student_project_details.post');