<?php

use Logbook\User\ScheduledMeeting;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/schedules/edit_scheduled_meeting/:id', $student(), function($sm_id) use($app){

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

	//get scheduled meeting
	$query = "SELECT * FROM scheduled_meetings WHERE supervision_id=$sp_id AND scheduled_meeting_id=$sm_id";
	$scheduled_meeting = DB::select(DB::raw($query));

	//get assigned supervisors
	$query = "SELECT supervisions.*, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName FROM supervisions WHERE student_id=$student_id";
	$supervisors = DB::select(DB::raw($query));

	$app->render('student/schedules/edit_scheduled_meeting.php',[
		'scheduled_meeting' => $scheduled_meeting,
		'supervisors' => $supervisors
	]);

})->name('student.edit_scheduled_meeting');

$app->post('/student/schedules/edit_scheduled_meeting/:id', $student(), function($sm_id) use($app){
	
	//when the save button is clicked
	if(isset($_POST['save'])){

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

		//get scheduled meeting
		$query = "SELECT * FROM scheduled_meetings WHERE supervision_id=$sp_id AND scheduled_meeting_id=$sm_id";
		$scheduled_meeting = DB::select(DB::raw($query));

		//get assigned supervisors
		$query = "SELECT supervisions.*, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName FROM supervisions WHERE student_id=$student_id";
		$supervisors = DB::select(DB::raw($query));

		$request = $app->request;

		//get user input
		$scheduled_date = $request->post('scheduled_date');
		$select_supervisor = $request->post('selectSupervisor');

		//validate user input
		$v = $app->validation;

		$v->addRuleMessage('uniqueScheduledDate', 'This scheduled date has already been added.');

		$v->addRule('uniqueScheduledDate', function($value, $input, $args) use($app){

			$user_id = $_SESSION[$app->config->get('auth.session')];
			$student_id = '';

			//get student id
			$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
			$sid = DB::select(DB::raw($get_id));

			foreach ($sid as $row) {
				$student_id = $row->student_id;
			}

			$select_supervisor = $app->request->post('selectSupervisor');

			//get supervision
			$get_spid = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id AND supervisor_id=$select_supervisor";
			$sp_id = DB::select(DB::raw($get_spid));

			foreach ($sp_id as $sp) {
				$sp_id = $sp->supervision_id;
			}

		    $po = DB::table('scheduled_meetings')
				    	->select('scheduled_date')
				    	->where([
				    		'supervision_id' => $sp_id,
				    		'scheduled_date' => $value
				    	])
				    	->first();

			
		    return ! (bool) $po;
		});

		$v->validate([
			'scheduled_date' => [$scheduled_date, 'required|date|uniqueScheduledDate'],
			'selectSupervisor' => [$select_supervisor, 'int']
		]);

		if($v->passes()){

			//check if the project is completed
			$prc = "SELECT is_final_project_report_approved FROM students WHERE user_id=$user_id AND is_final_project_report_approved=1";
			$project_complete = DB::select(DB::raw($prc));

			if(count($project_complete) > 0){
				//flash message and redirect
				$app->flash('warning', 'This project has already been completed.');
				return $app->response->redirect($app->urlFor('student.edit_scheduled_meeting',array('id' => $sm_id)));
			}else{
				//get supervision id
				$get_spid = "SELECT supervision_id FROM supervisions WHERE student_id=$student_id AND supervisor_id=$select_supervisor";
				$sp_id = DB::select(DB::raw($get_spid));

				foreach ($sp_id as $sp) {
					$sp_id = $sp->supervision_id;
				}

				//get project start date and end date
				$getDates = "SELECT project_start_date, project_end_date FROM students WHERE student_id=$student_id AND user_id=$user_id";
				$dates = DB::select(DB::raw($getDates));

				foreach ($dates as $dt) {
					$project_start_date = $dt->project_start_date;
					$project_end_date = $dt->project_end_date;
				}

				$startdate = strtotime($project_start_date);
				$enddate = strtotime($project_end_date);
				$scheduledDate = strtotime($scheduled_date);
				$currentDate = strtotime(date('Y-m-d'));

				if($scheduledDate < $startdate || $scheduledDate > $enddate){
					//flash message and redirect
					$app->flash('error', 'Scheduled date has to be within the project start date and end date.');
					return $app->response->redirect($app->urlFor('student.edit_scheduled_meeting',array('id' => $sm_id)));
				}elseif($scheduledDate < $currentDate){
					//flash message and redirect
					$app->flash('error', 'Scheduled date cannot be set before the current date.');
					return $app->response->redirect($app->urlFor('student.edit_scheduled_meeting',array('id' => $sm_id)));
				}else{

					//update scheduled record in database
					ScheduledMeeting::where('scheduled_meeting_id', '=', $sm_id)
						->update([
							'scheduled_date' => $scheduled_date
						]);

					// Send email to supervisor
			        /*$app->mail->send('email/scheduled_meeting/edited_scheduled_meeting.php', ['student' => $student, 'supervisors' => $supervisors, 'scheduled_date' => $scheduled_date], function($message) use($supervisors){

			            $supervisor_email = '';
			            //get supervisor email
						foreach ($supervisors as $sup) {
								$supervisor_email = $sup->suEmail;
							}
			            $message->to($supervisor_email);
			            $message->subject('Scheduled Date Edited.');
			        });*/
					
					//flash message and redirect
					$app->flash('success', 'Scheduled date has been successfully updated.');
					return $app->response->redirect($app->urlFor('student.edit_scheduled_meeting',array('id' => $sm_id)));
				}
			}			
			
		}


		$app->render('student/schedules/edit_scheduled_meeting.php',[
			'errors' => $v->errors(),
			'request' => $request,
			'scheduled_meeting' => $scheduled_meeting,
			'supervisors' => $supervisors
		]);

	}

	// when the back button is clicked
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('student.view_scheduled_meetings'));
	}

})->name('student.edit_scheduled_meeting.post');