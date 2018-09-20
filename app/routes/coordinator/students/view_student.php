<?php
use Logbook\User\User;
use Logbook\User\UserPermission;
use Logbook\User\Location;
use Logbook\User\Student;


use Illuminate\Database\Capsule\Manager as DB;

$app->get('/coordinator/students/view_student', $coordinator(), function() use($app){
	
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

	$app->render('coordinator/students/view_student.php',[
		'students' => $students
	]);

})->name('coordinator.view_student');

$app->post('/coordinator/students/view_student/:id', $coordinator(), function($id) use($app){
	if(isset($_POST['delete'])){
        //delete records
        User::where('id', $id)->delete();
        UserPermission::where('user_id', $id)->delete();
        Location::where('user_id', $id)->delete();
        Student::where('user_id', $id)->delete();

        //flash message and redirect
        $app->flash('success', "Student record has been successfully deleted.");
        return $app->response->redirect($app->urlFor('coordinator.view_student'));
    }	
})->name('coordinator.view_student.post');