<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/add_project_type', $coordinator(), function() use($app){
	$app->render('coordinator/projects/add_project_type.php');
})->name('coordinator.add_project_type');

$app->post('/coordinator/projects/add_project_type', $coordinator(), function() use($app){
	//store everything sent to this route
	$request = $app->request;

	//get user input
	$project_type = $request->post('project_type');

	//validate user input
	$v = $app->validation;

	$v->addRuleMessage('uniqueProjectType', 'This project type has already been added.');

	$v->addRule('uniqueProjectType', function($value, $input, $args) {

	    $pt = DB::table('project_types')
			    	->select('project_type')
			    	->where(['project_type' => $value])
			    	->first();

		
	    return ! (bool) $pt;
	});

	$v->validate([
		'project_type' => [$project_type, 'required|alnumDash|max(150)|uniqueProjectType'],
	]);

	if($v->passes()){

		//insert record into project category table
		DB::table('project_types')
			->insert([
				'project_type' => $project_type
			]);

		//flash message
		$app->flash('success', 'Project type has been successfully added.');
		return $app->response->redirect($app->urlFor('coordinator.add_project_type'));

		

	}
	//pass errors into view and save previous type info
	$app->render('coordinator/projects/add_project_type.php', [
		'errors' => $v->errors(),
		'request' => $request
	]);
})->name('coordinator.add_project_type.post');