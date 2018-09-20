<?php

use Logbook\User\Project;
use Logbook\User\Student;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/myproject/add_project', $student(), function() use($app){

	// get project categories and types
	$query = 'SELECT * FROM project_categories';
	$query2 = 'SELECT * FROM project_types';
	$project_categories = DB::select(DB::raw($query));
	$project_types = DB::select(DB::raw($query2));

	$app->render('student/myproject/add_project.php',[
		'project_categories' => $project_categories,
		'project_types' => $project_types
	]);

})->name('student.add_project');

$app->post('/student/myproject/add_project', $student(), function() use($app){

	$query = 'SELECT * FROM project_categories';
	$query2 = 'SELECT * FROM project_types';
	$project_categories = DB::select(DB::raw($query));
	$project_types = DB::select(DB::raw($query2));

	$user_id = $_SESSION[$app->config->get('auth.session')];
	$project_id = '';

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
		'project_description' => [$project_description, 'required|alnumDash'],
		'project_start_date' => [$project_start_date, 'required|date'],
		'project_end_date' => [$project_end_date, 'required|date'],
		'project_type' => [$project_type, 'int'],
		'project_aim' => [$project_aim, 'required|alnumDash']
	]);

	if($v->passes()){

		$startdate = strtotime($project_start_date);
		$enddate = strtotime($project_end_date);

		if($startdate == $enddate){
			$app->flash('error', 'start date cannot be the same as the end date.');
			return $app->response->redirect($app->urlFor('student.add_project'));
		}

		if($startdate > $enddate){
			$app->flash('error', 'start date cannot be higher than the end date.');
			return $app->response->redirect($app->urlFor('student.add_project'));
		}

		if($startdate < $enddate){
			//check if project has already been added
			$query3 = "SELECT projects.*, students.project_start_date, students.project_end_date, students.project_aims FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.user_id=$user_id";
			$project = DB::select(DB::raw($query3));

			if(count($project) > 0){
				$app->flash('error', 'You already have a project added to the system.');
				return $app->response->redirect($app->urlFor('student.add_project'));
			}

			//insert data into the projects table
			DB::table('projects')
			->insert([
				'project_name' => $project_name,
				'project_description' => $project_description,
				'project_cat_id' => $project_category,
				'project_type_id' => $project_type
			]);

			//get project id
			$get_id = "SELECT project_id FROM projects WHERE project_name='$project_name' AND project_description='$project_description' AND project_cat_id=$project_category AND project_type_id=$project_type;";
			$pid = DB::select(DB::raw($get_id));

	        foreach ($pid as $row) {
					$project_id = $row->project_id;
				}

			//update the students table
			Student::where('user_id', '=', $user_id)
						->update([
							'project_id' => $project_id,
							'project_start_date' => $project_start_date,
							'project_end_date' => $project_end_date,
							'project_aims' => $project_aim
						]);

			$app->flash('success', 'Your project has been successfully added.');
			return $app->response->redirect($app->urlFor('student.add_project'));
		}

	}


	$app->render('student/myproject/add_project.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'project_categories' => $project_categories,
		'project_types' => $project_types
	]);
})->name('student.add_project.post');