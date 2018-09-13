<?php

namespace Logbook\Mail;

class Mailer{
	
	protected $view;

	protected $mailer;

	public function __construct($view, $mailer){
		
		$this->view = $view;
		$this->mailer = $mailer;
	}
	
	//send method
	public function send($template, $data, $callback){
		$message = new Message($this->mailer);

		//append data to the view
		$this->view->appendData($data);

		$message->body($this->view->render($template));//from the Message.php file

		call_user_func($callback, $message);

		$this->mailer->send();	
	}
}