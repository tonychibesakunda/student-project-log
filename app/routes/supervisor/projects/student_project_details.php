<?php

use Logbook\User\ProjectObjective;
use Logbook\User\Student;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/projects/student_project_details/:id', $supervisor(), function($supervisionID) use($app){

	//get student project details
	$query = "SELECT (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, projects.project_name, projects.project_description, students.project_start_date, students.project_end_date, students.project_aims, students.student_id, project_categories.project_category, project_types.project_type, supervisions.supervision_id, students.final_project_report_file_path, students.final_project_report_file_name, students.final_project_report_new_file_name, students.is_final_project_report_approved, students.supervisor_comments FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id LEFT JOIN projects ON students.project_id=projects.project_id LEFT JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id LEFT JOIN project_types ON projects.project_type_id=project_types.project_type_id WHERE supervisions.supervision_id=$supervisionID";
	$project_details = DB::select(DB::raw($query));

	// get student id
	foreach ($project_details as $row) {
		$student_id = $row->student_id;
		$file_name = $row->final_project_report_file_name;
		$file_path = $row->final_project_report_file_path;
		$new_file_name = $row->final_project_report_new_file_name;
	}

	// get student project objectives
	$obj = "SELECT * FROM project_objectives WHERE student_id=$student_id";
	$project_objectives = DB::select(DB::raw($obj));

	$app->render('supervisor/projects/student_project_details.php',[
		'project_details' => $project_details,
		'project_objectives' => $project_objectives
	]);

})->name('supervisor.student_project_details');

