<?php

$app->get('/coordinator/supervisors/view_supervisor', $coordinator(), function() use($app){

	$app->render('coordinator/supervisors/view_supervisor.php');

})->name('coordinator.view_supervisor');

$app->post('/coordinator/supervisors/view_supervisor', $coordinator(), function() use($app){

})->name('coordinator.view_supervisor.post');