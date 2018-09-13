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
		'is_completed',
		'file_attachements',
		'student_comments',
		'supervisor_comments'
	];


}