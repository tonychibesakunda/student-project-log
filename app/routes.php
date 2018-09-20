<?php
/**
*
* THIS INCLUDES ALL THE ROUTES NEEDED
*
**/
require INC_ROOT.'/app/routes/home.php';

//Authentication Routes
require INC_ROOT.'/app/routes/auth/register.php';
require INC_ROOT.'/app/routes/auth/login.php';
require INC_ROOT.'/app/routes/auth/activate.php';
require INC_ROOT.'/app/routes/auth/logout.php';
require INC_ROOT.'/app/routes/auth/password/change.php';
require INC_ROOT.'/app/routes/auth/password/recover.php';
require INC_ROOT.'/app/routes/auth/password/reset.php';


//error routes
require INC_ROOT.'/app/routes/errors/404.php';


//User Routes
require INC_ROOT.'/app/routes/user/profile.php';
require INC_ROOT.'/app/routes/user/all.php';

require INC_ROOT.'/app/routes/account/profile.php';


/** Coordinator Routes **/
// coordinator/students routes
require INC_ROOT.'/app/routes/coordinator/students/add_student.php';
require INC_ROOT.'/app/routes/coordinator/students/view_student.php';
require INC_ROOT.'/app/routes/coordinator/students/edit_student.php';

// coordinator/projects routes
require INC_ROOT.'/app/routes/coordinator/projects/view_projects.php';
require INC_ROOT.'/app/routes/coordinator/projects/add_project_category.php';
require INC_ROOT.'/app/routes/coordinator/projects/view_project_category.php';
require INC_ROOT.'/app/routes/coordinator/projects/edit_project_category.php';
require INC_ROOT.'/app/routes/coordinator/projects/add_project_type.php';
require INC_ROOT.'/app/routes/coordinator/projects/view_project_type.php';
require INC_ROOT.'/app/routes/coordinator/projects/edit_project_type.php';
require INC_ROOT.'/app/routes/coordinator/projects/assign_supervisors.php';
require INC_ROOT.'/app/routes/coordinator/projects/view_assigned_supervisors.php';
require INC_ROOT.'/app/routes/coordinator/projects/edit_assigned_supervisors.php';

// coordinator/dashboard route
require INC_ROOT.'/app/routes/coordinator/dashboard/dashboard.php';

// coordinator/supervisors route
require INC_ROOT.'/app/routes/coordinator/supervisors/add_supervisor.php';
require INC_ROOT.'/app/routes/coordinator/supervisors/view_supervisor.php';
require INC_ROOT.'/app/routes/coordinator/supervisors/edit_supervisor.php';


/** HOD Routes **/
// hod/dashboard route
require INC_ROOT.'/app/routes/hod/dashboard/dashboard.php';

// hod/coordinators route
require INC_ROOT.'/app/routes/hod/coordinators/add_coordinator.php';
require INC_ROOT.'/app/routes/hod/coordinators/view_coordinator.php';
require INC_ROOT.'/app/routes/hod/coordinators/edit_coordinator.php';

// hod/projects route
require INC_ROOT.'/app/routes/hod/projects/view_projects.php';

// hod/students route
require INC_ROOT.'/app/routes/hod/students/view_assigned_students.php';
require INC_ROOT.'/app/routes/hod/students/view_student_project.php';


/** Student Routes **/
// student/dashboard route
require INC_ROOT.'/app/routes/student/dashboard/dashboard.php';

// student/projects route
require INC_ROOT.'/app/routes/student/projects/view_projects.php';
require INC_ROOT.'/app/routes/student/projects/view_project_details.php';

// student/supervisors route
require INC_ROOT.'/app/routes/student/supervisors/view_supervisors.php';
require INC_ROOT.'/app/routes/student/supervisors/view_supervisor_details.php';

// student/myproject route
require INC_ROOT.'/app/routes/student/myproject/add_project.php';
require INC_ROOT.'/app/routes/student/myproject/edit_project.php';
require INC_ROOT.'/app/routes/student/myproject/existing_project.php';
require INC_ROOT.'/app/routes/student/myproject/add_on_existing_project.php';
require INC_ROOT.'/app/routes/student/myproject/view_project_details.php';
require INC_ROOT.'/app/routes/student/myproject/add_project_objective.php';

// student/schedules route
require INC_ROOT.'/app/routes/student/schedules/add_scheduled_meeting.php';
require INC_ROOT.'/app/routes/student/schedules/edit_scheduled_meeting.php';
require INC_ROOT.'/app/routes/student/schedules/view_scheduled_meetings.php';

// student/tasks route
require INC_ROOT.'/app/routes/student/tasks/add_task.php';
require INC_ROOT.'/app/routes/student/tasks/edit_task.php';
require INC_ROOT.'/app/routes/student/tasks/complete_task.php';
require INC_ROOT.'/app/routes/student/tasks/view_tasks.php';
require INC_ROOT.'/app/routes/student/tasks/add_supervisory_meeting.php';
require INC_ROOT.'/app/routes/student/tasks/edit_supervisory_meeting.php';
require INC_ROOT.'/app/routes/student/tasks/view_supervisory_meetings.php';


/** Supervisor Routes **/
// supervisor/dashboard route
require INC_ROOT.'/app/routes/supervisor/dashboard/dashboard.php';

// supervisor/profile route
require INC_ROOT.'/app/routes/supervisor/profile/interests.php';
require INC_ROOT.'/app/routes/supervisor/profile/student_expectations.php';

// supervisor/projects route
require INC_ROOT.'/app/routes/supervisor/projects/student_projects.php';
require INC_ROOT.'/app/routes/supervisor/projects/student_project_details.php';

// supervisor/schedules route
require INC_ROOT.'/app/routes/supervisor/schedules/scheduled_meetings.php';

// supervisor/studentTasks route
require INC_ROOT.'/app/routes/supervisor/studentTasks/student_tasks.php';
require INC_ROOT.'/app/routes/supervisor/studentTasks/confirm_task.php';
require INC_ROOT.'/app/routes/supervisor/studentTasks/review_task.php';
require INC_ROOT.'/app/routes/supervisor/studentTasks/approve_task_completion.php';
require INC_ROOT.'/app/routes/supervisor/studentTasks/review_task_completion.php';
