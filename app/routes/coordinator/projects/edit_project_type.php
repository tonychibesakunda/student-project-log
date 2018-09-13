<?php

$app->get('/coordinator/projects/edit_project_type', $coordinator(), function() use($app){
	$app->render('coordinator/projects/edit_project_type.php');
})->name('coordinator.edit_project_type');

$app->post('/coordinator/projects/edit_project_type', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.edit_project_type.post');