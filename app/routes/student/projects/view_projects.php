<?php

$app->get('/student/projects/view_projects', $student(), function() use($app){

	$app->render('student/projects/view_projects.php');

})->name('student.view_projects');

$app->post('/student/projects/view_projects', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_projects.post');