<?php

$app->get('/student/dashboard', $student(), function() use($app){

	$app->render('/student/dashboard/dashboard.php');

})->name('student.dashboard');