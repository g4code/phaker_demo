<?php

use G4\Router\Map;
use G4\Router\DefinitionFactory;
use G4\Router\RouteFactory;

$attach = [
    '/' => [
        'routes' => [
            '' => [
                'path' => '?{:url}?/?{:id}?/?(.*)', // rest is ignored
                'params' => [
                    'id'    => '(\w+)',
                ],
                'values' => [
                    'url'    => 'index',
                    'method' => 'index', // not HTTP method, "translated" from REQUEST_METHOD
                    'id'     => 0,
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

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router = new Map(new DefinitionFactory, new RouteFactory, $attach);

$route = $router->match($path, $_SERVER);

return $route->values;