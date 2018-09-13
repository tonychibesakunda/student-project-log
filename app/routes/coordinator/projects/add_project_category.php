<?php

$app->get('/coordinator/projects/add_project_category', $coordinator(), function() use($app){
	$app->render('coordinator/projects/add_project_category.php');
})->name('coordinator.add_project_category');

$app->post('/coordinator/projects/add_project_category', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.add_project_category.post');