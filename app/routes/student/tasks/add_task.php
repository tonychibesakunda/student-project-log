<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/tasks/add_task', $student(), function() use($app){

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

	$app->render('student/tasks/add_task.php', [
		'supervisory_meetings' => $supervisory_meetings
	]);

})->name('student.add_task');

$app->post('/student/tasks/add_task', $student(), function() use($app){

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

	$request = $app->request;

	//get user input
	$task = $request->post('task');
	$supervisory_meeting = $request->post('selectMeeting');
	
	//validate user input
	$v = $app->validation;

	$v->validate([
		'task' => [$task, 'required|alnumDash|min(4)'],
		'selectMeeting' => [$supervisory_meeting, 'required|int']
	]);

	if($v->passes()){

		//check if the project is completed
		$prc = "SELECT is_final_project_report_approved FROM students WHERE user_id=$user_id AND is_final_project_report_approved=1";
		$project_complete = DB::select(DB::raw($prc));

		if(count($project_complete) > 0){
			//flash message and redirect
			$app->flash('warning', 'This project has already been completed.');
			return $app->response->redirect($app->urlFor('student.add_task'));
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
				return $app->response->redirect($app->urlFor('student.add_task'));
			}else{
				//check if the same task and supervisory meeting have been added already
				$query2 = "SELECT supervisory_meeting_id, task_description FROM tasks WHERE supervisory_meeting_id=$supervisory_meeting AND task_description='$task'";
				$check = DB::select(DB::raw($query2));

				if(count($check) > 0 ){
					//flash message and redirect
					$app->flash('error', 'This task has already been added to this supervisory meeting.');
					return $app->response->redirect($app->urlFor('student.add_task'));
				}elseif(count($check) == 0){

					// insert task in database
					DB::table('tasks')
						->insert([
							'supervisory_meeting_id' => $supervisory_meeting,
							'task_description' => $task,
							'sent_for_approval' => TRUE,
							'sent_for_completion' => FALSE,
							'is_approved' => FALSE,
							'is_completed' => FALSE
						]);

					// send email to supervisor
					// $app->mail->send('email/assigned/student.php', ['student' => $student, 'supervisor' => $supervisor], function($message) use($student){

			  //           $studentEmail = '';
			  //           foreach ($student as $row) {
			  //               $studentEmail = $row->email;
			  //           }
			  //           $message->to($studentEmail);
			  //           $message->subject('Supervisor Assigned.');
			  //       });

					//flash message and redirect
					$app->flash('success', 'Task has been successfully added to your log and has also been sent for approval.');
					return $app->response->redirect($app->urlFor('student.add_task'));			

				}
			}
		}

	}

	$app->render('student/tasks/add_task.php', [
		'errors' => $v->errors(),
		'request' => $request,
		'supervisory_meetings' => $supervisory_meetings
	]);

})->name('student.add_task.post');