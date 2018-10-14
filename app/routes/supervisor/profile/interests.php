<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/supervisor/profile/interests', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get project categories 
	$query = "SELECT project_cat_id, project_category FROM project_categories";
	$project_categories = DB::select(DB::raw($query));

	$app->render('supervisor/profile/interests.php',[
		'project_categories' => $project_categories
	]);

})->name('supervisor.interests');

$app->post('/supervisor/profile/interests', $supervisor(), function() use($app){

	//supervisor details
	$user_id = $_SESSION[$app->config->get('auth.session')];
	$supervisor_id = '';

	//get supervisor id
	$get_id =  "SELECT supervisor_id FROM supervisors WHERE user_id=$user_id";
	$sid = DB::select(DB::raw($get_id));

	foreach ($sid as $row) {
		$supervisor_id = $row->supervisor_id;
	}

	//get project categories 
	$query = "SELECT project_cat_id, project_category FROM project_categories";
	$project_categories = DB::select(DB::raw($query));

	$request = $app->request;

	//get user input
	$supervisorInterests = $request->post('supervisorInterests');

	//validate user input
	$v = $app->validation;

	if(is_null($supervisorInterests)){
		//flash message and redirect
		$app->flash('error', 'You need to select an interest');
		return $app->response->redirect($app->urlFor('supervisor.interests'));
	}else{

		for($x = min($supervisorInterests); $x <= sizeof($supervisorInterests); $x++){

				//check if interest already exists
				$query2 = "SELECT * FROM supervisor_interests WHERE supervisor_id=$supervisor_id AND project_cat_id=$x";
				$checkSI = DB::select(DB::raw($query2));

				if(count($checkSI) > 0){
					//flash message and redirect
					$app->flash('error', 'Some interests have already been added');
					return $app->response->redirect($app->urlFor('supervisor.interests'));
				}elseif(count($checkSI) == 0){

					//insert records into table
					DB::table('supervisor_interests')
						->insert([
							'supervisor_id' => $supervisor_id,
							'project_cat_id' => $x
						]);
					//flash message and redirect
					$app->flash('success', 'Your interests have been successfully added');
					return $app->response->redirect($app->urlFor('supervisor.interests'));
				}

			}

		//get user input
		/*foreach ($supervisorInterests as $value) {

			$values = array($value);

			/*for($x = min($value); $x <= sizeof($value); $x++){

				//check if interest already exists
				$query2 = "SELECT * FROM supervisor_interests WHERE supervisor_id=$supervisor_id AND project_cat_id=$x";
				$checkSI = DB::select(DB::raw($query2));

				if(count($checkSI) > 0){
					//flash message and redirect
					$app->flash('error', 'Some interests have already been added');
					return $app->response->redirect($app->urlFor('supervisor.interests'));
				}elseif(count($checkSI) == 0){

					//insert records into table
					DB::table('supervisor_interests')
						->insert([
							'supervisor_id' => $supervisor_id,
							'project_cat_id' => $x
						]);
					//flash message and redirect
					$app->flash('success', 'Your interests have been successfully added');
					return $app->response->redirect($app->urlFor('supervisor.interests'));
				}

			}
			
			// print_r($values);
		}*/
		//print_r(min($supervisorInterests));

	}

	

	$app->render('supervisor/profile/interests.php',[
		'errors' => $v->errors(),
		'request' => $request,
		'project_categories' => $project_categories
	]);

})->name('supervisor.interests.post');