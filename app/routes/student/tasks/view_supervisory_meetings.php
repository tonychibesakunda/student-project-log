<?php

$app->get('/student/tasks/view_supervisory_meetings', $student(), function() use($app){

	$app->render('student/tasks/view_supervisory_meetings.php');

})->name('student.view_supervisory_meetings');

$app->post('/student/tasks/view_supervisory_meetings', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_supervisory_meetings.post');