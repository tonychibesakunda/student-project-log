<?php

use Logbook\User\Student;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/projects/project_report_comments/:id', $supervisor(), function($studentID) use($app){

	// get project objective
	$query = "SELECT * FROM students WHERE student_id=$studentID";
	$project_report = DB::select(DB::raw($query));

	// get student_id so that we can get the supervision_id id to be used for the back link
	// get student id
	foreach ($project_report as $row) {
		$student_id = $row->student_id;
	}

	$query2 = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id";
	$supervision_id = DB::select(DB::raw($query2));

	$app->render('supervisor/projects/project_report_comments.php',[
		'project_report' => $project_report,
		'supervision_id' => $supervision_id
	]);

})->name('supervisor.project_report_comments');

$app->post('/supervisor/projects/project_report_comments/:id', $supervisor(), function($studentID) use($app){

	// get project objective
	$query = "SELECT * FROM students WHERE student_id=$studentID";
	$project_report = DB::select(DB::raw($query));

	// get student_id so that we can get the supervision_id id to be used for the back link
	// get student id
	foreach ($project_report as $row) {
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
		Student::where('student_id', '=', $studentID)
					->update([
						'supervisor_comments' => $Comments
					]);

		//flash message and redirect
		$app->flash('success', 'Comments have been successfully added.');
		return $app->response->redirect($app->urlFor('supervisor.project_report_comments', array('id' => $studentID)));
		
	}

	$app->render('supervisor/projects/project_report_comments.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'project_report' => $project_report,
		'supervision_id' => $supervision_id
	]);
	
})->name('supervisor.project_report_comments.post');