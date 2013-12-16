<?php

require_once __DIR__ . '/vendor/autoload.php';

use Phaker\Phaker;
use Phaker\Responder\Responder;
use Phaker\Request;

$options = require_once __DIR__ . '/router.php';

$faker = new Phaker();

$responder = new Responder;
$responder
    ->setUrl('profile')
    ->setMethod(Phaker::METHOD_INDEX)
    ->setResponseClass('Phaker\Response\Ok')
    ->setServiceClass('Demo\Profile\Index');

$faker->register($responder);

$responder = new Responder;
$responder
    ->setUrl('profile')
    ->setMethod(Phaker::METHOD_GET)
    ->setResponseClass('Phaker\Response\Ok')
    ->setServiceClass('Demo\Profile\Get');

$faker->register($responder);

$request = new Request;
$request
    ->setUrl($options['url'])
    ->setMethod($options['method']);

$faker->parse($request);
