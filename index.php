<?php
// include Composer Autoload file
require 'vendor/autoload.php';

// Define some configuration for database
$database = [
    'host' => 'localhost',
    'name' => 'question_form',
    'user' => 'root',
    'pass' => '',
];


$app = new \RKA\Slim();

// Register a Repository to manage questions
$app->container->singleton('QuestionRepository', function ( $container ) {
    return new App\Repository\QuestionRepository();
});

// Register the default Controller 
$app->container->singleton('App\QuestionController', function ( $container ) {
    // Retrieve the required repository from the container and
    // inject it in the controller
    $repo = $container['QuestionRepository'];
    return new \App\Controller\QuestionController( $repo, \RKA\Slim::getInstance() );
});

// Register the ORM
$app->container->singleton('ORM', function ( $container ) use ( $database ) {
    $pdo = new PDO("mysql:host=". $database['host'] .";dbname=". $database['name'], $database['user'], $database['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return new Voodoo\VoodOrm($pdo);
});

$app->get('/form', 'App\QuestionController:index');
$app->get('/answers', 'App\QuestionController:answers');

$app->post('/submitForm', 'App\QuestionController:submitForm')
    ->name('submitForm');

$app->run();