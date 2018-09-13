<?php
/** DEPARTMENT MODEL **/
//namespace the department model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for department model
class Department extends Eloquent{

	protected $table = 'departments';

	protected $fillable = [
		'department_name',
		'user_id',
		'school_id'
	];

	public function locations(){
		return $this->hasMany('Logbook\User\Location', 'department_id');
	}
}