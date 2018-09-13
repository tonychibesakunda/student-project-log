<?php

$app->get('/student/myproject/add_project', $student(), function() use($app){

	$app->render('student/myproject/add_project.php');

})->name('student.add_project');

$app->post('/student/myproject/add_project', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.add_project.post');