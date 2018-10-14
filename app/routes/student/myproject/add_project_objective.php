<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/myproject/add_project_objective', $student(), function() use($app){

	$app->render('student/myproject/add_project_objective.php');

})->name('student.add_project_objective');

$app->post('/student/myproject/add_project_objective', $student(), function() use($app){

	//when the add objective button is clicked
	if(isset($_POST['add'])){

		$user_id = $_SESSION[$app->config->get('auth.session')];
		$student_id = '';

		//get student id
		$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$student_id = $row->student_id;
		}

		$request = $app->request;

		//get user input
		$project_objective = $request->post('project_objective');

		//validate user input
		$v = $app->validation;

		$v->addRuleMessage('uniqueProjectObjective', 'This project objective has already been added.');

		$v->addRule('uniqueProjectObjective', function($value, $input, $args) use($app){

			$user_id = $_SESSION[$app->config->get('auth.session')];
			$student_id = '';

			//get student id
			$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
			$sid = DB::select(DB::raw($get_id));

			foreach ($sid as $row) {
				$student_id = $row->student_id;
			}

		    $po = DB::table('project_objectives')
				    	->select('project_objective')
				    	->where([
				    		'student_id' => $student_id,
				    		'project_objective' => $value
				    	])
				    	->first();

			
		    return ! (bool) $po;
		});

		$v->validate([
			'project_objective' => [$project_objective, 'required|alnumDash|max(250)|uniqueProjectObjective']
		]);

		if($v->passes()){

			//insert project objective record in database
			DB::table('project_objectives')
				->insert([
					'student_id' => $student_id,
					'project_objective' => $project_objective,
					'is_completed' => FALSE,
					'sent_for_approval' => FALSE
				]);
			
			//flash message and redirect
			$app->flash('success', 'Project Objective has been successfully added.');
			return $app->response->redirect($app->urlFor('student.add_project_objective'));
			
		}

		$app->render('student/myproject/add_project_objective.php',[
			'errors' => $v->errors(),
			'request' => $request
		]);

	}
	
})->name('student.add_project_objective.post');