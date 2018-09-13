<?php
/** SCHEDULED MEETING MODEL **/
//namespace the scheduled model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for scheduled model
class ScheduledMeeting extends Eloquent{

	protected $table = 'scheduled_meetings';

	protected $fillable = [
		'supervision_id',
		'scheduled_date'
	];


}