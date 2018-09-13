<?php
/** SUPERVISION MODEL **/
//namespace the supervision model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for supervision model
class Supervision extends Eloquent{

	protected $table = 'supervisions';

	protected $fillable = [
		'student_id',
		'supervisor_id'
	];

	public function scheduledMeetings(){
		return $this->hasMany('Logbook\User\ScheduledMeeting', 'supervision_id');
	}

	public function supervisoryMeetings(){
		return $this->hasMany('Logbook\User\SupervisoryMeeting', 'supervision_id');
	}
}