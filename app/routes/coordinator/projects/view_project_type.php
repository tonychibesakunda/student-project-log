<?php

use Logbook\User\ProjectType;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/view_project_type', $coordinator(), function() use($app){

	//get project types from the database
	$project_types = DB::table('project_types')
								->select(
									'project_type_id',
									'project_type'
								)->get();

	$app->render('coordinator/projects/view_project_type.php', [
		'project_types' => $project_types
	]);

})->name('coordinator.view_project_type');

$app->post('/coordinator/projects/view_project_type/:id', $coordinator(), function($id) use($app){
	
	if(isset($_POST['delete'])){
		//delete project category record
		ProjectType::where('project_type_id', $id)->delete();

		//flash message and redirect
        $app->flash('success', "Project Type record has been successfully deleted.");
        return $app->response->redirect($app->urlFor('coordinator.view_project_type'));
	}

})->name('coordinator.view_project_type.post');