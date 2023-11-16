<?php

$route->add('/', "GET", "HomeController:index");
$route->add('/404', 'GET', 'NotFoundController:index');
$route->init();
