<?php

$app->get('/coordinator/projects/view_project_category', $coordinator(), function() use($app){
	$app->render('coordinator/projects/view_project_category.php');
})->name('coordinator.view_project_category');

$app->post('/coordinator/projects/view_project_category', $coordinator(), function() use($app){
	echo 'Functionality not yet added';
})->name('coordinator.view_project_category.post');