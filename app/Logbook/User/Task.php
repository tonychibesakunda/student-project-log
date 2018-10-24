<?php
/** TASK MODEL **/
//namespace the task model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for task model
class Task extends Eloquent{

	protected $table = 'tasks';

	protected $fillable = [
		'supervisory_meeting_id',
		'task_description',
		'sent_for_approval',
		'sent_for_completion',
		'is_approved',
		'is_completed',
		'file_path',
		'file_name',
		'new_file_name',
		'student_comments',
		'supervisor_approval_comments',
		'supervisor_completion_comments'
	];


}