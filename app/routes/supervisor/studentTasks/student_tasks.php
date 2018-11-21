<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/studentTasks/student_tasks', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	// get student task details
	$query = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id INNER JOIN students ON supervisions.student_id=students.student_id WHERE supervisions.supervisor_id=$supervisor_id AND students.is_final_project_report_approved IS NULL";
	$tasks = DB::select(DB::raw($query));

	$app->render('supervisor/studentTasks/student_tasks.php',[
		'tasks' => $tasks
	]);

})->name('supervisor.student_tasks');

$app->post('/supervisor/studentTasks/student_tasks', $supervisor(), function() use($app){
	
})->name('supervisor.student_tasks.post');