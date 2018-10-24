<?php

use Logbook\User\Task;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/tasks/complete_task/:id', $student(), function($task_id) use($app){

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
	$get_task = "SELECT tasks.task_id, scheduled_meetings.supervision_id, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.supervisor_completion_comments, tasks.file_name, tasks.student_comments FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id AND tasks.task_id=$task_id";
	$tasks = DB::select(DB::raw($get_task));

	// get supervisory meetings
	$query = "SELECT supervisory_meetings.supervisory_meeting_id, supervisory_meetings.duration, scheduled_meetings.scheduled_date FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id";
	$supervisory_meetings = DB::select(DB::raw($query));

	$app->render('student/tasks/complete_task.php', [
		'tasks' => $tasks,
		'supervisory_meetings' => $supervisory_meetings
	]);

})->name('student.complete_task');

$app->post('/student/tasks/complete_task/:id', $student(), function($task_id) use($app){
	
	// when the send for approval button is clicked
	if(isset($_POST['send'])){

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
		$get_task = "SELECT tasks.task_id, scheduled_meetings.supervision_id, scheduled_meetings.scheduled_date, supervisory_meetings.duration, tasks.supervisory_meeting_id, tasks.task_description, tasks.sent_for_approval, tasks.sent_for_completion, tasks.is_approved, tasks.is_completed, tasks.supervisor_completion_comments, tasks.student_comments, tasks.file_name FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id AND tasks.task_id=$task_id";
		$tasks = DB::select(DB::raw($get_task));

		// get supervisory meetings
		$query = "SELECT supervisory_meetings.supervisory_meeting_id, supervisory_meetings.duration, scheduled_meetings.scheduled_date FROM supervisory_meetings INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id WHERE scheduled_meetings.supervision_id=$sp_id";
		$supervisory_meetings = DB::select(DB::raw($query));

		$request = $app->request;

		//get user input
		//$file = $request->post('file_attachments');
		$student_comments = $request->post('student_comments');
		$file_name = $request->post('file_name');
		
		//validate user input
		$v = $app->validation;

		$v->validate([
			'student_comments' => [$student_comments, 'required|alnumDash|min(4)']
		]);

		if($v->passes()){

			// check if file and comments already exist in database
			$query2 = "SELECT file_name, student_comments FROM tasks WHERE task_id=$task_id AND file_name='$file_name' AND student_comments='$student_comments'"; 
			$check = DB::select(DB::raw($query2));

			if(count($check) > 0){
				//flash message and redirect
				$app->flash('error', 'This file and set of comments has already been added to the system.');
				return $app->response->redirect($app->urlFor('student.complete_task',array('id' => $task_id)));
			}elseif(count($check) == 0){


				$file = $_FILES['file_attachments'];

				$fileName = $file['name'];
				$fileTmpName = $file['tmp_name'];
				$fileSize = $file['size'];
				$fileError = $file['error'];
				$fileType = $file['type'];

				//allowed files 
				$fileExt = explode('.', $fileName);
				$fileActualExt = strtolower(end($fileExt));

				$allowed = array('jpg', 'jpeg', 'png', 'pdf', 'docx', 'txt', 'pptx', 'zip', 'rar');

				if(in_array($fileActualExt, $allowed)){

					// check for errors when uploading file
					if($fileError === 0){

						//check for file size
						if($fileSize < 60000000){
							// get proper file name
							$fileNameNew = uniqid('', true).".".$fileActualExt;

							//upload file to root folder
							$fileDestination = $_SERVER['DOCUMENT_ROOT'].'/sprl_slim/uploads/tasks/'.$fileNameNew;

							// check if task is approved
							$query3 = "SELECT is_completed, is_approved FROM tasks WHERE task_id=$task_id";
							$checkApproval = DB::select(DB::raw($query3));

							foreach($checkApproval as $ca){
								$is_completed = $ca->is_completed;
								$is_approved = $ca->is_approved;
							}

							if($is_approved == 1){

								if($is_completed == 1){
									// flash message and redirect
									$app->flash('error', 'This task has already been completed');
									return $app->response->redirect($app->urlFor('student.complete_task',array('id' => $task_id)));
								}else{
									//upload file
									move_uploaded_file($fileTmpName, $fileDestination);
									
							 		//update the projects table
									Task::where('task_id', '=', $task_id)
											->update([
												'file_path' => $fileDestination,
												'file_name' => $file_name,
												'new_file_name' => $fileNameNew,
												'student_comments' => $student_comments,
												'sent_for_completion' => TRUE
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
									$app->flash('success', 'Task has been successfully sent for approval of completion.');
									return $app->response->redirect($app->urlFor('student.complete_task',array('id' => $task_id)));
								}

							}elseif($is_approved == 0 || is_null($is_approved)){
								// flash message and redirect
								$app->flash('error', 'Task has to be approved before it can be completed.');
								return $app->response->redirect($app->urlFor('student.complete_task',array('id' => $task_id)));
							}

						}else{
							// flash message and redirect
							$app->flash('error', 'Your file is too large. Only files below 50mb are allowed');
							return $app->response->redirect($app->urlFor('student.complete_task',array('id' => $task_id)));
						}
					}else{
						// flash message and redirect
						$app->flash('error', 'There was an error uploading your file!');
						return $app->response->redirect($app->urlFor('student.complete_task',array('id' => $task_id)));
					}

				} else{

					// flash message and redirect
					$app->flash('error', 'Files of this type are not allowed. Please attach a file');
					return $app->response->redirect($app->urlFor('student.complete_task',array('id' => $task_id)));

				}

			}

		}

		$app->render('student/tasks/complete_task.php', [
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
})->name('student.complete_task.post');