<?php

use Logbook\User\ProjectType;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/edit_project_type/:id', $coordinator(), function($projectTypeId) use($app){

	//get project type id
	$projectType = DB::table('project_types')
						->select(
							'project_type_id',
							'project_type'
						)
						->where(['project_type_id' => $projectTypeId])
						->first();

	//if record doesn't exist show a 404 page not found
	if(!$projectType){
		$app->notFound();
	}
	$app->render('coordinator/projects/edit_project_type.php',[
		'projectType' => $projectType
	]);

})->name('coordinator.edit_project_type');

$app->post('/coordinator/projects/edit_project_type/:id', $coordinator(), function($projectTypeId) use($app){

	//when the save button is clicked
	if(isset($_POST['save'])){


		//get project type id
		$projectType = DB::table('project_types')
							->select(
								'project_type_id',
								'project_type'
							)
							->where(['project_type_id' => $projectTypeId])
							->first();


		//store everything sent to this route
		$request = $app->request;

		//get user input
		$project_type = $request->post('project_type');
		$project_tp = $request->post('project_tp');

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

			$get_id = "SELECT project_type_id FROM project_types WHERE project_type = '".$project_tp."'";
			$project_TpId = DB::select(DB::raw($get_id)); //runs the sql query above
			
			$projectTypeId;
			foreach ($project_TpId as $row) {
				$projectTypeId = $row->project_type_id;
			}

			//update the projecttypes table using it's model
			ProjectType::where('project_type_id', '=', $projectTypeId)
						->update([
							'project_type' => $project_type
						]);

			//flash message
			$app->flash('success', 'Project Type has been successfully updated.');
			return $app->response->redirect($app->urlFor('coordinator.edit_project_type', array('id' => $projectTypeId)));

			

		}
		//pass errors into view and save previous type info
		$app->render('coordinator/projects/edit_project_type.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'projectType' => $projectType
		]);

	}

	//when the back button is clicked
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('coordinator.view_project_type'));
	}
	
})->name('coordinator.edit_project_type.post');