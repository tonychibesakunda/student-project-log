<?php

use Illuminate\Database\Capsule\Manager as DB;

$app->get('/student/projects/view_project_details/:id', $student(), function($supervisionID) use($app){

	// get project details
	$query = "SELECT (SELECT users.first_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stFName, (SELECT users.other_names FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stONames, (SELECT users.last_name FROM students INNER JOIN users ON students.user_id=users.id WHERE students.student_id=supervisions.student_id) AS stLName, (SELECT projects.project_name FROM students INNER JOIN projects ON students.project_id=projects.project_id WHERE students.student_id=supervisions.student_id) AS projectName, (SELECT users.first_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suFName, (SELECT users.other_names FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suONames, (SELECT users.last_name FROM supervisors INNER JOIN users ON supervisors.user_id=users.id WHERE supervisors.supervisor_id=supervisions.supervisor_id) AS suLName, projects.project_name, projects.project_description, students.project_start_date, students.project_end_date, students.project_aims, students.student_id, project_categories.project_category, project_types.project_type, supervisions.supervision_id, students.final_project_report_file_path, students.final_project_report_file_name, students.final_project_report_new_file_name, students.is_final_project_report_approved, students.supervisor_comments FROM supervisions INNER JOIN students ON supervisions.student_id=students.student_id INNER JOIN supervisors ON supervisions.supervisor_id=supervisors.supervisor_id LEFT JOIN projects ON students.project_id=projects.project_id LEFT JOIN project_categories ON projects.project_cat_id=project_categories.project_cat_id LEFT JOIN project_types ON projects.project_type_id=project_types.project_type_id WHERE supervisions.supervision_id=$supervisionID";
	$project_details = DB::select(DB::raw($query));

	// get project tasks
	$query2 = "SELECT scheduled_meetings.scheduled_date, tasks.task_description, tasks.new_file_name, tasks.file_name FROM `supervisory_meetings` INNER JOIN scheduled_meetings ON supervisory_meetings.scheduled_meeting_id=scheduled_meetings.scheduled_meeting_id INNER JOIN tasks ON supervisory_meetings.supervisory_meeting_id=tasks.supervisory_meeting_id WHERE scheduled_meetings.supervision_id=$supervisionID";
	$tasks = DB::select(DB::raw($query2));

	$app->render('student/projects/view_project_details.php',[
		'project_details' => $project_details,
		'tasks' => $tasks
	]);

})->name('student.view_project_details');

$app->post('/student/projects/view_project_details', $student(), function() use($app){
	
})->name('student.view_project_details.post');