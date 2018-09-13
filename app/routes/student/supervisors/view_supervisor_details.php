<?php

$app->get('/student/supervisors/view_supervisor_details', $student(), function() use($app){

	$app->render('student/supervisors/view_supervisor_details.php');

})->name('student.view_supervisor_details');

$app->post('/student/supervisors/view_supervisor_details', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_supervisor_details.post');