<?php

use Logbook\User\Task;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/studentTasks/approve_task_completion/:id', $supervisor(), function($task_id) use($app){

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
	$query = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.file_path, tasks.file_name, tasks.new_file_name, tasks.student_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id WHERE tasks.task_id=$task_id";
	$tasks = DB::select(DB::raw($query));

	$app->render('supervisor/studentTasks/approve_task_completion.php',[
		'tasks' => $tasks
	]);

})->name('supervisor.approve_task_completion');

$app->post('/supervisor/studentTasks/approve_task_completion/:id', $supervisor(), function($task_id) use($app){

	if(isset($_POST['approve_task'])){

		//supervisor details
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$supervisor_id = '';

		//get supervisor id
		$get_id =  "SELECT supervisors.supervisor_id, users.* FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$supervisor_id = $row->supervisor_id;
		}

		// get student task details
		$query = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.file_path, tasks.file_name, tasks.new_file_name, tasks.student_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id WHERE tasks.task_id=$task_id";
		$tasks = DB::select(DB::raw($query));

		foreach($tasks as $ts){
			$sent_for_completion = $ts->sent_for_completion;
			$is_completed = $ts->is_completed;
		}

		// check if task has been sent for completion
		if($sent_for_completion == 0 || is_null($sent_for_completion)){
			//flash message and redirect
			$app->flash('error', 'You can only approve tasks that have been sent for completion');
			return $app->response->redirect($app->urlFor('supervisor.approve_task_completion',array('id' => $task_id)));
		}elseif($sent_for_completion == 1){
			//check if task is approved for completion
			if($is_completed == 1){
				//flash message and redirect
				$app->flash('error', 'This task has already been approved for completion');
				return $app->response->redirect($app->urlFor('supervisor.approve_task_completion',array('id' => $task_id)));
			}elseif($is_completed == 0){
				// update the task table
				Task::where('task_id', '=', $task_id)
						->update([
							'is_completed' => TRUE
						]);

				// send email to student
				$app->mail->send('email/tasks/approve_task_completion.php', ['supervisor' => $sid, 'student' => $tasks], function($message) use($tasks){

		            $student_email = '';
		            //get sstudent email
					foreach ($tasks as $stu) {
							$student_email = $stu->stuEmail;
						}
		            $message->to($student_email);
		            $message->subject('Project Task Approved for Completion.');
		        });

				// flash message and redirect
				$app->flash('success', 'Task has been approved for completion.');
				return $app->response->redirect($app->urlFor('supervisor.approve_task_completion',array('id' => $task_id)));
			}
		}

		$app->render('supervisor/studentTasks/approve_task_completion.php',[
			'tasks' => $tasks
		]);

	}

})->name('supervisor.approve_task_completion.post');