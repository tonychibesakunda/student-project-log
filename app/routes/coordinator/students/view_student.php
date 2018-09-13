<?php

$app->get('/coordinator/students/view_student', $coordinator(), function() use($app){
	
	$app->render('coordinator/students/view_student.php');

})->name('coordinator.view_student');

$app->post('/coordinator/students/view_student', $coordinator(), function() use($app){
	echo 'form posted.';
})->name('coordinator.view_student.post');