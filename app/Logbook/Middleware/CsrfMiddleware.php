<?php
/*
*
* HANDLES CROSS-SITE REQUEST FORGERY WHICH WE WILL USE ON EVERY FORM CREATED
*
*/

namespace Logbook\Middleware;

use Exception;
use Slim\Middleware; 

class CsrfMiddleware extends Middleware{

	protected $key;

	public function call(){
		$this->key = $this->app->config->get('csrf.key');

		$this->app->hook('slim.before', [$this, 'check']);

		$this->next->call();
	}

	public function check(){
		//set token in session
		if(!isset($_SESSION[$this->key])){
			$_SESSION[$this->key] = $this->app->hash->hash($this->app->randomlib->generateString(128));	
		}

		$token = $_SESSION[$this->key];

		//check if request method used is in a certain value
		if(in_array($this->app->request()->getMethod(), ['POST', 'PUT', 'DELETE'])){
			$submittedToken = $this->app->request()->post($this->key) ?: '';

			//check if tokens match
			if(!$this->app->hash->hashCheck($token, $submittedToken)){
				throw new Exception('CSRF token mismatch!');
			}

		}

		$this->app->view()->appendData([
			'csrf_key' => $this->key,
			'csrf_token' => $token
		]);
	}
}