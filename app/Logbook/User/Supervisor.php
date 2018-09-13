<?php
/** SUPERVISOR MODEL **/
//namespace the supervisor model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for supervisor model
class Supervisor extends Eloquent{

	protected $table = 'supervisors';

	protected $fillable = [
		'user_id'
	];

	public function supervisorInterests(){
		return $this->hasMany('Logbook\User\SupervisorInterest', 'supervisor_id');
	}

	public function supervisions(){
		return $this->hasMany('Logbook\User\Supervision', 'supervisor_id');
	}
}