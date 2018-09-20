<?php

use Logbook\User\ProjectCategory;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/edit_project_category/:id', $coordinator(), function($projectCatId) use($app){

	//get project category id
	$projectCat = DB::table('project_categories')
						->select(
							'project_cat_id',
							'project_category'
						)
						->where(['project_cat_id' => $projectCatId])
						->first();

	//if record doesn't exist show a 404 page not found
	if(!$projectCat){
		$app->notFound();
	}

	$app->render('coordinator/projects/edit_project_category.php', [
		'projectCat' => $projectCat
	]);

})->name('coordinator.edit_project_category');

$app->post('/coordinator/projects/edit_project_category/:id', $coordinator(), function($projectCatId) use($app){
	
	//when the save button is clicked
	if(isset($_POST['save'])){


		//get project category id
		$projectCat = DB::table('project_categories')
							->select(
								'project_cat_id',
								'project_category'
							)
							->where(['project_cat_id' => $projectCatId])
							->first();

		//store everything sent to this route
		$request = $app->request;

		//get user input
		$project_category = $request->post('project_category');
		$project_cat = $request->post('project_cat');

		//validate user input
		$v = $app->validation;

		$v->addRuleMessage('uniqueProjectCategory', 'This project category has already been added.');

		$v->addRule('uniqueProjectCategory', function($value, $input, $args) {

		    $pc = DB::table('project_categories')
				    	->select('project_category')
				    	->where(['project_category' => $value])
				    	->first();

			
		    return ! (bool) $pc;
		});

		$v->validate([
			'project_category' => [$project_category, 'required|alnumDash|max(150)|uniqueProjectCategory'],
		]);

		if($v->passes()){

			$get_id = "SELECT project_cat_id FROM project_categories WHERE project_category = '".$project_cat."'";
			$project_CatId = DB::select(DB::raw($get_id)); //runs the sql query above
			
			$projectCatId;
			foreach ($project_CatId as $row) {
				$projectCatId = $row->project_cat_id;
			}

			//update the projectcategories table using it's model
			ProjectCategory::where('project_cat_id', '=', $projectCatId)
						->update([
							'project_category' => $project_category
						]);

			//flash message
			$app->flash('success', 'Project Category has been successfully updated.');
			return $app->response->redirect($app->urlFor('coordinator.edit_project_category', array('id' => $projectCatId)));

			

		}
		//pass errors into view and save previous type info
		$app->render('coordinator/projects/edit_project_category.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'projectCat' => $projectCat
		]);

	}

	//when the back button is clicked
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('coordinator.view_project_category'));
	}

})->name('coordinator.edit_project_category.post');