<?php

$app->get('/student/tasks/complete_task', $student(), function() use($app){

	$app->render('student/tasks/complete_task.php');

})->name('student.complete_task');

$app->post('/student/tasks/complete_task', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.complete_task.post');