<?php

$app->get('/supervisor/studentTasks/review_task', $supervisor(), function() use($app){

	$app->render('supervisor/studentTasks/review_task.php');

})->name('supervisor.review_task');

$app->post('/supervisor/studentTasks/review_task', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.review_task.post');