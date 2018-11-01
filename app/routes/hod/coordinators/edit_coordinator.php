<?php

use Logbook\User\User;
use Logbook\User\UserPermission;
use Logbook\User\Location;
use Logbook\User\School;
use Logbook\User\Department;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/hod/coordinators/edit_coordinator/:id', $hod(), function($userId) use($app){


	$query = 'SELECT * FROM schools';
	$query2 = 'SELECT * FROM departments';
	$query3 = "SELECT users.*, locations.user_id, locations.school_id, locations.department_id, schools.school_id, schools.school_name, departments.department_id, departments.department_name FROM users INNER JOIN locations ON users.id=locations.user_id INNER JOIN schools ON locations.school_id=schools.school_id INNER JOIN departments ON locations.department_id=departments.department_id WHERE id='$userId'";
	$schools = DB::select(DB::raw($query));
	$departments = DB::select(DB::raw($query2));
	$userInfo = DB::select(DB::raw($query3));

	//check if user exists
	$user = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.email',
                'locations.school_id',
                'locations.department_id'
            )
            ->join(
                'locations',
                'users.id','=','locations.user_id'
            )
            ->where(['users.id' => $userId])
            ->first();
	//$user = $app->user->where('username', $username)->first();

	//if user doesn't exist show a 404 page not found
	if(!$user){
		$app->notFound();
	}

	$app->render('hod/coordinators/edit_coordinator.php',[
		'user' => $user,
		'userInfo' => $userInfo,
		'schools' => $schools,
		'departments' => $departments
	]);

})->name('hod.edit_coordinator');

$app->post('/hod/coordinators/edit_coordinator/:id', $hod(), function($userId) use($app){
	if(isset($_POST['save'])){
		$query = 'SELECT * FROM schools';
		$query2 = 'SELECT * FROM departments';
		$query3 = "SELECT users.*, locations.user_id, locations.school_id, locations.department_id, schools.school_id, schools.school_name, departments.department_id, departments.department_name FROM users INNER JOIN locations ON users.id=locations.user_id INNER JOIN schools ON locations.school_id=schools.school_id INNER JOIN departments ON locations.department_id=departments.department_id WHERE id='$userId'";

		$schools = DB::select(DB::raw($query));
		$departments = DB::select(DB::raw($query2));
		$userInfo = DB::select(DB::raw($query3));

		
		$request = $app->request;

		//get user input
		$username = $request->post('user_name');
		$email = $request->post('email');
		$school = $request->post('selectSchool');
		$dept = $request->post('selectDept');
		$accountStatus = $request->post('accountStatus');

		//validate user input
		$v = $app->validation;

		$v->validate([
			'selectSchool' => [$school, 'int'],
			'selectDept' => [$dept, 'int']
		]);

		if ($v->passes()){

			$get_id = "SELECT id FROM users WHERE username = '".$username."'";
			$user_id = DB::select(DB::raw($get_id)); //runs the sql query above
			
			
			foreach ($user_id as $row) {
				$userId = $row->id;
			}

			if($accountStatus == 1){

				//update the user table and location table using their respective models
				Location::where('user_id', '=', $userId)
							->update([
								'school_id' => $school,
								'department_id' => $dept
							]);

				// update users table
				User::where('id', '=', $userId)
						->update([
							'active' => TRUE,
							'active_hash' => NULL
						]);
				
				$app->flash('success', "Project coordinator details have been successfully updated.");
				return $app->response->redirect($app->urlFor('hod.edit_coordinator', array('id' => $userId)));

			}elseif($accountStatus == 0){

				//update the user table and location table using their respective models
				Location::where('user_id', '=', $userId)
							->update([
								'school_id' => $school,
								'department_id' => $dept
							]);

				// update users table
				User::where('id', '=', $userId)
						->update([
							'active' => FALSE
						]);
				
				$app->flash('success', "Project coordinator details have been successfully updated.");
				return $app->response->redirect($app->urlFor('hod.edit_coordinator', array('id' => $userId)));
			}

			
		}

		//pass errors into view and save previous type info
		$app->render('hod/coordinators/edit_coordinator.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'userInfo' => $userInfo,
			'schools' => $schools,
			'departments' => $departments
		]);
	}
	
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('hod.view_coordinator'));
	}
})->name('hod.edit_coordinator.post');