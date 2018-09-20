<?php
/** USER PERMISSION MODEL **/
//namespace the user model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserPermission extends Eloquent{

	protected $table = 'users_permissions';

	protected $fillable = [
		'is_hod',
		'is_coordinator',
		'is_supervisor',
		'is_student',
		'is_assigned'
	];

	//methods when users are created

	public static $hodDefault = [
		'is_hod' => true,
		'is_coordinator' => false,
		'is_supervisor' => false,
		'is_student' => false,
		'is_assigned' => false
	];

	public static $coordinatorDefault = [
		'is_hod' => false,
		'is_coordinator' => true,
		'is_supervisor' => false,
		'is_student' => false,
		'is_assigned' => false
	];

	public static $supervisorDefault = [
		'is_hod' => false,
		'is_coordinator' => false,
		'is_supervisor' => true,
		'is_student' => false,
		'is_assigned' => false
	];

	public static $studentDefault = [
		'is_hod' => false,
		'is_coordinator' => false,
		'is_supervisor' => false,
		'is_student' => true,
		'is_assigned' => false
	];
}