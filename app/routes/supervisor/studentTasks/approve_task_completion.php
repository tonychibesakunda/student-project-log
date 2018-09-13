<?php

$app->get('/supervisor/studentTasks/approve_task_completion', $supervisor(), function() use($app){

	$app->render('supervisor/studentTasks/approve_task_completion.php');

})->name('supervisor.approve_task_completion');

$app->post('/supervisor/studentTasks/approve_task_completion', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.approve_task_completion.post');