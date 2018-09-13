<?php
/*
*
*	CHANGES THE STATE OF THE APPLICATION BEFORE A REQUEST
*
*/

namespace Logbook\Middleware;

use Slim\Middleware;

class BeforeMiddleware extends Middleware{

	public function call(){
		
		//hook method runs before every request in the app
		$this->app->hook('slim.before', [$this, 'run']);

		//run next request
		$this->next->call();
	}

	public function run(){
		//check if user is authenticated and session is set

		if (isset($_SESSION[$this->app->config->get('auth.session')])) {

			//override the auth in start.php and pull user record into auth
			$this->app->auth = $this->app->user->where('id', $_SESSION[$this->app->config->get('auth.session')])->first();
		}

		$this->checkRememberMe();

		//sharing data with the views
		$this->app->view()->appendData([
			'auth' => $this->app->auth,
			'baseUrl' => $this->app->config->get('app.url') 
		]);
	}

	protected function checkRememberMe(){
		//check if cookie is available
		if($this->app->getCookie($this->app->config->get('auth.remember')) && !$this->app->auth){
			$data = $this->app->getCookie($this->app->config->get('auth.remember'));
			$credentials = explode('___', $data);
			
			//check if data isn't empty and credentials have two elements in them
			if(empty(trim($data)) || count($credentials) !== 2){
				$this->app->response->redirect($this->app->urlFor('home'));
			}else{
				$identifier = $credentials[0];
				$token = $this->app->hash->hash($credentials[1]);

				$user = $this->app->user->where('remember_identifier', $identifier)->first();

				if($user){
					//check hashed version of token matches that in the database
					if($this->app->hash->hashCheck($token, $user->remember_token)){
						//Log the user in
						$_SESSION[$this->app->config->get('auth.session')] = $user->id;
						$this->app->auth = $this->app->user->where('id', $user->id)->first();
					}else{
						//remove the remember credentials
						$user->removeRememberCredentials();
					}
				}
			}	
		}
	}
}