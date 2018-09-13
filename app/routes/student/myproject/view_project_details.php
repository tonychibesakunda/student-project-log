<?php

$app->get('/student/myproject/view_project_details', $student(), function() use($app){

	$app->render('student/myproject/view_project_details.php');

})->name('student.view_project_detail');

$app->post('/student/myproject/view_project_details', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_project_detail.post');