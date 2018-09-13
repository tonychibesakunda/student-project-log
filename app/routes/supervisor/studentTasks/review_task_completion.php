<?php

$app->get('/supervisor/studentTasks/review_task_completion', $supervisor(), function() use($app){

	$app->render('supervisor/studentTasks/review_task_completion.php');

})->name('supervisor.review_task_completion');

$app->post('/supervisor/studentTasks/review_task_completion', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.review_task_completion.post');