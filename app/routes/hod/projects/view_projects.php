<?php

$app->get('/hod/projects/view_projects', $hod(), function() use($app){

	$app->render('hod/projects/view_projects.php');

})->name('hod.view_projects');

$app->post('/hod/projects/view_projects', $hod(), function() use($app){
	echo 'Functionality not yet addded';
})->name('hod.view_projects.post');