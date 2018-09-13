<?php

$app->get('/coordinator/projects/view_project_type', $coordinator(), function() use($app){
	$app->render('coordinator/projects/view_project_type.php');
})->name('coordinator.view_project_type');

$app->post('/coordinator/projects/view_project_type', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.view_project_type.post');