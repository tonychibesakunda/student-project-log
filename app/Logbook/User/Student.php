<?php
/** STUDENT MODEL **/
//namespace the student model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for student model
class Student extends Eloquent{

	protected $table = 'students';

	protected $fillable = [
		'user_id',
		'student_cat_id',
		'project_id',
		'project_start_date',
		'project_end_date',
		'project_aims',
		'final_project_report'
	];

	public function projectObjectives(){
		return $this->hasMany('Logbook\User\ProjectObjective', 'student_id');
	}

	public function supervisions(){
		return $this->hasMany('Logbook\User\Supervision', 'student_id');
	}
}