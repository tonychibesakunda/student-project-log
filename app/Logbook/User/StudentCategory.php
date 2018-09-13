<?php
/** STUDENT CATEGORY MODEL **/
//namespace the student category model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for student category model
class StudentCategory extends Eloquent{

	protected $table = 'student_categories';

	protected $fillable = [
		'student_type'
	];

	public function students(){
		return $this->hasMany('Logbook\User\Student', 'student_cat_id');
	}
}