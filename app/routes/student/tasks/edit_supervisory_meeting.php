<?php

$app->get('/student/tasks/edit_supervisory_meeting', $student(), function() use($app){

	$app->render('student/tasks/edit_supervisory_meeting.php');

})->name('student.edit_supervisory_meeting');

$app->post('/student/tasks/edit_supervisory_meeting', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.edit_supervisory_meeting.post');