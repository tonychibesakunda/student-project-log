<?php
/*
*
*	THIS IS USED TO HASH AND VERIFY PASSWORDS 
*
*/
namespace Logbook\Helpers;

class Hash{
	protected $config;

	public function __construct($config){
		$this->config = $config;
	}

	//method generates password hash
	public function password($password){
		return password_hash($password, $this->config->get('app.hash.algo'),['cost' => $this->config->get('app.hash.cost')]);
	}

	//method verifies passwords
	public function passwordCheck($password, $hash){
		return password_verify($password, $hash);
	}

	//method to hash strings
	public function hash($input){
		return hash('sha256', $input);
	}

	//verify that two hashers 
	public function hashCheck($known, $user){
		return hash_equals($known, $user);
	}
}