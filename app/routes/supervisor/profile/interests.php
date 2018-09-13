<?php

$app->get('/supervisor/profile/interests', $supervisor(), function() use($app){

	$app->render('supervisor/profile/interests.php');

})->name('supervisor.interests');

$app->post('/supervisor/profile/interests', $supervisor(), function() use($app){
	echo 'Functionality not yet addded';
})->name('supervisor.interests.post');