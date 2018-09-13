<?php

$app->get('/coordinator/dashboard', $coordinator(), function() use($app){

	$app->render('/coordinator/dashboard/dashboard.php');

})->name('coordinator.dashboard');