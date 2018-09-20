<?php

use Logbook\User\ProjectCategory;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/add_project_category', $coordinator(), function() use($app){
	$app->render('coordinator/projects/add_project_category.php');
})->name('coordinator.add_project_category');

$app->post('/coordinator/projects/add_project_category', $coordinator(), function() use($app){

	//store everything sent to this route
	$request = $app->request;

	//get user input
	$project_category = $request->post('project_category');

	//validate user input
	$v = $app->validation;

	$v->addRuleMessage('uniqueProjectCategory', 'This project category has already been added.');

	$v->addRule('uniqueProjectCategory', function($value, $input, $args) {

		//$query = "SELECT project_category FROM project_categories WHERE project_category='$value'";
		/*$p_c = DB::select(DB::raw($query));

		foreach ($p_c as $pc) {
			return ! (bool) $pc->project_category->count();
				
			}*/
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

		//insert record into project category table
		DB::table('project_categories')
			->insert([
				'project_category' => $project_category
			]);

		//flash message
		$app->flash('success', 'Project Category has been successfully added.');
		return $app->response->redirect($app->urlFor('coordinator.add_project_category'));

		

	}
	//pass errors into view and save previous type info
	$app->render('coordinator/projects/add_project_category.php', [
		'errors' => $v->errors(),
		'request' => $request
	]);

})->name('coordinator.add_project_category.post');