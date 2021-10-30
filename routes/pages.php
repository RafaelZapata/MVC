<?php

use App\Controller\Pages;
use App\Http\Response;

// ROTA HOME
$objRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

// ROTA SOBRE
$objRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);

// ROTA DEPOIMENTOS
$objRouter->get('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);

// ROTA DEPOIMENTOS INSERT
$objRouter->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);

// ROTA DINÂMICA
// $objRouter->get('/pagina/{idPagina}', [
//     function ($idPagina) {
//         return new Response(200, 'Página' . $idPagina);
//     }
// ]);
