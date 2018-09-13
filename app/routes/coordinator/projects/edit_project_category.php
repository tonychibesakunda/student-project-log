<?php

$app->get('/coordinator/projects/edit_project_category', $coordinator(), function() use($app){
	$app->render('coordinator/projects/edit_project_category.php');
})->name('coordinator.edit_project_category');

$app->post('/coordinator/projects/edit_project_category', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.edit_project_category.post');