<?php
/** SUPERVISOR INTEREST MODEL **/
//namespace the supervisor interest model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for supervisor interest model
class SupervisorInterest extends Eloquent{

	protected $table = 'supervisor_interests';

	protected $fillable = [
		'supervisor_id',
		'interest'
	];


}