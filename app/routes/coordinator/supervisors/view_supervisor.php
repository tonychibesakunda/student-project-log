<?php
use Logbook\User\User;
use Logbook\User\UserPermission;
use Logbook\User\Location;
use Logbook\User\Supervisor;


use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/supervisors/view_supervisor', $coordinator(), function() use($app){

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
                'users_permissions.is_student'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where(['users_permissions.is_supervisor' => true])
            ->get();

	$app->render('coordinator/supervisors/view_supervisor.php',[
		'supervisors' => $supervisors
	]);

})->name('coordinator.view_supervisor');

$app->post('/coordinator/supervisors/view_supervisor/:id', $coordinator(), function($id) use($app){
	if(isset($_POST['delete'])){
        //delete records
        User::where('id', $id)->delete();
        UserPermission::where('user_id', $id)->delete();
        Location::where('user_id', $id)->delete();
        Supervisor::where('user_id', $id)->delete();

        //flash message and redirect
        $app->flash('success', "Supervisor record has been successfully deleted.");
        return $app->response->redirect($app->urlFor('coordinator.view_supervisor'));
    }
})->name('coordinator.view_supervisor.post');