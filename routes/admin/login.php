<?php

use App\Controller\Admin;
use App\Http\Response;

// ROTA DE LOGIN
$objRouter->get('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

// ROTA DE LOGIN (POST)
$objRouter->post('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::insertLogin($request));
    }
]);

// ROTA DE LOGOUT
$objRouter->get('/admin/logout', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogout($request));
    }
]);
