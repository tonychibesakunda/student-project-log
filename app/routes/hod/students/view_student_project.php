<?php

$app->get('/hod/students/view_student_project', $hod(), function() use($app){

	$app->render('hod/students/view_student_project.php');

})->name('hod.view_student_project');

$app->post('/hod/students/view_student_project', $hod(), function() use($app){
	echo 'Functionality not yet addded';
})->name('hod.view_student_project.post');