<?php

$app->get('/supervisor/studentTasks/confirm_task', $supervisor(), function() use($app){

	$app->render('supervisor/studentTasks/confirm_task.php');

})->name('supervisor.confirm_task');

$app->post('/supervisor/studentTasks/confirm_task', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.confirm_task.post');