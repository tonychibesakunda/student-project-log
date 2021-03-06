<?php

use Logbook\User\Student;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/myproject/add_project_report', $student(), function() use($app){

	//student details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$student_id = '';

	//get student id
	$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$student_id = $row->student_id;
	}

	//get project report file and project report file name
	$query = "SELECT * FROM students WHERE user_id=$user_id";
	$project_report = DB::select(DB::raw($query));


	$app->render('student/myproject/add_project_report.php',[
		'project_report' => $project_report
	]);

})->name('student.add_project_report');

$app->post('/student/myproject/add_project_report', $student(), function() use($app){

	if(isset($_POST['add'])){

		//student details
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$student_id = '';
		$file_path = '';

		//get student id
		$get_id =  "SELECT students.student_id, users.* FROM students INNER JOIN users ON students.user_id=users.id WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$student_id = $row->student_id;
		}

		//get assigned supervisors
		$sup = "SELECT supervisions.*, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, (SELECT users.email FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suEmail FROM supervisions WHERE student_id=$student_id";
		$supervisors = DB::select(DB::raw($sup));

		//get project report file and project report file name
		$query = "SELECT * FROM students WHERE user_id=$user_id";
		$project_report = DB::select(DB::raw($query));

		foreach($project_report as $p){
			//get file path
			$file_path = $p->final_project_report_file_path;
		}

		$request = $app->request;

		$project_report_name = $request->post('project_report_name');

		$file = $_FILES['project_report_file'];

		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileError = $file['error'];
		$fileType = $file['type'];

		//allowed files 
		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = array('pdf'); //array('jpg', 'jpeg', 'png', 'pdf');

		//check if the project is completed
		$prc = "SELECT is_final_project_report_approved FROM students WHERE user_id=$user_id AND is_final_project_report_approved=1";
		$project_complete = DB::select(DB::raw($prc));

		if(count($project_complete) > 0){
			//flash message and redirect
			$app->flash('warning', 'This project has already been completed.');
			return $app->response->redirect($app->urlFor('student.add_project_report'));
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
				return $app->response->redirect($app->urlFor('student.add_project_report'));
			}else{

				//check if project objectives have been approved
				$po = "SELECT is_completed FROM project_objectives WHERE student_id=$student_id AND (is_completed=0 OR is_completed IS NULL)";
				$approved_obj = DB::select(DB::raw($po));

				if(count($approved_obj) > 0){
					//flash message and redirect
					$app->flash('warning', 'All your project objectives have to be approved before adding a report.');
					return $app->response->redirect($app->urlFor('student.add_project_report'));
				}else{

					// check if there is a file already uploaded
					if(is_null($file_path)){

						if(in_array($fileActualExt, $allowed)){

							// check for errors when uploading file
							if($fileError === 0){

								//check for file size
								if($fileSize < 20000000){
									// get proper file name
									$fileNameNew = uniqid('', true).".".$fileActualExt;

									//upload file to root folder
									$fileDestination = $_SERVER['DOCUMENT_ROOT'].'/sprl_slim/uploads/project_reports/'.$fileNameNew;

									//upload file
									move_uploaded_file($fileTmpName, $fileDestination);
									//update records
									Student::where('user_id', '=', $user_id)
							 					->update([
							 						'final_project_report_file_path' => $fileDestination,
							 						'final_project_report_file_name' => $project_report_name,
							 						'final_project_report_new_file_name' => $fileNameNew
							 					]);

							 		//get project report file and project report file name
									$p_report = "SELECT * FROM students WHERE user_id=$user_id";
									$project_report = DB::select(DB::raw($p_report));

							 		// Send email to supervisor
							        $app->mail->send('email/project_report/project_report.php', ['student' => $sid, 'supervisors' => $supervisors, 'project_report' => $project_report], function($message) use($supervisors){

							            $supervisor_email = '';
							            //get supervisor email
										foreach ($supervisors as $sup) {
												$supervisor_email = $sup->suEmail;
											}
							            $message->to($supervisor_email);
							            $message->subject('Approve Project Report (Thesis).');
							        });

									// flash message and redirect
									$app->flash('success', 'File successfully uploaded.');
									return $app->response->redirect($app->urlFor('student.add_project_report'));

								}else{
									// flash message and redirect
									$app->flash('error', 'Your file is too large. Only files below 20mb are allowed.');
									return $app->response->redirect($app->urlFor('student.add_project_report'));
								}
							}else{
								// flash message and redirect
								$app->flash('error', 'There was an error uploading your file!');
								return $app->response->redirect($app->urlFor('student.add_project_report'));
							}

						} else{

							// flash message and redirect
							$app->flash('error', 'Only pdf files are allowed, Please attach a pdf file.');
							return $app->response->redirect($app->urlFor('student.add_project_report'));

						}

					}else{
						// delete the already uploaded file first
						unlink($file_path);

						// update table
						Student::where('user_id', '=', $user_id)
				 					->update([
				 						'final_project_report_file_path' => NULL,
				 						'final_project_report_file_name' => NULL,
				 						'final_project_report_new_file_name' => NULL
				 					]);

						// then upload new selected file
						if(in_array($fileActualExt, $allowed)){

							// check for errors when uploading file
							if($fileError === 0){

								//check for file size
								if($fileSize < 20000000){
									// get proper file name
									$fileNameNew = uniqid('', true).".".$fileActualExt;

									//upload file to root folder
									$fileDestination = $_SERVER['DOCUMENT_ROOT'].'/sprl_slim/uploads/project_reports/'.$fileNameNew;

									//upload file
									move_uploaded_file($fileTmpName, $fileDestination);
									//update records
									Student::where('user_id', '=', $user_id)
							 					->update([
							 						'final_project_report_file_path' => $fileDestination,
							 						'final_project_report_file_name' => $project_report_name,
							 						'final_project_report_new_file_name' => $fileNameNew
							 					]);

							 		//get project report file and project report file name
									$p_report = "SELECT * FROM students WHERE user_id=$user_id";
									$project_report = DB::select(DB::raw($p_report));

							 		// Send email to supervisor
							        $app->mail->send('email/project_report/project_report.php', ['student' => $sid, 'supervisors' => $supervisors, 'project_report' => $project_report], function($message) use($supervisors){

							            $supervisor_email = '';
							            //get supervisor email
										foreach ($supervisors as $sup) {
												$supervisor_email = $sup->suEmail;
											}
							            $message->to($supervisor_email);
							            $message->subject('Approve Project Report (Thesis).');
							        });

									// flash message and redirect
									$app->flash('success', 'File successfully uploaded.');
									return $app->response->redirect($app->urlFor('student.add_project_report'));

								}else{
									// flash message and redirect
									$app->flash('error', 'Your file is too large. Only files below 20mb are allowed.');
									return $app->response->redirect($app->urlFor('student.add_project_report'));
								}
							}else{
								// flash message and redirect
								$app->flash('error', 'There was an error uploading your file!');
								return $app->response->redirect($app->urlFor('student.add_project_report'));
							}

						} else{

							// flash message and redirect
							$app->flash('error', 'Only pdf files are allowed, Please attach a pdf file.');
							return $app->response->redirect($app->urlFor('student.add_project_report'));

						}
					}
						
				}
				
			}
		}		

		$app->render('student/myproject/add_project_report.php',[
			'project_report' => $project_report
		]);

	}
	

})->name('student.add_project_report.post');