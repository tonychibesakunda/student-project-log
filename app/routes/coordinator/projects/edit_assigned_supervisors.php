<?php

use Logbook\User\Supervision;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/edit_assigned_supervisors/:id', $coordinator(), function($supervisionId) use($app){

	// get supervision details using supervision id
	$query = "SELECT supervisions.supervision_id, students.student_id, supervisors.supervisor_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id WHERE supervisions.supervision_id=$supervisionId";
	$supervision = DB::select(DB::raw($query));

	//get student details
	$students = DB::table('students')
            ->select(
            	'students.student_id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names'
            )
            ->join(
                'users',
                'students.user_id','=','users.id'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where(['users_permissions.is_assigned' => true])
            ->get();

    //get supervisor details
	$supervisors = DB::table('supervisors')
            ->select(
            	'supervisors.supervisor_id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names'
            )
            ->join(
                'users',
                'supervisors.user_id','=','users.id'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where(['users_permissions.is_assigned' => true])
            ->get();

	$app->render('coordinator/projects/edit_assigned_supervisors.php',[
		'supervision' => $supervision,
		'students' => $students,
		'supervisors' => $supervisors
	]);

})->name('coordinator.edit_assigned_supervisors');

$app->post('/coordinator/projects/edit_assigned_supervisors/:id', $coordinator(), function($supervisionId) use($app){
	if(isset($_POST['save'])){
		// get supervision details using supervision id
		$query = "SELECT supervisions.supervision_id, students.student_id, supervisors.supervisor_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id WHERE supervisions.supervision_id=$supervisionId";
		$supervision = DB::select(DB::raw($query));

		//get student details
		$students = DB::table('students')
	            ->select(
	            	'students.student_id',
	                'users.username',
	                'users.first_name',
	                'users.last_name',
	                'users.other_names'
	            )
	            ->join(
	                'users',
	                'students.user_id','=','users.id'
	            )
	            ->join(
	                'users_permissions',
	                'users.id','=','users_permissions.user_id'
	            )
	            ->where(['users_permissions.is_assigned' => true])
	            ->get();

	    //get supervisor details
		$supervisors = DB::table('supervisors')
	            ->select(
	            	'supervisors.supervisor_id',
	                'users.username',
	                'users.first_name',
	                'users.last_name',
	                'users.other_names'
	            )
	            ->join(
	                'users',
	                'supervisors.user_id','=','users.id'
	            )
	            ->join(
	                'users_permissions',
	                'users.id','=','users_permissions.user_id'
	            )
	            ->where(['users_permissions.is_assigned' => true])
	            ->get();

	    $request = $app->request;

		//get user input
		$selectStudent = $request->post('selectStudent');
		$selectSupervisor = $request->post('selectSupervisor');

		//validate user input
		$v = $app->validation;

		$v->validate([
			'selectStudent' => [$selectStudent, 'int'],
			'selectSupervisor' => [$selectSupervisor, 'int']
		]);

		if($v->passes()){

			//check for existing supervisions
			$query2 = "SELECT * FROM supervisions WHERE student_id=$selectStudent AND supervisor_id=$selectSupervisor";
			$sp = DB::select(DB::raw($query2));

			if(count($sp) > 0){
				$app->flash('error', 'This supervision already exists.');
				return $app->response->redirect($app->urlFor('coordinator.edit_assigned_supervisors', array('id' => $supervisionId)));
			}

	        //update record into supervisions table
			Supervision::where('supervision_id', '=', $supervisionId)
						->update([
							'student_id' => $selectStudent,
							'supervisor_id' => $selectSupervisor
						]);

			//flash message and redirect
			$app->flash('success', 'Update was successful.');
			return $app->response->redirect($app->urlFor('coordinator.edit_assigned_supervisors', array('id' => $supervisionId)));


		}

		//pass errors into view and save previous type info
		$app->render('coordinator/projects/edit_assigned_supervisors.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'supervision' => $supervision,
			'students' => $students,
			'supervisors' => $supervisors
		]);
	}

	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('coordinator.view_assigned_supervisors'));
	}
})->name('coordinator.edit_assigned_supervisors.post');