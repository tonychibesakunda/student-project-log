<?php
/** SUPERVISORY MEETING MODEL **/
//namespace the supervisory meeting model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for supervisory meeting model
class SupervisoryMeeting extends Eloquent{

	protected $table = 'supervisory_meetings';

	protected $fillable = [
		'supervision_id',
		'date_of_meeting',
		'duration',
		'student_progress_comments',
		'is_completed'
	];

	public function tasks(){
		return $this->hasMany('Logbook\User\Task', 'supervisory_meeting_id');
	}
}