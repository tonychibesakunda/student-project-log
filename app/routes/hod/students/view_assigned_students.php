<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/hod/students/view_assigned_students', $hod(), function() use($app){

	//supervision details
	$query = "SELECT supervisions.supervision_id, students.student_id, supervisors.supervisor_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id";
    $supervisions = DB::select(DB::raw($query));

    //get unassigned student details
	$unassignedStudents = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names',
                'users.email',
                'users.active',
                'users_permissions.is_student',
                'users_permissions.is_assigned'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where([
            	'users_permissions.is_student' => true,
            	'users_permissions.is_assigned' => false
            ])
            ->get();

    //get supervisor details
	$supervisors = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names',
                'users.email',
                'users.active',
                'users_permissions.is_supervisor'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where(['users_permissions.is_supervisor' => true])
            ->get();

    // get supervisor id
    $sp_id = "SELECT supervisor_id FROM supervisors";
    $spID = DB::select(DB::raw($sp_id));

    $idcount=array();
    foreach ($spID as $sp) {
        $spId = $sp->supervisor_id;

        // get count of students
        $stNum = "SELECT count(supervisions.student_id) AS numOfStudents, supervisors.user_id FROM supervisions INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id WHERE supervisions.supervisor_id=$spId";
        $num_of_students = DB::select(DB::raw($stNum));

        foreach($num_of_students as $val){
           // $vals=$val->user_id;
             $idcount[$val->user_id]=$val->numOfStudents;

        }
       
    }

	$app->render('hod/students/view_assigned_students.php',[
		'supervisions' => $supervisions,
		'unassignedStudents' => $unassignedStudents,
		'supervisors' => $supervisors,
		'val' => $idcount
	]);

})->name('hod.view_assigned_students');

$app->post('/hod/students/view_assigned_students', $hod(), function() use($app){
	
})->name('hod.view_assigned_students.post');