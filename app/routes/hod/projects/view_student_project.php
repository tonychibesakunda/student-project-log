<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/hod/projects/view_student_project/:id', $hod(), function($supervisionID) use($app){

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

	// get student tasks
	$ts = "SELECT tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed FROM supervisory_meetings INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id WHERE scheduled_meetings.supervision_id=$supervisionID";
	$tasks = DB::select(DB::raw($ts));

	$app->render('hod/projects/view_student_project.php',[
		'project_details' => $project_details,
		'project_objectives' => $project_objectives,
		'tasks' => $tasks
	]);

})->name('hod.view_student_project');

$app->post('/hod/projects/view_student_project/:id', $hod(), function($supervisionID) use($app){

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
			return $app->response->redirect($app->urlFor('hod.view_student_project', array('id' => $supervisionID)));
		}
		
	}
	
})->name('hod.view_student_project.post');