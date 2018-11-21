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

	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisors.supervisor_id, users.* FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE user_id=$user_id";
	$supervisor = DB::select(DB::raw($get_id));

	foreach ($supervisor as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get student details
	$stu = "SELECT supervisions.*, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail FROM supervisions WHERE supervisor_id=$supervisor_id";
	$student = DB::select(DB::raw($stu));


	// get project objective
	$query = "SELECT * FROM project_objectives WHERE po_id=$poID";
	$project_objective = DB::select(DB::raw($query));

	// get student_id so that we can get the supervision_id id to be used for the back link
	// get student id
	foreach ($project_objective as $row) {
		$student_id = $row->student_id;
	}

	//get student details
	$stu = "SELECT supervisions.*, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail FROM supervisions WHERE supervisor_id=$supervisor_id AND student_id=$student_id";
	$student = DB::select(DB::raw($stu));

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

		// get updated project objective
		$query3 = "SELECT * FROM project_objectives WHERE po_id=$poID";
		$project_objective = DB::select(DB::raw($query));

		// send email to supervisor
		$app->mail->send('email/project_objectives/project_objective_comments.php', ['supervisor' => $supervisor, 'student' => $student, 'project_objective' => $project_objective], function($message) use($student){

            $student_email = '';
            //get student email
			foreach ($student as $stu) {
					$student_email = $stu->stuEmail;
				}
            $message->to($student_email);
            $message->subject('Project Objective Comments.');
        });

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