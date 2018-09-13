<?php
/** Route for the home.php in views folder **/

$app->get('/', function() use ($app){
	$app->render('home.php');
})->name('home');
