<?php
/** USER MODEL **/
//namespace the user model
namespace Logbook\User;

use Illuminate\Database\Eloquent\Model as Eloquent;

//class for user model
class User extends Eloquent{
	//set table name
	protected $table = 'users';

	//define fillable fields to be updated
	protected $fillable = [
		'username',
		'first_name',
		'last_name',
		'other_names',
		'email',
		'password',
		'role_id',
		'location_id',
		'photo',
		'active',
		'active_hash',
		'recover_hash',
		'remember_identifier',
		'remember_token',
	];

	//method to get full name
	public function getFullName(){

		if(!$this->first_name || !$this->last_name){
			return null;
		}

		return "{$this->first_name} {$this->other_names} {$this->last_name}";
	}

	//get username if full name is unavailable
	public function getFullNameOrUsername(){
		return $this->getFullName() ?: $this->username;
	}

	//method for activating user accounts
	public function activateAccount(){
		$this->update([
			'active' => true,
			'active_hash' => null
		]);
	}

	public function updateRememberCredentials($identifier, $token){
		$this->update([
			'remember_identifier' => $identifier,
			'remember_token' => $token
		]);
	}

	public function removeRememberCredentials(){
		$this->updateRememberCredentials(NULL, NULL);		
	}

	//check for permissions
	public function hasPermission($permission){
		return (bool) $this->permissions->{$permission};
	}

	//convinient helper methods to check permissions
	public function isHod(){
		return $this->hasPermission('is_hod');
	}

	public function isCoordinator(){
		return $this->hasPermission('is_coordinator');
	}

	public function isSupervisor(){
		return $this->hasPermission('is_supervisor');
	}

	public function isStudent(){
		return $this->hasPermission('is_student');
	}

	//relate users model to users permissions model
	public function permissions(){
		return $this->hasOne('Logbook\User\UserPermission', 'user_id');
	}

	//relate users model to students model
	public function students(){
		return $this->hasOne('Logbook\User\Student', 'user_id');
	}

	//relate users model to supervisors model
	public function supervisors(){
		return $this->hasOne('Logbook\User\Supervisor', 'user_id');
	}

	public function locations(){
		return $this->hasMany('Logbook\User\Location', 'user_id');
	}

}