<?php

use Logbook\User\Task;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/tasks/edit_task/:id', $student(), function($task_id) use($app){

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

	// get tasks
	$get_task = "SELECT tasks.task_id, scheduled_meetings.supervision_id, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.supervisor_approval_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id AND tasks.task_id=$task_id";
	$tasks = DB::select(DB::raw($get_task));

	// get supervisory meetings
	$query = "SELECT supervisory_meetings.supervisory_meeting_id, supervisory_meetings.duration, scheduled_meetings.scheduled_date FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id";
	$supervisory_meetings = DB::select(DB::raw($query));

	$app->render('student/tasks/edit_task.php', [
		'tasks' => $tasks,
		'supervisory_meetings' => $supervisory_meetings
	]);

})->name('student.edit_task');

$app->post('/student/tasks/edit_task/:id', $student(), function($task_id) use($app){
	
	//when the save changes button is clicked
	if(isset($_POST['save'])){

		//student details
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$student_id = '';
		$sp_id = '';
		$is_approved = '';
		$is_completed = '';

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

		// get tasks
		$get_task = "SELECT tasks.task_id, scheduled_meetings.supervision_id, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.supervisor_approval_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id AND tasks.task_id=$task_id";
		$tasks = DB::select(DB::raw($get_task));

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

			//check if the same task and supervisory meeting have been added already
			$query2 = "SELECT supervisory_meeting_id, task_description FROM tasks WHERE supervisory_meeting_id=$supervisory_meeting AND task_description='$task'";
			$check = DB::select(DB::raw($query2));

			if(count($check) > 0 ){
				//flash message and redirect
				$app->flash('error', 'This task has already been added to this supervisory meeting.');
				return $app->response->redirect($app->urlFor('student.edit_task',array('id' => $task_id)));
			}elseif(count($check) == 0){

				//check if task has been approved
				$query3 = "SELECT is_approved, is_completed FROM tasks WHERE task_id=$task_id";
				$checkApproval = DB::select(DB::raw($query3));

				foreach($checkApproval as $ca){
					$is_approved = $ca->is_approved;
					$is_completed = $ca->is_completed;
				}

				if($is_approved == 1 || $is_completed == 1){
					//flash message and redirect
					$app->flash('error', 'Tasks that have been completed or approved cannot be edited');
					return $app->response->redirect($app->urlFor('student.edit_task',array('id' => $task_id)));
				}else{
					//update the tasks table
					Task::where('task_id', '=', $task_id)
							->update([
								'supervisory_meeting_id' => $supervisory_meeting,
								'task_description' => $task
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
					$app->flash('success', 'Task has been successfully updated to your log and has also been sent for approval.');
					return $app->response->redirect($app->urlFor('student.edit_task',array('id' => $task_id)));
				}

			}

		}

		$app->render('student/tasks/edit_task.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'tasks' => $tasks,
			'supervisory_meetings' => $supervisory_meetings
		]);

	}

	//when the back button is clicked
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('student.view_tasks'));
	}
})->name('student.edit_task.post');