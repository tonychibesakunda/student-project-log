<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/dashboard', $student(), function() use($app){

	$user_id = $_SESSION[$app->config->get('auth.session')];

	$student_id = '';

	//get student id
	$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$student_id = $row->student_id;
	}

	// get supervisors
	$activeSupervisors = DB::table('users')
            ->select(
            	'users.id',
            	'users.first_name',
            	'users.other_names',
            	'users.last_name'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where([
            	'users_permissions.is_supervisor' => true,
            	'users.active' => true
            ])
            ->get();

    // number of completed projects
    $query = "SELECT COUNT(projects.project_id) AS numOfCompletedProjects FROM `students` INNER JOIN projects ON students.project_id=projects.project_id WHERE students.is_final_project_report_approved=1";
    $num_of_completed_projects = DB::select(DB::raw($query));

    // get dates
    $current_date = strtotime(date('Y-m-d'));
    $currentDate = date('Y-m-d');

   	$dayPerc = '';

    $get_dates = "SELECT project_start_date, project_end_date FROM students WHERE user_id=$user_id";
    $dates = DB::select(DB::raw($get_dates));

    foreach($dates as $d){
    	$start_date = strtotime($d->project_start_date);
    	$end_date = strtotime($d->project_end_date);
    }

    // remaining days percentage date percentage
    if($start_date > 0 || $end_date > 0){
    	$dayPerc = ((($current_date - $start_date) / ($end_date - $start_date)) * 100);
    }
    

    //echo "curernt date ".$current_date. "<br>". "start date ".$start_date."<br>"."end date ".$end_date."<br>"."percentage".$dayPerc;

    //project objectives
	$obj = "SELECT * FROM project_objectives WHERE student_id=$student_id ORDER BY po_id ASC";
	$project_objectives = DB::select(DB::raw($obj));

	//get supervision id
	$get_spid = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id";
	$sp_id = DB::select(DB::raw($get_spid));

	foreach ($sp_id as $sp) {
		$sp_id = $sp->supervision_id;
	}

	// get tasks
	$get_task = "SELECT tasks.task_id, tasks.task_description, tasks.is_approved, tasks.is_completed FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id ORDER BY tasks.task_id DESC LIMIT 5";
	$tasks = DB::select(DB::raw($get_task));

	//get project report file and project report file name
	$pr = "SELECT * FROM students WHERE user_id=$user_id";
	$project_report = DB::select(DB::raw($pr));

	//get scheduled dates
	$getDates = "SELECT * FROM scheduled_meetings WHERE supervision_id=$sp_id ORDER BY scheduled_meeting_id DESC LIMIT 5";
	$scheduled_meetings = DB::select(DB::raw($getDates));


	$app->render('/student/dashboard/dashboard.php',[
		'activeSupervisors' => $activeSupervisors,
		'num_of_completed_projects' => $num_of_completed_projects,
		'start_date' => $start_date,
		'end_date' => $end_date,
		'current_date' => $current_date,
		'currentDate' => $currentDate,
		'dayPerc' => $dayPerc,
		'dates' => $dates,
		'project_objectives' => $project_objectives,
		'tasks' => $tasks,
		'project_report' => $project_report,
		'scheduled_meetings' => $scheduled_meetings
	]);

})->name('student.dashboard');