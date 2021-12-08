<?php

require_once __DIR__. '/src/vendor/autoload.php' ;
use wishlist\modele\Item;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$c = new \Slim\Container(["settings"=>[
    "displayErrorDetails" => true]]);
$app = new \Slim\App($c);

$app->get('/hello/{name}[/]',function(Request $rq, Response $rs, array $args): Response{

    $name = $args['name'];
    $rs->getBody()->write("<h1>Hello world, $name</h1>");
    return $rs;
    }
);


$app->run();


