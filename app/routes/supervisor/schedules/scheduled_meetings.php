<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/schedules/scheduled_meetings', $supervisor(), function() use($app){

	//current date
	$current_date = date('Y-m-d');

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get supervision dates
	$query = "SELECT scheduled_meetings.scheduled_date, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) as stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) as stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) as stLName FROM `scheduled_meetings` INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id INNER JOIN students ON supervisions.student_id=students.student_id WHERE supervisions.supervisor_id=$supervisor_id AND students.is_final_project_report_approved IS NULL";
	$supervisions = DB::select(DB::raw($query));

	$app->render('supervisor/schedules/scheduled_meetings.php',[
		'supervisions' => $supervisions,
		'current_date' => $current_date
	]);

})->name('supervisor.scheduled_meetings');

$app->post('/supervisor/schedules/scheduled_meetings', $supervisor(), function() use($app){
	
})->name('supervisor.scheduled_meetings.post');