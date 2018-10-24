<?php

use Logbook\User\ProjectObjective;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/projects/project_objective_comments/:id', $supervisor(), function($poID) use($app){

	// get project objective
	$query = "SELECT * FROM project_objectives WHERE po_id=$poID";
	$project_objective = DB::select(DB::raw($query));

	// get student_id so that we can get the supervision_id id to be used for the back link
	// get student id
	foreach ($project_objective as $row) {
		$student_id = $row->student_id;
	}

	$query2 = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id";
	$supervision_id = DB::select(DB::raw($query2));

	$app->render('supervisor/projects/project_objective_comments.php',[
		'project_objective' => $project_objective,
		'supervision_id' => $supervision_id
	]);

})->name('supervisor.project_objective_comments');

$app->post('/supervisor/projects/project_objective_comments/:id', $supervisor(), function($poID) use($app){

	// get project objective
	$query = "SELECT * FROM project_objectives WHERE po_id=$poID";
	$project_objective = DB::select(DB::raw($query));

	// get student_id so that we can get the supervision_id id to be used for the back link
	// get student id
	foreach ($project_objective as $row) {
		$student_id = $row->student_id;
	}

	$query2 = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id";
	$supervision_id = DB::select(DB::raw($query2));

	$request = $app->request;

	//get user input
	$Comments = $request->post('comments');

	//validate user input
	$v = $app->validation;

	$v->validate([
		'comments' => [$Comments, 'required|min(4)']
	]);

	if($v->passes()){

		// update project_objectives table
		ProjectObjective::where('po_id', '=', $poID)
					->update([
						'supervisor_comments' => $Comments
					]);

		//flash message and redirect
		$app->flash('success', 'Comments have been successfully added.');
		return $app->response->redirect($app->urlFor('supervisor.project_objective_comments', array('id' => $poID)));
		
	}

	$app->render('supervisor/projects/project_objective_comments.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'project_objective' => $project_objective,
		'supervision_id' => $supervision_id
	]);
	
})->name('supervisor.project_objective_comments.post');