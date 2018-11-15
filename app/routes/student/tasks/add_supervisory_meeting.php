<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/tasks/add_supervisory_meeting', $student(), function() use($app){

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

	$app->render('student/tasks/add_supervisory_meeting.php',[
		'scheduled_meetings' => $scheduled_meetings
	]);

})->name('student.add_supervisory_meeting');

$app->post('/student/tasks/add_supervisory_meeting', $student(), function() use($app){

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

	foreach ($scheduled_meetings as $sm) {
		$scheduled_date = $sm->scheduled_date; // get scheduled date
	}

	$request = $app->request;

	//get user input
	$scheduled_meeting = $request->post('scheduledMeeting');
	$duration = $request->post('duration');

	//validate user input
	$v = $app->validation;

	$v->addRuleMessage('uniqueDuration', 'Duration for this scheduled meeting has already been added.');

	$v->addRule('uniqueDuration', function($value, $input, $args) use($app){

	    $po = DB::table('supervisory_meetings')
				    	->select('scheduled_meeting_id')
				    	->where([
				    		'scheduled_meeting_id' => $value
				    	])
				    	->first();

		
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
			return $app->response->redirect($app->urlFor('student.add_supervisory_meeting'));
		}else{
			// check if project has been added to the system
			$pr = "SELECT project_id FROM `students` WHERE user_id=$user_id";
			$pro = DB::select(DB::raw($pr));

			foreach($pro as $p){
				$pro_id = $p->project_id;
			}

			if(is_null($pro_id)){
				//flash message and redirect
				$app->flash('error', 'You must add your project to the system before performing this function');
				return $app->response->redirect($app->urlFor('student.add_supervisory_meeting'));
			}else{
				if($scheduledDate > $currentDate){
					//flash message and redirect
					$app->flash('error', 'Duration cannot be added before the supervisory meeting date.');
					return $app->response->redirect($app->urlFor('student.add_supervisory_meeting'));
				}elseif($scheduledDate <= $currentDate){

					//insert supervisory record in database
					DB::table('supervisory_meetings')
						->insert([
							'scheduled_meeting_id' => $scheduled_meeting,
							'duration' => $duration
						]);

					//flash message and redirect
					$app->flash('success', 'Supervisory meeting has been successfully added.');
					return $app->response->redirect($app->urlFor('student.add_supervisory_meeting'));
				}
			}
		}

	}
	
	$app->render('student/tasks/add_supervisory_meeting.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'scheduled_meetings' => $scheduled_meetings
	]);

})->name('student.add_supervisory_meeting.post');