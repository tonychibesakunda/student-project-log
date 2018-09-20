<?php

$app->get('/student/myproject/add_on_existing_project', $student(), function() use($app){

	$app->render('student/myproject/add_on_existing_project.php');	

})->name('student.add_on_existing_project');

$app->post('/student/myproject/add_on_existing_project', $student(), function() use($app){

	

})->name('student.add_on_existing_project.post');