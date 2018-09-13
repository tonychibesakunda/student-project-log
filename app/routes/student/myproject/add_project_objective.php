<?php

$app->get('/student/myproject/add_project_objective', $student(), function() use($app){

	$app->render('student/myproject/add_project_objective.php');

})->name('student.add_project_objective');

$app->post('/student/myproject/add_project_objective', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.add_project_objective.post');