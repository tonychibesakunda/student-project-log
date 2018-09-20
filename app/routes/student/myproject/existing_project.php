<?php

$app->get('/student/myproject/existing_project', $student(), function() use($app){

	$app->render('student/myproject/existing_project.php');	

})->name('student.existing_project');

$app->post('/student/myproject/existing_project', $student(), function() use($app){

	

})->name('student.existing_project.post');