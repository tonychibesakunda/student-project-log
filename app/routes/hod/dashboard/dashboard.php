<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/hod/dashboard', $hod(), function() use($app){

	// get the number of aasigned students
	$query = "SELECT COUNT(students.student_id) AS numOfAssignedStudents FROM `students` INNER JOIN supervisions ON students.student_id=supervisions.student_id WHERE students.student_id=supervisions.student_id";
	$num_of_assigned_students = DB::select(DB::raw($query));

	//get number of unassigned students
	$unassignedStudents = DB::table('users')
            ->select(
            	'users.id'
            )
            ->join(
                'users_permissions',
                'users.id','=','users_permissions.user_id'
            )
            ->where([
            	'users_permissions.is_student' => true,
            	'users_permissions.is_assigned' => false
            ])
            ->get()->count();

    // get projects in progress
	$query = "SELECT supervisions.supervision_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, projects.project_name, students.project_start_date, students.project_end_date, students.is_final_project_report_approved FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id LEFT JOIN projects ON students.project_id=projects.project_id LEFT JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id LEFT JOIN project_types ON projects.project_type_id=project_types.project_type_id WHERE students.is_final_project_report_approved IS NULL AND students.project_id IS NOT NULL";
	$projects = DB::select(DB::raw($query));

	// number of projects in progress
	$query2 = "SELECT COUNT(project_id) AS numOfProjectsInProgress FROM `students` WHERE is_final_project_report_approved IS NULL";
	$num_of_projects_in_progress = DB::select(DB::raw($query2));

	// number of completed projects
	$query3 = "SELECT COUNT(project_id) AS numOfCompletedProjects FROM `students` WHERE is_final_project_report_approved=1";
	$num_of_completed_projects = DB::select(DB::raw($query3));

	$app->render('/hod/dashboard/dashboard.php',[
		'num_of_assigned_students' => $num_of_assigned_students,
		'unassignedStudents' => $unassignedStudents,
		'projects' => $projects,
		'num_of_projects_in_progress' => $num_of_projects_in_progress,
		'num_of_completed_projects' => $num_of_completed_projects
	]);

})->name('hod.dashboard');