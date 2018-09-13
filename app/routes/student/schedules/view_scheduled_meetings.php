<?php

$app->get('/student/schedules/view_scheduled_meetings', $student(), function() use($app){

	$app->render('student/schedules/view_scheduled_meetings.php');

})->name('student.view_scheduled_meetings');

$app->post('/student/schedules/view_scheduled_meetings', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.view_scheduled_meetings.post');