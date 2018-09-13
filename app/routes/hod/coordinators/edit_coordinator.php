<?php

use Logbook\User\User;
use Logbook\User\UserPermission;
use Logbook\User\Location;
use Logbook\User\School;
use Logbook\User\Department;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/hod/coordinators/edit_coordinator/:username', $hod(), function($username) use($app){


	$query = 'SELECT * FROM schools';
	$query2 = 'SELECT * FROM departments';
	$schools = DB::select(DB::raw($query));
	$departments = DB::select(DB::raw($query2));


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
            ->where(['users.username' => $username])
            ->first();
	//$user = $app->user->where('username', $username)->first();

	//if user doesn't exist show a 404 page not found
	if(!$user){
		$app->notFound();
	}

	$app->render('hod/coordinators/edit_coordinator.php',[
		'user' => $user,
		'schools' => $schools,
		'departments' => $departments
	]);

})->name('hod.edit_coordinator');

$app->post('/hod/coordinators/edit_coordinator', $hod(), function() use($app){
	if(isset($_POST['save'])){
		$query = 'SELECT * FROM schools';
		$query2 = 'SELECT * FROM departments';
		$schools = DB::select(DB::raw($query));
		$departments = DB::select(DB::raw($query2));


		$request = $app->request;

		//get user input
		$username = $request->post('user_name');
		$email = $request->post('email');
		$school = $request->post('selectSchool');
		$dept = $request->post('selectDept');

		//validate user input
		$v = $app->validation;

		$v->validate([
			'username' => [$username, 'required|alnumDash|max(150)|uniqueUsername'],
			'email' => [$email, 'required|email|uniqueEmail'],
			'selectSchool' => [$school, 'int'],
			'selectDept' => [$dept, 'int']
		]);

		if ($v->passes()){

			$get_id = "SELECT id FROM users WHERE username = '".$username."'";
			$user_id = DB::select(DB::raw($get_id)); //runs the sql query above
			
			$userId;
			foreach ($user_id as $row) {
				$userId = $row->id;
			}

			//update the user table and location table using their respective models
			User::where('id', '=', $userId)
				    ->update([
				        'username' => $username,
				        'email' => $email
				    ]);
			Location::where('user_id', '=', $userId)
						->update([
							'school_id' => $school,
							'department_id' => $dept
						]);

			
			
			$app->flash('success', "Project coordinator details have been successfully updated.");
			return $app->response->redirect($app->urlFor('hod.edit_coordinator', array('username' => $username)));
		}

		//pass errors into view and save previous type info
		$app->render('hod/coordinators/edit_coordinator.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'schools' => $schools,
			'departments' => $departments
		]);
	}
	
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('hod.view_coordinator'));
	}
})->name('hod.edit_coordinator.post');