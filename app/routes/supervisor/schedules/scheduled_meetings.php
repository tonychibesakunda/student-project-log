<?php

$app->get('/supervisor/schedules/scheduled_meetings', $supervisor(), function() use($app){

	$app->render('supervisor/schedules/scheduled_meetings.php');

})->name('supervisor.scheduled_meetings');

$app->post('/supervisor/schedules/scheduled_meetings', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.scheduled_meetings.post');