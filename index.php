<?php

require_once __DIR__ . '/vendor/autoload.php';

use Phaker\Phaker;
use Phaker\Responder\Responder;
use Phaker\Request;

$route = require_once __DIR__ . '/router.php';

echo '<pre>';
var_dump($route->values);
die;


$faker = new Phaker();

$responder = new Responder;
$responder
    ->setUrl('profile')
    ->setMethod(Phaker::METHOD_GET)
    ->setResponseClass('Phaker\Response\Ok')
    ->setServiceClass('FooBar');

$faker->register($responder);

$controller = isset($_GET['c']) ? $_GET['c'] : '';

$request = new Request;
$request
    ->setMethod(Phaker::METHOD_GET)
    ->setUrl($controller);

$faker->parse($request);
