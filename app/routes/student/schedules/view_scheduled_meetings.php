<?php

use Logbook\User\ScheduledMeeting;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/schedules/view_scheduled_meetings', $student(), function() use($app){

	//current date
	$current_date = date('Y-m-d');

	//get student id
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$student_id = '';

	//get student id
	$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$student_id = $row->student_id;
	}

	//get supervision
	$get_spid = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id";
	$sp_id = DB::select(DB::raw($get_spid));

	foreach ($sp_id as $sp) {
		$sp_id = $sp->supervision_id;
	}

	//get scheduled dates
	$get_dates = "SELECT * FROM scheduled_meetings WHERE supervision_id=$sp_id";
	$scheduled_meetings = DB::select(DB::raw($get_dates));

	foreach ($scheduled_meetings as $sm) {
		$scheduled_date = $sm->scheduled_date;
	}

	$app->render('student/schedules/view_scheduled_meetings.php',[
		'scheduled_meetings' => $scheduled_meetings,
		'current_date' => $current_date
	]);

})->name('student.view_scheduled_meetings');

$app->post('/student/schedules/view_scheduled_meetings/:id', $student(), function($sm_id) use($app){
	
	// when the confirm delete (yes) button is clicked
	if(isset($_POST['delete'])){

		//check if date has been used in a task
		$query = "SELECT * FROM supervisory_meetings WHERE scheduled_meeting_id=$sm_id";
		$checkM = DB::select(DB::raw($query));

		if(count($checkM) > 0){
			//flash message
			$app->flash('error', "Scheduled Dates that have been used in tasks cannot be removed");
	    	return $app->response->redirect($app->urlFor('student.view_scheduled_meetings'));
		}elseif(count($checkM) == 0){
			//delete records
	    	ScheduledMeeting::where('scheduled_meeting_id', $sm_id)->delete();

	    	// Send email to supervisor
	        /*$app->mail->send('email/scheduled_meeting/scheduled_meeting.php', ['student' => $student, 'supervisors' => $supervisors, 'scheduled_date' => $scheduled_date], function($message) use($supervisors){

	            $supervisor_email = '';
	            //get supervisor email
				foreach ($supervisors as $sup) {
						$supervisor_email = $sup->suEmail;
					}
	            $message->to($supervisor_email);
	            $message->subject('Scheduled Date Added.');
	        });*/

	    	//flash message
			$app->flash('success', "Scheduled Date has been successfully removed");
	    	return $app->response->redirect($app->urlFor('student.view_scheduled_meetings'));
		}

		
	}
	
})->name('student.view_scheduled_meetings.post');