<?php

$app->get('/student/projects/view_project_details', $student(), function() use($app){

	$app->render('student/projects/view_project_details.php');

})->name('student.view_project_details');

$app->post('/student/projects/view_project_details', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_project_details.post');