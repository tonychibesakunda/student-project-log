<?php

$app->get('/supervisor/profile/student_expectations', $supervisor(), function() use($app){

	$app->render('supervisor/profile/student_expectations.php');

})->name('supervisor.student_expectations');

$app->post('/supervisor/profile/student_expectations', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.student_expectations.post');