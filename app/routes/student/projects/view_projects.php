<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/projects/view_projects', $student(), function() use($app){

	// get completed projects
	$query = "SELECT supervisions.supervision_id, (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, projects.project_name, students.project_start_date, students.project_end_date FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id LEFT JOIN projects ON students.project_id=projects.project_id LEFT JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id LEFT JOIN project_types ON projects.project_type_id=project_types.project_type_id WHERE students.is_final_project_report_approved=1";
	$projects = DB::select(DB::raw($query));

	$app->render('student/projects/view_projects.php',[
		'projects' => $projects
	]);

})->name('student.view_projects');

$app->post('/student/projects/view_projects', $student(), function() use($app){
	
})->name('student.view_projects.post');