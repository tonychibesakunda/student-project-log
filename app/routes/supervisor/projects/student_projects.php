<?php

$app->get('/supervisor/projects/student_projects', $supervisor(), function() use($app){

	$app->render('supervisor/projects/student_projects.php');

})->name('supervisor.student_projects');

$app->post('/supervisor/projects/student_projects', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.student_projects.post');