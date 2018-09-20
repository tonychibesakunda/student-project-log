<?php

use Logbook\User\ProjectCategory;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/view_project_category', $coordinator(), function() use($app){

	//get project categories from the database
	$project_categories = DB::table('project_categories')
								->select(
									'project_cat_id',
									'project_category'
								)->get();

	$app->render('coordinator/projects/view_project_category.php', [
		//share project category with the views
		'project_categories' => $project_categories
	]);

})->name('coordinator.view_project_category');

$app->post('/coordinator/projects/view_project_category/:id', $coordinator(), function($id) use($app){

	if(isset($_POST['delete'])){
		//delete project category record
		ProjectCategory::where('project_cat_id', $id)->delete();

		//flash message and redirect
        $app->flash('success', "Project Category record has been successfully deleted.");
        return $app->response->redirect($app->urlFor('coordinator.view_project_category'));
	}
	
})->name('coordinator.view_project_category.post');