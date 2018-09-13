<?php

$app->get('/coordinator/projects/assign_supervisors', $coordinator(), function() use($app){
	$app->render('coordinator/projects/assign_supervisors.php');
})->name('coordinator.assign_supervisors');

$app->post('/coordinator/projects/assign_supervisors', $coordinator(), function() use($app){
	echo 'functionality not added yet';
})->name('coordinator.assign_supervisors.post');