<?php

use App\Controller\Admin;
use App\Http\Response;

// ROTA ADMIN
$objRouter->get('/admin', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Home::getHome($request));
    }
]);
