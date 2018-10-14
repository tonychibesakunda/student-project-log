<?php

use Logbook\User\SupervisoryMeeting;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/tasks/view_supervisory_meetings', $student(), function() use($app){

	//student details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$student_id = '';
	$sp_id = '';

	//get student id
	$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$student_id = $row->student_id;
	}

	//get supervision id
	$get_spid = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id";
	$sp_id = DB::select(DB::raw($get_spid));

	foreach ($sp_id as $sp) {
		$sp_id = $sp->supervision_id;
	}

	// get supervisory meetings
	$query = "SELECT supervisory_meetings.supervisory_meeting_id, supervisory_meetings.duration, scheduled_meetings.scheduled_date FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id";
	$supervisory_meetings = DB::select(DB::raw($query));

	$app->render('student/tasks/view_supervisory_meetings.php', [
		'supervisory_meetings' => $supervisory_meetings
	]);

})->name('student.view_supervisory_meetings');

$app->post('/student/tasks/view_supervisory_meetings/:id', $student(), function($id) use($app){
	
	if(isset($_POST['delete'])){

		//check if supervisory meeting has been used in a task
		$query = "SELECT * FROM tasks WHERE supervisory_meeting_id=$id";
		$checkSM = DB::select(DB::raw($query));

		if(count($checkSM) > 0){
			//flash message
			$app->flash('error', "Supervisory Meetings that have been used in tasks cannot removed");
	    	return $app->response->redirect($app->urlFor('student.view_supervisory_meetings'));
		}else{
			//delete records
	    	SupervisoryMeeting::where('supervisory_meeting_id', $id)->delete();

	    	//flash message
			$app->flash('success', "Supervisory Meeting has been successfully removed");
	    	return $app->response->redirect($app->urlFor('student.view_supervisory_meetings'));
		}
		
	}

})->name('student.view_supervisory_meetings.post');