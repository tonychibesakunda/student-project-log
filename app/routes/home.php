<?php
/** Route for the home.php in views folder **/

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/', function() use ($app){

	//get student projects
	$query = "SELECT supervisions.supervision_id, students.is_final_project_report_approved ,users.first_name,users.last_name,users.other_names,projects.project_name, projects.project_description, students.project_end_date FROM supervisions INNER JOIN students ON supervisions.student_id =students.student_id INNER JOIN  users ON students.user_id=users.id LEFT JOIN projects ON students.project_id=projects.project_id WHERE students.is_final_project_report_approved=1";
	$student_projects = DB::select(DB::raw($query));

	// get project categories
	$query2 = 'SELECT * FROM project_categories';
	$project_categories = DB::select(DB::raw($query2));

	$app->render('home.php',[
		'student_projects' => $student_projects,
		'project_categories' => $project_categories
	]);

})->name('home');

$app->post('/', function() use ($app){

	if(isset($_POST['search'])){

		//get student projects
		$query = "SELECT supervisions.supervision_id, students.is_final_project_report_approved ,users.first_name,users.last_name,users.other_names,projects.project_name, projects.project_description, students.project_end_date FROM supervisions INNER JOIN students ON supervisions.student_id =students.student_id INNER JOIN  users ON students.user_id=users.id LEFT JOIN projects ON students.project_id=projects.project_id WHERE students.is_final_project_report_approved=1";
		$student_projects = DB::select(DB::raw($query));

		// get project categories
		$query2 = 'SELECT * FROM project_categories';
		$project_categories = DB::select(DB::raw($query2));

		$request = $app->request;

		//get user input
		$search_project_name = $request->post('search_project_name');

		//validate user input
		$v = $app->validation;

		$v->validate([
			'search_project_name' => [$search_project_name, 'required|alnumDash|max(250)']
		]);

		if($v->passes()){
			//get student projects
			$projects = "SELECT supervisions.supervision_id, students.is_final_project_report_approved ,users.first_name,users.last_name,users.other_names,projects.project_name, projects.project_description, students.project_end_date FROM supervisions INNER JOIN students ON supervisions.student_id =students.student_id INNER JOIN  users ON students.user_id=users.id LEFT JOIN projects ON students.project_id=projects.project_id WHERE (projects.project_name LIKE '%$search_project_name%' OR users.first_name LIKE '%$search_project_name%' OR users.last_name LIKE '%$search_project_name%' OR users.other_names LIKE '%$search_project_name%' OR students.project_end_date LIKE '%$search_project_name%') AND students.is_final_project_report_approved=1";
			$student_projects = DB::select(DB::raw($projects));
		}

	}

	if(isset($_POST['search_category'])){

		//get student projects
		$query = "SELECT supervisions.supervision_id, students.is_final_project_report_approved ,users.first_name,users.last_name,users.other_names,projects.project_name, projects.project_description, students.project_end_date FROM supervisions INNER JOIN students ON supervisions.student_id =students.student_id INNER JOIN  users ON students.user_id=users.id LEFT JOIN projects ON students.project_id=projects.project_id WHERE students.is_final_project_report_approved=1";
		$student_projects = DB::select(DB::raw($query));

		// get project categories
		$query2 = 'SELECT * FROM project_categories';
		$project_categories = DB::select(DB::raw($query2));

		$request = $app->request;

		//get user input
		$project_cat_id = $request->post('search_project_category');

		//validate user input
		$v = $app->validation;

		$v->validate([
			'search_project_category' => [$project_cat_id, 'int']
		]);

		if($v->passes()){
			//get student projects
			$projects = "SELECT supervisions.supervision_id, students.is_final_project_report_approved ,users.first_name,users.last_name,users.other_names,projects.project_name, projects.project_description, students.project_end_date FROM supervisions INNER JOIN students ON supervisions.student_id =students.student_id INNER JOIN  users ON students.user_id=users.id LEFT JOIN projects ON students.project_id=projects.project_id INNER JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id WHERE project_categories.project_cat_id=$project_cat_id AND students.is_final_project_report_approved=1";
			$student_projects = DB::select(DB::raw($projects));
		}
	
	}

	$app->render('home.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'student_projects' => $student_projects,
		'project_categories' => $project_categories
	]);

})->name('home.post');
