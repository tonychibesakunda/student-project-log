<?php
use Logbook\User\User;
use Logbook\User\UserPermission;
use Logbook\User\Location;

use Illuminate\Database\Capsule\Manager as DB;
$app->get('/hod/coordinators/view_coordinator', $hod(), function() use($app){

    //get coordinator details
	$coordinators = DB::table('users')
            ->select(
            	'users.id',
                'users.username',
                'users.email',
                'users.active',
                'users_permissions.is_coordinator'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where(['users_permissions.is_coordinator' => true])
            ->get();

	$app->render('hod/coordinators/view_coordinator.php',[
		'coordinators' => $coordinators
	]);

})->name('hod.view_coordinator');

$app->post('/hod/coordinators/view_coordinator/:id', $hod(), function($id) use($app){
    if(isset($_POST['delete'])){
        //delete records
        User::where('id', $id)->delete();
        UserPermission::where('user_id', $id)->delete();
        Location::where('user_id', $id)->delete();

        //flash message and redirect
        $app->flash('success', "Project coordinator record has been successfully deleted.");
        return $app->response->redirect($app->urlFor('hod.view_coordinator'));
    }	
})->name('hod.view_coordinator.post');
