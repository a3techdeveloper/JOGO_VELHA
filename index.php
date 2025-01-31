<?php

//inicializar sessão
session_start();

//definir constante
define('CONTROL', true);

//definir rotas
$route = $_GET['route'] ?? 'start';

$script = null;

switch ($route) {
    case 'start':
        $script = 'start.php';
        break;
    case 'game':
        $script = 'game.php';
        break;
    default:
        die('Acesso negado!');
}

//view
require "inc/header.php";
require "inc/$script";
require "inc/footer.php";
