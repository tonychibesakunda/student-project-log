<?php
/** DATABASE CONNECTION USING ELOQUENT**/
use Illuminate\Database\Capsule\Manager as Capsule;
//use Illuminate\Support\Facades\DB as Facade;

$capsule = new Capsule;

//add database conncection from config file
$capsule->addConnection([
	'driver' => $app->config->get('db.driver'),
	'host' => $app->config->get('db.host'),
	'database' => $app->config->get('db.name'),
	'username' => $app->config->get('db.username'),
	'password' => $app->config->get('db.password'),
	'charset' => $app->config->get('db.charset'),
	'collation' => $app->config->get('db.collation'),
	'prefix' => $app->config->get('db.prefix'),
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
//boot eloquent
$capsule->bootEloquent();
