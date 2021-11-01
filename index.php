<?php

require __DIR__ . '/includes/App.php';
use App\Http\Router;

// INICIA O ROUTER
$objRouter = new Router(URL);

// INCLUI AS ROTAS DE PÁGINAS
include __DIR__ . "/routes/pages.php";

// INCLUI AS ROTAS DE ADMIN
include __DIR__ . "/routes/admin.php";

// IMPRIME O RESPONSE DA ROTA
$objRouter->run()
          ->sendResponse();
