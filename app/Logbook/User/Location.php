<?php
/** LOCATION MODEL **/
//namespace the location model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for location model
class Location extends Eloquent{

	protected $table = 'locations';

	protected $fillable = [
		'department_id',
		'school_id'
	];

	
}