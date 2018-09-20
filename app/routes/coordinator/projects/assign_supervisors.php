<?php

use Logbook\User\UserPermission;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/projects/assign_supervisors', $coordinator(), function() use($app){

	//get student details
	$students = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names',
                'users.email',
                'users.active',
                'users_permissions.is_student'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where(['users_permissions.is_student' => true])
            ->get();

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

    //get unassigned supervisor details
	$unassignedSupervisors = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names',
                'users.email',
                'users.active',
                'users_permissions.is_supervisor',
                'users_permissions.is_assigned'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where([
            	'users_permissions.is_supervisor' => true,
            	'users_permissions.is_assigned' => false
            ])
            ->get();

	$app->render('coordinator/projects/assign_supervisors.php', [
		'students' => $students,
		'unassignedStudents' => $unassignedStudents,
		'supervisors' => $supervisors,
		'unassignedSupervisors' => $unassignedSupervisors
	]);

})->name('coordinator.assign_supervisors');

$app->post('/coordinator/projects/assign_supervisors', $coordinator(), function() use($app){

	//get student details
	$students = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names',
                'users.email',
                'users.active',
                'users_permissions.is_student'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where(['users_permissions.is_student' => true])
            ->get();

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

    //get unassigned supervisor details
	$unassignedSupervisors = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.other_names',
                'users.email',
                'users.active',
                'users_permissions.is_supervisor',
                'users_permissions.is_assigned'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where([
            	'users_permissions.is_supervisor' => true,
            	'users_permissions.is_assigned' => false
            ])
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

    $studentId = '';
    
    $supervisorId = '';
    

	if($v->passes()){



		//get student id
		$get_id = "SELECT students.student_id, users.* FROM students INNER JOIN users ON students.user_id=users.id WHERE user_id = '".$selectStudent."'";
		$student = DB::select(DB::raw($get_id));

        foreach ($student as $row) {
				$studentId = $row->student_id;
			}

        //get supervisor id
		$get_id2 = "SELECT supervisors.supervisor_id, users.* FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE user_id = '".$selectSupervisor."'";
		$supervisor = DB::select(DB::raw($get_id2));

        foreach ($supervisor as $row) {
				$supervisorId = $row->supervisor_id;
			}

        //check for existing supervisions
        $query2 = "SELECT * FROM supervisions WHERE student_id=$studentId AND supervisor_id=$supervisorId";
        $sp = DB::select(DB::raw($query2));

        if(count($sp) > 0){
            $app->flash('error', 'This supervision already exists.');
            return $app->response->redirect($app->urlFor('coordinator.assign_supervisors'));
        }

        //insert record into supervisions table
		DB::table('supervisions')
			->insert([
				'student_id' => $studentId,
				'supervisor_id' => $supervisorId
			]);

		//update the users_permissions table
		DB::table('users_permissions')
			->whereIn('user_id', [$selectStudent, $selectSupervisor])
			->update(['is_assigned' => true]);


        // Send email to student
        $app->mail->send('email/assigned/student.php', ['student' => $student, 'supervisor' => $supervisor], function($message) use($student){

            $studentEmail = '';
            foreach ($student as $row) {
                $studentEmail = $row->email;
            }
            $message->to($studentEmail);
            $message->subject('Supervisor Assigned.');
        });

        

        // Send email to supervisor
        $app->mail->send('email/assigned/supervisor.php', ['supervisor' => $supervisor, 'student' => $student], function($message) use($supervisor){

            $supervisorEmail = '';
            foreach ($supervisor as $row2) {
                $supervisorEmail = $row2->email;
            }
            $message->to($supervisorEmail);
            $message->subject('Student Assigned.');
        });

		//flash message and redirect
		$app->flash('success', 'Student has successfully been assigned a supervisor.');
		return $app->response->redirect($app->urlFor('coordinator.assign_supervisors'));


	}

	//pass errors into view and save previous type info
	$app->render('coordinator/projects/assign_supervisors.php', [
		'errors' => $v->errors(),
		'request' => $request,
		'students' => $students,
		'unassignedStudents' => $unassignedStudents,
		'supervisors' => $supervisors,
		'unassignedSupervisors' => $unassignedSupervisors
	]);

})->name('coordinator.assign_supervisors.post');