<?php

$app->get('/student/myproject/edit_project', $student(), function() use($app){

	$app->render('student/myproject/edit_project.php');

})->name('student.edit_project');

$app->post('/student/myproject/edit_project', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.edit_project.post');