<?php

$app->get('/coordinator/projects/view_assigned_supervisors', $coordinator(), function() use($app){
	$app->render('coordinator/projects/view_assigned_supervisors.php');
})->name('coordinator.view_assigned_supervisors');

$app->post('/coordinator/projects/view_assigned_supervisors', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.view_assigned_supervisors.post');