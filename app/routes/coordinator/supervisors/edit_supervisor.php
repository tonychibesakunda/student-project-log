<?php

use Logbook\User\User;
use Logbook\User\Location;

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/supervisors/edit_supervisor/:id', $coordinator(), function($userId) use($app){

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
                'users.first_name',
                'users.last_name',
                'users.other_names',
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

    //if user doesn't exist show a 404 page not found
	if(!$user){
		$app->notFound();
	}

	$app->render('coordinator/supervisors/edit_supervisor.php', [
		'user' => $user,
		'userInfo' => $userInfo,
		'schools' => $schools,
		'departments' => $departments
	]);

})->name('coordinator.edit_supervisor');

$app->post('/coordinator/supervisors/edit_supervisor/:id', $coordinator(), function($userId) use($app){

	if(isset($_POST['save'])){
		$query = 'SELECT * FROM schools';
		$query2 = 'SELECT * FROM departments';
		$query3 = "SELECT users.*, locations.user_id, locations.school_id, locations.department_id, schools.school_id, schools.school_name, departments.department_id, departments.department_name FROM users INNER JOIN locations ON users.id=locations.user_id INNER JOIN schools ON locations.school_id=schools.school_id INNER JOIN departments ON locations.department_id=departments.department_id WHERE id='$userId'";

		$schools = DB::select(DB::raw($query));
		$departments = DB::select(DB::raw($query2));
		$userInfo = DB::select(DB::raw($query3));


		$request = $app->request;

		//get user input
		$first_name = $request->post('first_name');
		$last_name = $request->post('last_name');
		$other_names = $request->post('other_names');
		$username = $request->post('user_name');
		$email = $request->post('email');
		$school = $request->post('selectSchool');
		$dept = $request->post('selectDept');

		//validate user input
		$v = $app->validation;

		$v->validate([
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
			Location::where('user_id', '=', $userId)
						->update([
							'school_id' => $school,
							'department_id' => $dept
						]);

			
			
			$app->flash('success', "Supervisor details have been successfully updated.");
			return $app->response->redirect($app->urlFor('coordinator.edit_supervisor', array('id' => $userId)));
		}

		//pass errors into view and save previous type info
		$app->render('coordinator/supervisors/edit_supervisor.php', [
			'errors' => $v->errors(),
			'request' => $request,
			'userInfo' => $userInfo,
			'schools' => $schools,
			'departments' => $departments
		]);
	}
	
	if(isset($_POST['back'])){
		return $app->response->redirect($app->urlFor('coordinator.view_supervisor'));
	}
	
})->name('coordinator.edit_supervisor.post');