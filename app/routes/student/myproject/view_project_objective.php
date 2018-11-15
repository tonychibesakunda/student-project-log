<?php

use Logbook\User\ProjectObjective;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/myproject/view_project_objective', $student(), function() use($app){

	$user_id = $_SESSION[$app->config->get('auth.session')];
	$student_id = '';

	//get student id
	$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$student_id = $row->student_id;
	}

	//project objectives
	$query = "SELECT * FROM project_objectives WHERE student_id=$student_id";
	$project_objectives = DB::select(DB::raw($query));

	$app->render('student/myproject/view_project_objective.php',[
		'project_objectives' => $project_objectives
	]);

})->name('student.view_project_objective');

$app->post('/student/myproject/view_project_objective', $student(), function() use($app){

	if(isset($_POST['complete'])){
		$user_id = $_SESSION[$app->config->get('auth.session')];
		$student_id = '';
		$sent_for_approval = '';
		$po_is_completed = '';
		$pid=$_POST['complete'];

		//get student id
		$get_id =  "SELECT students.student_id, users.* FROM students INNER JOIN users ON students.user_id=users.id WHERE user_id=$user_id";
		$student = DB::select(DB::raw($get_id));

		foreach ($student as $row) {
			$student_id = $row->student_id;
		}

		//get assigned supervisors
		$sup = "SELECT supervisions.*, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, (SELECT users.email FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suEmail FROM supervisions WHERE student_id=$student_id";
		$supervisors = DB::select(DB::raw($sup));

		// //get student id
		// $get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
		// $sid = DB::select(DB::raw($get_id));


		// foreach ($sid as $row) {
		// 	$student_id = $row->student_id;
		// }

		//project objectives
		$query = "SELECT * FROM project_objectives WHERE student_id=$student_id AND po_id=$pid";
		$project_objectives = DB::select(DB::raw($query));

		foreach ($project_objectives as $po) {
			$sent_for_approval = $po->sent_for_approval;
			$po_is_completed = $po->is_completed;
		}

		

		if(($sent_for_approval == NULL || $sent_for_approval == FALSE) && ($po_is_completed == FALSE || $po_is_completed == NULL)){

			//update the project_objectives table
			ProjectObjective::where('po_id', '=', $pid)
								->update([
									'sent_for_approval' => TRUE
								]);


			// Send email to supervisor
	        $app->mail->send('email/project_objectives/approve_project_objective.php', ['student' => $student, 'supervisors' => $supervisors, 'project_objectives' => $project_objectives], function($message) use($supervisors){

	            $supervisor_email = '';
	            //get supervisor email
				foreach ($supervisors as $sup) {
						$supervisor_email = $sup->suEmail;
					}
	            $message->to($supervisor_email);
	            $message->subject('Approve Project Objective.');
	        });

	        //flash message and redirect
			$app->flash('info', 'Project Objective has been sent for approval.');
			return $app->response->redirect($app->urlFor('student.view_project_objective'));


		}elseif($sent_for_approval == TRUE){

			//flash message and redirect
			$app->flash('error', 'This objective has already been sent for approval.');
			return $app->response->redirect($app->urlFor('student.view_project_objective'));
		}elseif($po_is_completed == TRUE){
			//flash message and redirect
			$app->flash('error', 'This objective has already been approved.');
			return $app->response->redirect($app->urlFor('student.view_project_objective'));
		}

		
	}

	
	
})->name('student.view_project_objective.post');

$app->post('/student/myproject/view_project_objective/:id', $student(), function($id) use($app){
	if(isset($_POST['delete'])){

		$user_id = $_SESSION[$app->config->get('auth.session')];
		$student_id = '';
		$po_is_completed = '';
		$sent_for_approval = '';
		$pid = $_POST['delete'];

		//get student id
		$get_id =  "SELECT student_id FROM students WHERE user_id=$user_id";
		$sid = DB::select(DB::raw($get_id));

		foreach ($sid as $row) {
			$student_id = $row->student_id;
		}

		//project objectives
		$query = "SELECT * FROM project_objectives WHERE po_id=$id";
		$project_objectives = DB::select(DB::raw($query));

		foreach ($project_objectives as $po) {
			$po_is_completed = $po->is_completed;
			$sent_for_approval = $po->sent_for_approval;
			$supervisor_comments = $po->supervisor_comments;
		}

		if(!is_null($supervisor_comments)){
			//delete records
        	ProjectObjective::where('po_id', $id)->delete();

        	//flash message
			$app->flash('success', "Objective has been successfully removed");
        	return $app->response->redirect($app->urlFor('student.view_project_objective'));
		}

		if($po_is_completed == TRUE){

			//flash message
			$app->flash('error', "Objectives that have been completed cannot be deleted");
        	return $app->response->redirect($app->urlFor('student.view_project_objective'));

		}elseif($sent_for_approval == TRUE){
			//flash message
			$app->flash('error', "Objectives that have been sent for approval cannot be deleted");
        	return $app->response->redirect($app->urlFor('student.view_project_objective'));
		}else{

			//delete records
        	ProjectObjective::where('po_id', $id)->delete();

        	//flash message
			$app->flash('success', "Objective has been successfully removed");
        	return $app->response->redirect($app->urlFor('student.view_project_objective'));

		}
		
	}	
})->name('student.view_project_objective.posts');