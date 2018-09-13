<?php

$app->get('/coordinator/projects/add_project_type', $coordinator(), function() use($app){
	$app->render('coordinator/projects/add_project_type.php');
})->name('coordinator.add_project_type');

$app->post('/coordinator/projects/add_project_type', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.add_project_type.post');