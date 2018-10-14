<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/schedules/add_scheduled_meeting', $student(), function() use($app){

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

	//get assigned supervisors
	$query = "SELECT supervisions.*, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName FROM supervisions WHERE student_id=$student_id";
	$supervisors = DB::select(DB::raw($query));

	$app->render('student/schedules/add_scheduled_meeting.php',[
		'supervisors' => $supervisors 
	]);

})->name('student.add_scheduled_meeting');

$app->post('/student/schedules/add_scheduled_meeting', $student(), function() use($app){

	//when the add objective button is clicked
	if(isset($_POST['add'])){

		$user_id = $_SESSION[$app->config->get('auth.session')];
		$student_id = '';
		
		$project_start_date = '';
		$project_end_date = '';

		//get student id
		$get_id =  "SELECT students.student_id, users.* FROM students INNER JOIN users ON students.user_id=users.id WHERE user_id=$user_id";
		$student = DB::select(DB::raw($get_id));

		foreach ($student as $row) {
			$student_id = $row->student_id;
		}

		//get assigned supervisors
		$query = "SELECT supervisions.*, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, (SELECT users.email FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suEmail FROM supervisions WHERE student_id=$student_id";
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
				return $app->response->redirect($app->urlFor('student.add_scheduled_meeting'));
			}elseif($scheduledDate < $currentDate){
				//flash message and redirect
				$app->flash('error', 'Scheduled date cannot be set before the current date.');
				return $app->response->redirect($app->urlFor('student.add_scheduled_meeting'));
			}else{
				//insert scheduled record in database
				DB::table('scheduled_meetings')
					->insert([
						'supervision_id' => $sp_id,
						'scheduled_date' => $scheduled_date
					]);

				// Send email to supervisor
		        $app->mail->send('email/scheduled_meeting/scheduled_meeting.php', ['student' => $student, 'supervisors' => $supervisors, 'scheduled_date' => $scheduled_date], function($message) use($supervisors){

		            $supervisor_email = '';
		            //get supervisor email
					foreach ($supervisors as $sup) {
							$supervisor_email = $sup->suEmail;
						}
		            $message->to($supervisor_email);
		            $message->subject('Scheduled Date Added.');
		        });
				
				//flash message and redirect
				$app->flash('success', 'Scheduled date has been successfully added.');
				return $app->response->redirect($app->urlFor('student.add_scheduled_meeting'));
			}	
			
		}

		$app->render('student/schedules/add_scheduled_meeting.php',[
			'errors' => $v->errors(),
			'request' => $request,
			'supervisors' => $supervisors
		]);

	}
})->name('student.add_scheduled_meeting.post');