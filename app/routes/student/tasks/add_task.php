<?php

$app->get('/student/tasks/add_task', $student(), function() use($app){

	$app->render('student/tasks/add_task.php');

})->name('student.add_task');

$app->post('/student/tasks/add_task', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.add_task.post');