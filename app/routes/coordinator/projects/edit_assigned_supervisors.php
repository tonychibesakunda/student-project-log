<?php

$app->get('/coordinator/projects/edit_assigned_supervisors', $coordinator(), function() use($app){
	$app->render('coordinator/projects/edit_assigned_supervisors.php');
})->name('coordinator.edit_assigned_supervisors');

$app->post('/coordinator/projects/edit_assigned_supervisors', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.edit_assigned_supervisors.post');