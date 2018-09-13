<?php

$app->get('/student/tasks/edit_task', $student(), function() use($app){

	$app->render('student/tasks/edit_task.php');

})->name('student.edit_task');

$app->post('/student/tasks/edit_task', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.edit_task.post');