$app->post('/supervisor/projects/student_project_details/:id', $supervisor(), function($supervisionID) use($app){

	//approve an objective
	if(isset($_POST['approve'])){

		$user_id = $_SESSION[$app->config->get('auth.session')];
		$supervisor_id = '';

		//get supervisor id
		$get_id =  "SELECT supervisors.supervisor_id, users.* FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE user_id=$user_id";
		$supervisor = DB::select(DB::raw($get_id));

		//get student project details
		$query = "SELECT (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, projects.project_name, projects.project_description, students.project_start_date, students.project_end_date, students.project_aims, students.student_id, project_categories.project_category, project_types.project_type, supervisions.supervision_id, students.final_project_report_file_path, students.final_project_report_file_name, students.final_project_report_new_file_name, students.is_final_project_report_approved, students.supervisor_comments FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id LEFT JOIN projects ON students.project_id=projects.project_id LEFT JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id LEFT JOIN project_types ON projects.project_type_id=project_types.project_type_id WHERE supervisions.supervision_id=$supervisionID";
		$project_details = DB::select(DB::raw($query));

		// get student id
		foreach ($project_details as $row) {
			$student_id = $row->student_id;
			$file_name = $row->final_project_report_file_name;
			$file_path = $row->final_project_report_file_path;
			$new_file_name = $row->final_project_report_new_file_name;
		}

		
		$pid = $_POST['approve'];

		// get student project objectives
		$obj = "SELECT * FROM project_objectives WHERE student_id=$student_id AND po_id=$pid";
		$project_objectives = DB::select(DB::raw($obj));

		// get project objective
		$pobj = "SELECT * FROM project_objectives WHERE po_id=$pid";
		$project_objective = DB::select(DB::raw($pobj));

		foreach($project_objectives as $po){
			$sent_for_approval = $po->sent_for_approval;
			$po_is_completed = $po->is_completed;
		}

		if($sent_for_approval == TRUE && $po_is_completed == FALSE){

			//update the project_objectives table
			ProjectObjective::where('po_id', '=', $pid)
								->update([
									'is_completed' => TRUE
								]);

			// send email to student
			$app->mail->send('email/project_objectives/approve_objective.php', ['supervisor' => $supervisor, 'student' => $project_details, 'project_objective' => $project_objective], function($message) use($project_details){

	            $student_email = '';
	            //get sstudent email
				foreach ($project_details as $stu) {
						$student_email = $stu->stuEmail;
					}
	            $message->to($student_email);
	            $message->subject('Project Objective Approved.');
	        });

			//flash message and redirect
			$app->flash('success', 'Project Objective has been approved.');
			return $app->response->redirect($app->urlFor('supervisor.student_project_details', array('id' => $supervisionID)));

		}elseif ($po_is_completed == TRUE) {
			//flash message and redirect
			$app->flash('error', 'This Project Objective has already been approved.');
			return $app->response->redirect($app->urlFor('supervisor.student_project_details', array('id' => $supervisionID)));
		}elseif($sent_for_approval == FALSE){
			//flash message and redirect
			$app->flash('error', 'Project Objectives that have not been sent for approval cannot be approved.');
			return $app->response->redirect($app->urlFor('supervisor.student_project_details', array('id' => $supervisionID)));
		}

		$app->render('supervisor/projects/student_project_details.php',[
			'project_details' => $project_details,
			'project_objectives' => $project_objectives
		]);

	}

	//when the download button is clicked
	if(isset($_POST['download'])){

		//get student project details
		$query = "SELECT (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, projects.project_name, projects.project_description, students.project_start_date, students.project_end_date, students.project_aims, students.student_id, project_categories.project_category, project_types.project_type, supervisions.supervision_id, students.final_project_report_file_path, students.final_project_report_file_name, students.final_project_report_new_file_name, students.is_final_project_report_approved, students.supervisor_comments FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id LEFT JOIN projects ON students.project_id=projects.project_id LEFT JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id LEFT JOIN project_types ON projects.project_type_id=project_types.project_type_id WHERE supervisions.supervision_id=$supervisionID";
		$project_details = DB::select(DB::raw($query));

		// get student id
		foreach ($project_details as $row) {
			$student_id = $row->student_id;
			$file_name = $row->final_project_report_file_name;
			$file_path = $row->final_project_report_file_path;
			$new_file_name = $row->final_project_report_new_file_name;
		}
		

		if(file_exists($file_path)){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: '.filesize($file_path));
			readfile($file_path);
			exit();



		}else{
			//flash message and redirect
			$app->flash('error', 'File does not exist.');
			return $app->response->redirect($app->urlFor('supervisor.student_project_details', array('id' => $supervisionID)));
		}
		
	}

	// approve project report
	if(isset($_POST['approve_report'])){

		$user_id = $_SESSION[$app->config->get('auth.session')];
		$supervisor_id = '';

		//get supervisor id
		$get_id =  "SELECT supervisors.supervisor_id, users.* FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE user_id=$user_id";
		$supervisor = DB::select(DB::raw($get_id));

		//get student project details
		$query = "SELECT (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, projects.project_name, projects.project_description, students.project_start_date, students.project_end_date, students.project_aims, students.student_id, project_categories.project_category, project_types.project_type, supervisions.supervision_id, students.final_project_report_file_path, students.final_project_report_file_name, students.final_project_report_new_file_name, students.is_final_project_report_approved, students.supervisor_comments FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id LEFT JOIN projects ON students.project_id=projects.project_id LEFT JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id LEFT JOIN project_types ON projects.project_type_id=project_types.project_type_id WHERE supervisions.supervision_id=$supervisionID";
		$project_details = DB::select(DB::raw($query));

		// get student id
		foreach ($project_details as $row) {
			$student_id = $row->student_id;
			$file_name = $row->final_project_report_file_name;
			$file_path = $row->final_project_report_file_path;
			$new_file_name = $row->final_project_report_new_file_name;
		}

		
		$pid = $_POST['approve_report'];

		// get student project report supervisor comments
		$com = "SELECT * FROM students WHERE student_id=$student_id";
		$project_report = DB::select(DB::raw($com));

		foreach($project_report as $pr){
			$report_approval = $pr->is_final_project_report_approved;
		}

		if($report_approval == NULL){

			//update the project_objectives table
			Student::where('student_id', '=', $student_id)
								->update([
									'is_final_project_report_approved' => TRUE
								]);

			// send email to student
			$app->mail->send('email/project_report/approve_project_report.php', ['supervisor' => $supervisor, 'student' => $project_details], function($message) use($project_details){

	            $student_email = '';
	            //get sstudent email
				foreach ($project_details as $stu) {
						$student_email = $stu->stuEmail;
					}
	            $message->to($student_email);
	            $message->subject('Project Report Approved.');
	        });

			//flash message and redirect
			$app->flash('success', 'Project Report has been approved.');
			return $app->response->redirect($app->urlFor('supervisor.student_project_details', array('id' => $supervisionID)));

		}elseif ($report_approval == TRUE) {
			//flash message and redirect
			$app->flash('error', 'This Project Report has already been approved.');
			return $app->response->redirect($app->urlFor('supervisor.student_project_details', array('id' => $supervisionID)));
		}

		$app->render('supervisor/projects/student_project_details.php',[
			'project_details' => $project_details,
			'project_report' => $project_report
		]);

	}
})->name('supervisor.student_project_details.post');