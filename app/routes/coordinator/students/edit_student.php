<?php

$app->get('/coordinator/students/edit_student', $coordinator(), function() use($app){

	$app->render('coordinator/students/edit_student.php');

})->name('coordinator.edit_student');

$app->post('/coordinator/students/edit_student', $coordinator(), function() use($app){

})->name('coordinator.edit_student.post');