<?php

require __DIR__ . "/../vendor/autoload.php";

use App\Utils\View;
use WilliamCosta\DotEnv\Environment;
use App\Db\Database;
use App\Http\Middleware\Queue;

// CARREGA AS VARIÁVEIS DE AMBIENTE
Environment::load(__DIR__ . '/../');


//CONFIG DATABASE CLASS

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

// DEFINE A CONSTANTE DE URL DO PROJETO
define('URL', getenv('URL'));

// DEFINE O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL
]);

// DEFINE O MAPEAMENTO DE MIDDLEWARES
Queue::setMap([
    'maintenance' => App\Http\Middleware\Maintenance::class,
    'required-admin-logout' => App\Http\Middleware\RequireAdminLogout::class,
    'required-admin-login' => App\Http\Middleware\RequireAdminLogin::class
]);

// DEFINE O MAPEAMENTO DE MIDDLEWARES PADRÕES DE TODAS AS ROTAS
Queue::setDefault([
    'maintenance'
]);
