<?php

use Logbook\User\Task;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/studentTasks/review_task/:id', $supervisor(), function($task_id) use($app){

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
	$query = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.supervisor_approval_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id WHERE tasks.task_id=$task_id";
	$tasks = DB::select(DB::raw($query));

	$app->render('supervisor/studentTasks/review_task.php', [
		'tasks' => $tasks
	]);

})->name('supervisor.review_task');

$app->post('/supervisor/studentTasks/review_task/:id', $supervisor(), function($task_id) use($app){

	// when the send review is clicked
	if(isset($_POST['send_review'])){
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
		$query = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.supervisor_approval_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id WHERE tasks.task_id=$task_id";
		$tasks = DB::select(DB::raw($query));

		$request = $app->request;

		//get user input
		$supervisorComments = $request->post('supervisor_comments');

		//validate user input
		$v = $app->validation;

		$v->validate([
			'supervisor_comments' => [$supervisorComments, 'required|min(4)']
		]);

		if($v->passes()){

			//check if comments already exist in database
			$query2 = "SELECT supervisor_approval_comments FROM tasks WHERE task_id=$task_id AND supervisor_approval_comments='$supervisorComments'";
			$check = DB::select(DB::raw($query2));

			if(count($check) > 0){
				//flash message and redirect
				$app->flash('error', 'These comments have already been sent.');
				return $app->response->redirect($app->urlFor('supervisor.review_task',array('id' => $task_id)));
			}elseif(count($check) == 0){

				//check if task is approved
				$query3 = "SELECT is_approved FROM tasks WHERE task_id=$task_id";
				$checkApproval = DB::select(DB::raw($query3));

				foreach($checkApproval as $ca){
					$is_approved = $ca->is_approved;
				}

				if($is_approved == 1){
					//flash message and redirect
					$app->flash('error', 'This task has already been approved.');
					return $app->response->redirect($app->urlFor('supervisor.review_task',array('id' => $task_id)));
				}else{
					//update tasks table
					Task::where('task_id', '=', $task_id)
							->update([
								'supervisor_approval_comments' => $supervisorComments
							]);

					// get updated student task details
					$query4 = "SELECT tasks.task_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT users.email FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stuEmail, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS project_name, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.supervisor_approval_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id INNER JOIN supervisions ON scheduled_meetings.supervision_id=supervisions.supervision_id WHERE tasks.task_id=$task_id";
					$tasks = DB::select(DB::raw($query4));

					// send email to student
					$app->mail->send('email/tasks/review_task.php', ['supervisor' => $sid, 'student' => $tasks], function($message) use($tasks){

			            $student_email = '';
			            //get sstudent email
						foreach ($tasks as $stu) {
								$student_email = $stu->stuEmail;
							}
			            $message->to($student_email);
			            $message->subject('Project Task Comments.');
			        });

					// flash message and redirect
					$app->flash('success', 'Comments have been sent to the student.');
					$app->response->redirect($app->urlFor('supervisor.review_task',array('id' => $task_id)));
				}
				
			}

		}

		$app->render('supervisor/studentTasks/review_task.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'tasks' => $tasks
		]);
	}
	
})->name('supervisor.review_task.post');