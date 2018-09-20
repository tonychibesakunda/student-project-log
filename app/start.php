<?php
/* 

	##### This file Bootstraps the application to use the slim framework	#####

*/
use Slim\Slim;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Noodlehaus\Config;
use RandomLib\Factory as RandomLib;


use Logbook\User\User;
use Logbook\User\School;
use Logbook\Mail\Mailer; 
use Logbook\Helpers\Hash;
use Logbook\Validation\Validator;


use Logbook\Middleware\BeforeMiddleware;
use Logbook\Middleware\CsrfMiddleware;

session_cache_limiter(false);
session_start();

//display errors
ini_set('display_errors', 'On');

//define include root
define('INC_ROOT', dirname(__DIR__));

//require all project dependencies
require INC_ROOT.'/vendor/autoload.php';

//variable to save entire application
$app = new Slim([
	'mode' => file_get_contents(INC_ROOT.'/mode.php'),
	'view' => new Twig(),
	'templates.path' => INC_ROOT.'/app/views'
]);

//attach middleware to application
$app->add(new BeforeMiddleware);
$app->add(new CsrfMiddleware);

//pull configuration settings
$app->configureMode($app->config('mode'), function() use($app){
	$app->config = Config::load(INC_ROOT."/app/config/{$app->mode}.php");
});

//Connect to database using eloquent
require 'database.php';

//include filters
require 'filters.php';

//Connect to routes
require 'routes.php';

//adding auth to the container
$app->auth = false;

//attach user model into slim container
$app->container->set('user', function() use($app){
	return new User;
});

$app->container->set('school', function() use($app){
	return new School;
});

//add hash class to app
$app->container->singleton('hash', function() use($app){
	return new Hash($app->config);
});

//add validator class to app
$app->container->singleton('validation', function() use ($app){
	return new Validator($app->user, $app->hash, $app->auth);
});

//add php mailer to container
$app->container->singleton('mail', function() use($app){
	$mailer = new PHPMailer;

	

	$mailer->isSMTP();

	$mailer->Host = $app->config->get('mail.host');
	$mailer->SMTPAuth = $app->config->get('mail.smtp_auth');
	$mailer->SMTPSecure = $app->config->get('mail.smtp_secure');
	$mailer->Port = $app->config->get('mail.port');
	$mailer->Username = $app->config->get('mail.username');
	$mailer->Password = $app->config->get('mail.password');

	$mailer->isHTML($app->config->get('mail.html'));
	$mailer->clearAllRecipients();
	$mailer->clearAddresses();
	$mailer->clearAttachments();
	//$mailer->clearAllRecipients();
	//$mailer->clearAddresses();
	//$mailer->clearAttachments();


	// Return mailer object
	return new Mailer($app->view, $mailer);
});

$app->container->singleton('randomlib', function(){
	$factory = new RandomLib;
	return $factory->getMediumStrengthGenerator();
});

//configure views
$view = $app->view();

$view->parserOptions = [
	'debug' => $app->config->get('twig.debug')
];

//generate urls within our views
$view->parserExtensions = [
	new TwigExtension 
];

