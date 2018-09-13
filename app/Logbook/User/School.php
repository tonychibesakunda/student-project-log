<?php
/** SCHOOL MODEL **/
//namespace the school model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for school model
class School extends Eloquent{

	protected $table = 'schools';

	protected $fillable = [
		'school_name'
	];

	public function locations(){
		return $this->hasMany('Logbook\User\Location', 'school_id');
	}
	
	public function getSchoolId(){
		return $this->school_id;
	}

	public function getSchoolName(){
		return $this->school_name;
	}
}