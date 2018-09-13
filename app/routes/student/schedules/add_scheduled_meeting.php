<?php

$app->get('/student/schedules/add_scheduled_meeting', $student(), function() use($app){

	$app->render('student/schedules/add_scheduled_meeting.php');

})->name('student.add_scheduled_meeting');

$app->post('/student/schedules/add_scheduled_meeting', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.add_scheduled_meeting.post');