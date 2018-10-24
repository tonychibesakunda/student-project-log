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

		//get student id
		$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$student_id = $row->student_id;
		}

		//get project report file and project report file name
		$query = "SELECT * FROM students WHERE user_id=$user_id";
		$project_report = DB::select(DB::raw($query));

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

		$app->render('student/myproject/add_project_report.php',[
			'project_report' => $project_report
		]);

	}
	

})->name('student.add_project_report.post');