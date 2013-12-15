<?php

use Aura\Router\Map;
use Aura\Router\DefinitionFactory;
use G4\Router\RouteFactory;

$attach = [
    '/' => [
        'routes' => [
            '' => [
                'path' => '?{:service}?/?{:id}?/?',
                'params' => [
                    'id' => '(\w+)',
                ],
                'values' => [
                    'service' => 'index',
                    'method'  => 'index', // not HTTP method, "translated" from REQUEST_METHOD
                    'id'      => 0,
                ],
                'is_match' => function(array $server, \ArrayObject $matches) {
                    if(isset($server['REQUEST_METHOD'])) {
                        if( $server['REQUEST_METHOD'] == 'GET' && empty($matches['id']) ){
                            $matches['method'] = 'index';
                        } else {
                            $matches['method'] = strtolower($server['REQUEST_METHOD']);
                        }
                    }
                    return true;
                },
                'path_override' => function(array $data = null){
                    $keys = ['service', 'id'];
                    foreach ($keys as $key){
                        if(isset($data[$key]) && !empty($data[$key])) {
                            $tmp[$key] = $data[$key];
                        }
                    }
                    return '/' . implode('/', array_filter($tmp));
                }
            ],
        ]
    ]
];

$router = new Map(new DefinitionFactory, new RouteFactory, $attach);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

return $router->match($path, $_SERVER);