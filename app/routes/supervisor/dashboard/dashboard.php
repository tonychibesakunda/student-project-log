<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/dashboard', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//current date
	$current_date = date('Y-m-d');

	//get student projects
	$query = "SELECT supervisions.supervision_id, students.is_final_project_report_approved ,users.first_name,users.last_name,users.other_names,projects.project_name FROM supervisions INNER JOIN students ON supervisions.student_id =students.student_id INNER JOIN  users ON students.user_id=users.id LEFT JOIN projects ON students.project_id=projects.project_id WHERE supervisions.supervisor_id=$supervisor_id AND students.is_final_project_report_approved IS NULL";
	$student_projects = DB::select(DB::raw($query));

	//get supervision dates
	$query2 = "SELECT scheduled_meetings.scheduled_date, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) as stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) as stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) as stLName FROM `scheduled_meetings` INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id INNER JOIN students ON supervisions.student_id=students.student_id WHERE supervisions.supervisor_id=$supervisor_id AND students.is_final_project_report_approved IS NULL ORDER BY scheduled_meetings.scheduled_meeting_id DESC";
	$supervisions = DB::select(DB::raw($query2));

	// get student task details
	$query3 = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id INNER JOIN students ON supervisions.student_id=students.student_id WHERE supervisions.supervisor_id=$supervisor_id AND students.is_final_project_report_approved IS NULL ORDER BY tasks.task_id DESC LIMIT 5";
	$tasks = DB::select(DB::raw($query3));

	$app->render('/supervisor/dashboard/dashboard.php',[
		'student_projects' => $student_projects,
		'supervisions' => $supervisions,
		'tasks' => $tasks,
		'current_date' => $current_date
	]);

})->name('supervisor.dashboard'); 