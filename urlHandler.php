<?php

require_once __DIR__ . '/vendor/autoload.php';

ini_set('allow_url_fopen', 1);
switch (parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'index.php';
        break;
    case '/index':
        require 'index.php';
        break;
    case '/index.php':
        require 'index.php';
        break;

        //user
    case '/user_login.php':
        require 'user_login.php';
        break;
    case '/user/':
        require '/user/index.php';
        break;
    case '/user/submit_ticket.php':
        require '/user/submit_ticket.php';
        break;

        //staff
    case '/staff_login.php':
        require 'staff_login.php';
        break;

    default:
        http_response_code(404);
        echo parse_url($_SERVER['REQUEST_URI'])['path'];
        exit('Not Found');
}
?>