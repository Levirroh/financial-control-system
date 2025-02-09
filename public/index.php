<?php

require_once "../src/App/Core/Core.php";
require_once "../src/App/Connection/Connection.php";


require_once "../src/App/Controller/HomeController.php";
require_once "../src/App/Controller/AuthController.php";
require_once "../src/App/Controller/ErrorController.php";

require_once '../vendor/autoload.php';

require_once "../src/App/Router/Router.php";

$template = file_get_contents('../src/App/Template/template.html');

ob_start(); 
    $core = new Core;
    $core->start($_GET);

    $saida = ob_get_contents();

ob_end_clean();

$page = str_replace('{{template}}', $saida, $template);
// se ele encontrar a string (1), quero que substitua o valor dela por (2), quando o assunto for template (3)
echo $page; 