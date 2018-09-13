<?php

$app->get('/student/tasks/add_supervisory_meeting', $student(), function() use($app){

	$app->render('student/tasks/add_supervisory_meeting.php');

})->name('student.add_supervisory_meeting');

$app->post('/student/tasks/add_supervisory_meeting', $student(), function() use($app){
	echo 'Functionality not yet addded';
})->name('student.add_supervisory_meeting.post');