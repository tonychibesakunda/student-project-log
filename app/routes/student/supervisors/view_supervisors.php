<?php

$app->get('/student/supervisors/view_supervisors', $student(), function() use($app){

	$app->render('student/supervisors/view_supervisors.php');

})->name('student.view_supervisors');

$app->post('/student/supervisors/view_supervisors', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_supervisors.post');