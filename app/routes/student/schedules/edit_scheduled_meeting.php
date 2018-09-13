<?php

$app->get('/student/schedules/edit_scheduled_meeting', $student(), function() use($app){

	$app->render('student/schedules/edit_scheduled_meeting.php');

})->name('student.edit_scheduled_meeting');

$app->post('/student/schedules/edit_scheduled_meeting', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.edit_scheduled_meeting.post');