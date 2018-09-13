<?php

$app->get('/coordinator/projects/view_projects', $coordinator(), function() use($app){
	$app->render('coordinator/projects/view_projects.php');
})->name('coordinator.view_projects');

$app->post('/coordinator/projects/view_projects', $coordinator(), function() use($app){
	echo 'Functionality not yet added';
})->name('coordinator.view_projects.post');