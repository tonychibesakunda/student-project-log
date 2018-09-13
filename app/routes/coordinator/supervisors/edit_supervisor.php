<?php

$app->get('/coordinator/supervisors/edit_supervisor', $coordinator(), function() use($app){

	$app->render('coordinator/supervisors/edit_supervisor.php');

})->name('coordinator.edit_supervisor');

$app->post('/coordinator/supervisors/edit_supervisor', $coordinator(), function() use($app){
	echo 'Functionality not yet addded';
})->name('coordinator.edit_supervisor.post');