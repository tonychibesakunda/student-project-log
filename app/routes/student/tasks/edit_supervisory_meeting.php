<?php

use Logbook\User\SupervisoryMeeting;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/tasks/edit_supervisory_meeting/:id', $student(), function($sm_id) use($app){

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

	//get scheduled meeting
	$query = "SELECT * FROM scheduled_meetings WHERE supervision_id=$sp_id";
	$scheduled_meetings = DB::select(DB::raw($query));

	// populate edit supervisory meeting page
	$query = "SELECT supervisory_meeting_id, scheduled_meeting_id, duration FROM supervisory_meetings WHERE supervisory_meeting_id=$sm_id";
	$supervisory_meetings = DB::select(DB::raw($query));

	$app->render('student/tasks/edit_supervisory_meeting.php', [
		'supervisory_meetings' => $supervisory_meetings,
		'scheduled_meetings' => $scheduled_meetings
	]);

})->name('student.edit_supervisory_meeting');

$app->post('/student/tasks/edit_supervisory_meeting/:id', $student(), function($sm_id) use($app){

	if(isset($_POST['save'])){
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

		//get scheduled meeting
		$query = "SELECT * FROM scheduled_meetings WHERE supervision_id=$sp_id";
		$scheduled_meetings = DB::select(DB::raw($query));

		// populate edit supervisory meeting page
		$query = "SELECT supervisory_meeting_id, scheduled_meeting_id, duration FROM supervisory_meetings WHERE supervisory_meeting_id=$sm_id";
		$supervisory_meetings = DB::select(DB::raw($query));

		$request = $app->request;

		//get user input
		$scheduled_meeting = $request->post('scheduledMeeting');
		$duration = $request->post('duration');

		//validate user input
		$v = $app->validation;

		$v->addRuleMessage('uniqueDuration', 'Duration for this scheduled meeting has already been added.');

		$v->addRule('uniqueDuration', function($value, $input, $args) use($app){

			$duration = $app->request->post('duration');

		    // $po = DB::table('supervisory_meetings')
					 //    	->select('scheduled_meeting_id')
					 //    	->where([
					 //    		'scheduled_meeting_id' => $value
					 //    	])
					 //    	->first();

			$query = "SELECT scheduled_meeting_id, duration FROM supervisory_meetings WHERE scheduled_meeting_id=$value AND duration='$duration'";
			$po = DB::select(DB::raw($query));

			
		    return ! (bool) $po;
		});

		$v->validate([
			'scheduledMeeting' => [$scheduled_meeting, 'required|int|uniqueDuration'],
			'duration' => [$duration, 'required']
		]);

		if($v->passes()){

			//get scheduled meeting
			$query2 = "SELECT * FROM scheduled_meetings WHERE scheduled_meeting_id=$scheduled_meeting";
			$scheduledMeeting = DB::select(DB::raw($query2));

			foreach ($scheduledMeeting as $sm) {
				$scheduled_date = $sm->scheduled_date; // get scheduled date
			}

			//get current date
			$currentDate = strtotime(date('Y-m-d'));

			//scheduled date
			$scheduledDate = strtotime($scheduled_date);

			//check if the project is completed
			$prc = "SELECT is_final_project_report_approved FROM students WHERE user_id=$user_id AND is_final_project_report_approved=1";
			$project_complete = DB::select(DB::raw($prc));

			if(count($project_complete) > 0){
				//flash message and redirect
				$app->flash('warning', 'This project has already been completed.');
				return $app->response->redirect($app->urlFor('student.edit_supervisory_meeting', array('id' => $sm_id)));
			}else{
				if($scheduledDate > $currentDate){
					//flash message and redirect
					$app->flash('error', 'Duration cannot be added before the supervisory meeting date.');
					return $app->response->redirect($app->urlFor('student.edit_supervisory_meeting', array('id' => $sm_id)));
				}elseif($scheduledDate <= $currentDate){

					//update scheduled record in database
					SupervisoryMeeting::where('supervisory_meeting_id', '=', $sm_id)
									->update([
										'scheduled_meeting_id' => $scheduled_meeting,
										'duration' => $duration
									]);

					//flash message and redirect
					$app->flash('success', 'Supervisory meeting has been successfully updated.');
					return $app->response->redirect($app->urlFor('student.edit_supervisory_meeting', array('id' => $sm_id)));
				}
			}

			

		}

		$app->render('student/tasks/edit_supervisory_meeting.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'supervisory_meetings' => $supervisory_meetings,
			'scheduled_meetings' => $scheduled_meetings
		]);
	}

	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('student.view_supervisory_meetings'));
	}

	

	
})->name('student.edit_supervisory_meeting.post');