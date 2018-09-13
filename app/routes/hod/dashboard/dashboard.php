<?php

$app->get('/hod/dashboard', $hod(), function() use($app){

	$app->render('/hod/dashboard/dashboard.php');

})->name('hod.dashboard');