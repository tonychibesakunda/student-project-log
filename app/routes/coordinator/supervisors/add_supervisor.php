<?php

$app->get('/coordinator/supervisors/add_supervisor', $coordinator(), function() use($app){

	$app->render('coordinator/supervisors/add_supervisor.php');

})->name('coordinator.add_supervisor');

$app->post('/coordinator/supervisors/add_supervisor', $coordinator(), function() use($app){
	echo 'Functionality not yet addded';
})->name('coordinator.add_supervisor.post');