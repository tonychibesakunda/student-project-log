<?php

use Logbook\User\Supervision;
use Logbook\User\UserPermission;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/view_assigned_supervisors', $coordinator(), function() use($app){

	//supervision details
	$query = "SELECT supervisions.supervision_id, students.student_id, supervisors.supervisor_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id";
    $supervisions = DB::select(DB::raw($query));


	$app->render('coordinator/projects/view_assigned_supervisors.php',[
        'supervisions' => $supervisions
    ]);

})->name('coordinator.view_assigned_supervisors');

$app->post('/coordinator/projects/view_assigned_supervisors/:id', $coordinator(), function($id) use($app){

	$studentId = '';
	$supervisorId = '';
	$studentUserId = '';
	$supervisorUserId = '';

	if(isset($_POST['delete'])){
		$query2 = "SELECT student_id, supervisor_id FROM supervisions WHERE supervision_id=$id";
		$run = DB::select(DB::raw($query2));

		foreach ($run as $row) {
				$studentId = $row->student_id;
			}

		foreach ($run as $row) {
				$supervisorId = $row->supervisor_id;
			}

		$query3 = "SELECT * FROM supervisions WHERE student_id=$studentId";
		$run2 = DB::select(DB::raw($query3));

		$query4 = "SELECT * FROM supervisions WHERE supervisor_id=$supervisorId";
		$run3 = DB::select(DB::raw($query4));

		$query5 = "SELECT user_id FROM students WHERE student_id=$studentId";
		$run4 = DB::select(DB::raw($query5));

		foreach ($run4 as $row) {
				$studentUserId = $row->user_id;
			}

		$query6 = "SELECT user_id FROM supervisors WHERE supervisor_id=$supervisorId";
		$run5 = DB::select(DB::raw($query6));
		
		foreach ($run5 as $row) {
				$supervisorUserId = $row->user_id;
			}

		if(count($run2) == 1 ){
			//update users_permissions table
			UserPermission::where('user_id', $studentUserId)
							->update([
								'is_assigned' => false
							]);	
		}

		if(count($run3) == 1){
			//update users_permissions table
			UserPermission::where('user_id', $supervisorUserId)
							->update([
								'is_assigned' => false
							]);	
		}

		//delete supervision record
		Supervision::where('supervision_id', $id)->delete();

		//flash message and redirect
		$app->flash('success', "Supervision record has been successfully deleted.");
        return $app->response->redirect($app->urlFor('coordinator.view_assigned_supervisors'));

	}

})->name('coordinator.view_assigned_supervisors.post');
