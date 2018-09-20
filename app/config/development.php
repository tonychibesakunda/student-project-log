<?php
/*
	###	CONFIGURATION SETTINGS FOR DEVELOPMENT	###
*/
return [
	/** application config **/
	'app' => [
		'url' => 'http://localhost',
		//password hashing config below 
		'hash' => [
			'algo' => PASSWORD_BCRYPT,
			'cost' => 10
		]
	],

	/** database config **/
	'db' => [
		'driver' => 'mysql',
		'host' => '127.0.0.1',
		'name' => 'spl_db',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix' => ''
	],

	/** authentication settings **/
	'auth' => [
		'session' => 'user_id',
		'remember' => 'user_r'
	],

	/** email settings **/
	'mail' => [
		'smtp_auth' => true,
		'smtp_secure' => 'tls',
		'host' => 'smtp.gmail.com',
		'username' => 'tonymchibesakunda@gmail.com',
		'password' => '210894Tc',
		'port' => 587,
		'html' => true
	],

	/** view or twig settings **/
	'twig' => [
		'debug' => true
	],

	/** cross-site request forgery settings **/
	'csrf' => [
		'key' => 'csrf_token'
	]

];