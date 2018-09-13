<?php

$app->get('/hod/students/view_assigned_students', $hod(), function() use($app){

	$app->render('hod/students/view_assigned_students.php');

})->name('hod.view_assigned_students');

$app->post('/hod/students/view_assigned_students', $hod(), function() use($app){
	echo 'Functionality not yet addded';
})->name('hod.view_assigned_students.post');