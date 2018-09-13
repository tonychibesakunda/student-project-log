<?php

$app->get('/supervisor/studentTasks/student_tasks', $supervisor(), function() use($app){

	$app->render('supervisor/studentTasks/student_tasks.php');

})->name('supervisor.student_tasks');

$app->post('/supervisor/studentTasks/student_tasks', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.student_tasks.post');