<?php

use Logbook\User\ProjectObjective;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/myproject/edit_project_objective/:id', $student(), function($po_id) use($app){

	$user_id = $_SESSION[$app->config->get('auth.session')];
	$student_id = '';

	//get student id
	$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$student_id = $row->student_id;
	}

	//project objectives
	$query = "SELECT * FROM project_objectives WHERE student_id=$student_id AND po_id=$po_id";
	$project_objective = DB::select(DB::raw($query));

	$app->render('student/myproject/edit_project_objective.php',[
		'project_objective' => $project_objective
	]);

})->name('student.edit_project_objective');

$app->post('/student/myproject/edit_project_objective/:id', $student(), function($po_id) use($app){

	//when the save objective button is clicked
	if(isset($_POST['save'])){

		$user_id = $_SESSION[$app->config->get('auth.session')];
		$student_id = '';

		//get student id
		$get_id =  "SELECT students.student_id, users.* FROM students INNER JOIN users ON students.user_id=users.id WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$student_id = $row->student_id;
		}

		//get assigned supervisors
		$sup = "SELECT supervisions.*, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, (SELECT users.email FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suEmail FROM supervisions WHERE student_id=$student_id";
		$supervisors = DB::select(DB::raw($sup));

		//project objectives
		$query = "SELECT * FROM project_objectives WHERE student_id=$student_id AND po_id=$po_id";
		$projectObjective = DB::select(DB::raw($query));

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

			//check if the project is completed
			$prc = "SELECT is_final_project_report_approved FROM students WHERE user_id=$user_id AND is_final_project_report_approved=1";
			$project_complete = DB::select(DB::raw($prc));

			if(count($project_complete) > 0){
				//flash message and redirect
				$app->flash('warning', 'This project has already been completed.');
				return $app->response->redirect($app->urlFor('student.edit_project_objective',array('id' => $po_id)));
			}else{
				//update the projects table
				ProjectObjective::where('po_id', '=', $po_id)
									->update([
										'project_objective' => $project_objective
									]);

				//project objectives
				$p_obj = "SELECT * FROM project_objectives WHERE student_id=$student_id AND po_id=$po_id";
				$project_objectives = DB::select(DB::raw($p_obj));

				// Send email to supervisor
		        $app->mail->send('email/project_objectives/edited_project_objective.php', ['student' => $sid, 'supervisors' => $supervisors, 'project_objectives' => $project_objectives], function($message) use($supervisors){

		            $supervisor_email = '';
		            //get supervisor email
					foreach ($supervisors as $sup) {
							$supervisor_email = $sup->suEmail;
						}
		            $message->to($supervisor_email);
		            $message->subject('Approve Project Objective.');
		        });

				//flash message and redirect
				$app->flash('success', 'Project Objective has been successfully updated.');
				return $app->response->redirect($app->urlFor('student.edit_project_objective',array('id' => $po_id)));
			}
			
		}

		$app->render('student/myproject/edit_project_objective.php',[
			'errors' => $v->errors(),
			'request' => $request,
			'project_objective' => $projectObjective
		]);

	}

	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('student.view_project_objective'));
	}
	
})->name('student.edit_project_objective.post');