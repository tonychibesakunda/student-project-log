<?php

use Logbook\User\Student;
use Logbook\User\Project;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/myproject/edit_project/:id', $student(), function($projectId) use($app){

	$query = 'SELECT * FROM project_categories';
	$query2 = 'SELECT * FROM project_types';
	$project_categories = DB::select(DB::raw($query));
	$project_types = DB::select(DB::raw($query2));

	//get project details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$query3 = "SELECT projects.*, students.project_start_date, students.project_end_date, students.project_aims FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.user_id=$user_id";
	$projects = DB::select(DB::raw($query3));

	$app->render('student/myproject/edit_project.php',[
		'projects' => $projects,
		'project_categories' => $project_categories,
		'project_types' => $project_types
	]);

})->name('student.edit_project');

$app->post('/student/myproject/edit_project/:id', $student(), function($projectId) use($app){

	//when the save changes button is clicked
	if(isset($_POST['save'])){

		$query = 'SELECT * FROM project_categories';
		$query2 = 'SELECT * FROM project_types';
		$project_categories = DB::select(DB::raw($query));
		$project_types = DB::select(DB::raw($query2));

		//get project details
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$query3 = "SELECT projects.*, students.project_start_date, students.project_end_date, students.project_aims FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.user_id=$user_id";
		$projects = DB::select(DB::raw($query3));

		$user_id = $_SESSION[$app->config->get('auth.session')];

		$request = $app->request;

		//get user input
		$project_name = $request->post('project_name');
		$project_category = $request->post('project_category');
		$project_description = $request->post('project_description');
		$project_start_date = $request->post('project_start_date');
		$project_end_date = $request->post('project_end_date');
		$project_type = $request->post('project_type');
		$project_aim = $request->post('project_aim');

		//validate user input
		$v = $app->validation;

		$v->validate([
			'project_name' => [$project_name, 'required|alnumDash|max(250)'],
			'project_category' => [$project_category, 'int'],
			'project_description' => [$project_description, 'required'],
			'project_start_date' => [$project_start_date, 'required|date'],
			'project_end_date' => [$project_end_date, 'required|date'],
			'project_type' => [$project_type, 'int'],
			'project_aim' => [$project_aim, 'required']
		]);

		if($v->passes()){

			//check if the project is completed
			$prc = "SELECT is_final_project_report_approved FROM students WHERE user_id=$user_id AND is_final_project_report_approved=1";
			$project_complete = DB::select(DB::raw($prc));

			if(count($project_complete) > 0){
				$app->flash('warning', 'This project has already been completed.');
				return $app->response->redirect($app->urlFor('student.edit_project',array('id' => $projectId)));	
			}else{
				$startdate = strtotime($project_start_date);
				$enddate = strtotime($project_end_date);

				if($startdate == $enddate){
					$app->flash('error', 'start date cannot be the same as the end date.');
					return $app->response->redirect($app->urlFor('student.edit_project',array('id' => $projectId)));
				}

				if($startdate > $enddate){
					$app->flash('error', 'start date cannot be higher than the end date.');
					return $app->response->redirect($app->urlFor('student.edit_project',array('id' => $projectId)));
				}

				if($startdate < $enddate){
					
					//update the projects table
					Project::where('project_id', '=', $projectId)
							->update([
								'project_name' => $project_name,
								'project_description' => $project_description,
								'project_cat_id' => $project_category,
								'project_type_id' => $project_type
							]);


					//update the students table
					Student::where('user_id', '=', $user_id)
								->update([
									'project_start_date' => $project_start_date,
									'project_end_date' => $project_end_date,
									'project_aims' => $project_aim
								]);

					$app->flash('success', 'Your project details have been successfully updated.');
					return $app->response->redirect($app->urlFor('student.edit_project',array('id' => $projectId)));
				}
			}

			

		}

		$app->render('student/myproject/edit_project.php',[
			'errors' => $v->errors(),
			'request' => $request,
			'projects' => $projects,
			'project_categories' => $project_categories,
			'project_types' => $project_types
		]);

	}

	//when the back button is clicked
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('student.view_project_details'));
	}

})->name('student.edit_project.post');