<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::prefix('admin', function (RouteBuilder $builder) {
   $builder->plugin('Sites', function (RouteBuilder $routes) {
       $routes->fallbacks('DashedRoute');
   });
});

