<?php

$app->get('/supervisor/dashboard', $supervisor(), function() use($app){

	$app->render('/supervisor/dashboard/dashboard.php');

})->name('supervisor.dashboard');