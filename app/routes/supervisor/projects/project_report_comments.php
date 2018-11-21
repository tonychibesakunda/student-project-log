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

	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisors.supervisor_id, users.* FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE user_id=$user_id";
	$supervisor = DB::select(DB::raw($get_id));

	// get project objective
	$query = "SELECT * FROM students WHERE student_id=$studentID";
	$project_report = DB::select(DB::raw($query));

	// supervision id to be used in the back link
	$query2 = "SELECT supervision_id FROM supervisions WHERE student_id=$studentID";
	$supervision_id = DB::select(DB::raw($query2));

	//get student details
	$stu = "SELECT supervisions.*, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail FROM supervisions WHERE student_id=$studentID";
	$student = DB::select(DB::raw($stu));

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

		// get project objective
		$query3 = "SELECT * FROM students WHERE student_id=$studentID";
		$project_report = DB::select(DB::raw($query3));

		// send email to student
		$app->mail->send('email/project_report/project_report_comments.php', ['supervisor' => $supervisor, 'student' => $student, 'project_report' => $project_report], function($message) use($student){

            $student_email = '';
            //get sstudent email
			foreach ($student as $stu) {
					$student_email = $stu->stuEmail;
				}
            $message->to($student_email);
            $message->subject('Project Report Comments.');
        });

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