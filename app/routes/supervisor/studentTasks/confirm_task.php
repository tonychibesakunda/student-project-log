<?php

use Logbook\User\Task;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/studentTasks/confirm_task/:id', $supervisor(), function($task_id) use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	// get student task details
	$query = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id WHERE tasks.task_id=$task_id";
	$tasks = DB::select(DB::raw($query));

	$app->render('supervisor/studentTasks/confirm_task.php',[
		'tasks' => $tasks
	]);

})->name('supervisor.confirm_task');

$app->post('/supervisor/studentTasks/confirm_task/:id', $supervisor(), function($task_id) use($app){

	// when the approve button is approved
	if(isset($_POST['approve_task'])){

		//supervisor details
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$supervisor_id = '';

		//get supervisor id
		$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$supervisor_id = $row->supervisor_id;
		}

		// get student task details
		$query = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id WHERE tasks.task_id=$task_id";
		$tasks = DB::select(DB::raw($query));

		foreach($tasks as $ts){
			$is_approved = $ts->is_approved;
		}

		if($is_approved == 1){
			// flash message and redirect
			$app->flash('error', 'Task has already been approved.');
			return $app->response->redirect($app->urlFor('supervisor.confirm_task',array('id' => $task_id)));
		}else{

			// update the task table
			Task::where('task_id', '=', $task_id)
					->update([
						'is_approved' => TRUE
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

			// flash message and redirect
			$app->flash('success', 'Task has been approved.');
			return $app->response->redirect($app->urlFor('supervisor.confirm_task',array('id' => $task_id)));

		}
		
		$app->render('supervisor/studentTasks/confirm_task.php',[
			'tasks' => $tasks
		]);

	}
	
})->name('supervisor.confirm_task.post');