<?php
/*
*
*	THIS FILE IS USED FOR VALIDATING UNIQUE EMAIL AND USERNAMES
*
*/

namespace Logbook\Validation;

use Violin\Violin;

use Logbook\User\User;
use Logbook\User\ProjectCategory;
use Logbook\Helpers\Hash;

class Validator extends Violin{

	protected $user;

	protected $hash;

	protected $auth; 

	//injecting user model into the constructor
	public function __construct(User $user, Hash $hash, $auth = null){

		$this->user = $user;
		$this->hash = $hash;
		$this->auth = $auth;

		$this->addFieldMessages([
			'email' => [
				'uniqueEmail' => 'That email is already in use.'
			],
			'username' => [
				'uniqueUsername' => 'That username is already in use.'
			],
			'first_name' => [
				'required' => 'First Name is required'
			],
			'last_name' => [
				'required' => 'Last Name is required'
			],
			'password_confirm' => [
				'required' => 'password confirmation is required'
			],
			'selectSchool' => [
				'int' => 'You need to select a school'
			],
			'selectDept' => [
				'int' => 'You need to select a department'
			],
			'project_category' => [
				'required' => 'project category is required',
				'int' => 'You need to select a project category'
			],
			'project_type' => [
				'required' => 'project type is required',
				'int' => 'You need to select a project type'
			],
			'selectStudent' => [
				'int' => 'You need to select a student'
			],
			'selectSupervisor' => [
				'int' => 'You need to select a supervisor'
			],
			'project_name' => [
				'required' => 'project name is required'
			],
			'project_description' => [
				'required' => 'project description is required'
			],
			'project_start_date' => [
				'required' => 'project start date is required'
			],
			'project_end_date' => [
				'required' => 'project end date is required'
			],
			'project_aim' => [
				'required' => 'project aim(s) is required'
			],
			'project_objective' => [
				'required' => 'project objective is required'
			],
			'scheduled_date' => [
				'required' => 'scheduled date is required'
			]
		]);

		$this->addRuleMessages([
			'matchesCurrentPassword' => 'That does not match your current password.'
		]);
	}

	//validate unique email using violin
	public function validate_uniqueEmail($value, $input, $args){
		$user = $this->user->where('email', $value);

		//ignore current email when updating if the same email is passed
		if($this->auth && $this->auth->email === $value){
			return true;
		}
		
		return ! (bool) $user->count();
	}

	//validate unique username using violin
	public function validate_uniqueUsername($value, $input, $args){
		$user = $this->user->where('username', $value);

		//ignore current username when updating if the same username is passed
		if($this->auth && $this->auth->username === $value){
			return true;
		}

		return ! (bool) $user->count();
	}

	//check existing password
	public function validate_matchesCurrentPassword($value, $input, $args){

		if($this->auth && $this->hash->passwordCheck($value, $this->auth->password)){
			return true;	
		}

		return false;
	}

}