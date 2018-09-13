<?php
/** PROJECT OBJECTIVE MODEL **/
//namespace the project objective model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for project objective model
class ProjectObjective extends Eloquent{

	protected $table = 'project_objectives';

	protected $fillable = [
		'student_id',
		'project_objective',
		'is_completed'
	];


}