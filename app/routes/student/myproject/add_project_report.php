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
	$query = "SELECT final_project_report_file, final_project_report_file_name FROM students WHERE user_id=$user_id";
	$project_report = DB::select(DB::raw($query));


	$app->render('student/myproject/add_project_report.php',[
		'project_report' => $project_report
	]);

})->name('student.add_project_report');

$app->post('/student/myproject/add_project_report', $student(), function() use($app){

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
	$query = "SELECT final_project_report_file, final_project_report_file_name FROM students WHERE user_id=$user_id";
	$project_report = DB::select(DB::raw($query));

	foreach ($project_report as $pr ) {
		$final_project_report_file = $pr->final_project_report_file;
		$final_project_report_file_name = $pr->final_project_report_file_name;
	}

	$request = $app->request;

	//get user input
	$project_report_file = $request->post('project_report_file');
	$project_report_name = $request->post('project_report_name');

	// validate user input
	$v = $app->validation;

	$v->validate([
		'project_report_file' => [$project_report_file, 'required']
	]);

	if($v->passes()){
		$getPDF = explode(".", $project_report_name);

		if($getPDF[1] == "pdf"){

			//check if project objectives have been completed
			$query2 = "SELECT * FROM project_objectives WHERE student_id=$student_id AND is_completed=FALSE";
			$checkPO = DB::select(DB::raw($query2));

			if(count($checkPO) > 0){
				//flash message and redirect
				$app->flash('error', 'All your project objectives have to be completed before adding your final project report.');
				return $app->response->redirect($app->urlFor('student.add_project_report'));
			}elseif(count($checkPO) == 0){

				//update records
				Student::where('user_id', '=', $user_id)
						->update([
							'final_project_report_file' => $project_report_file,
							'final_project_report_file_name' => $project_report_name
						]);
				//flash message and redirect
				$app->flash('success', 'Project Report has been successfully added');
				return $app->response->redirect($app->urlFor('student.add_project_report'));
			}

		}else{
			//flash message and redirect
			$app->flash('error', 'Only pdf files are allowed, Please attach a pdf file.');
			return $app->response->redirect($app->urlFor('student.add_project_report'));	
		}
	}

	$app->render('student/myproject/add_project_report.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'project_report' => $project_report
	]);

})->name('student.add_project_report.post');