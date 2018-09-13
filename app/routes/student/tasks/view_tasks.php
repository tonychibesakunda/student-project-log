<?php

$app->get('/student/tasks/view_tasks', $student(), function() use($app){

	$app->render('student/tasks/view_tasks.php');

})->name('student.view_tasks');

$app->post('/student/tasks/view_tasks', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_tasks.post');