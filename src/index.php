<?php

$url = explode('/', $_SERVER['REQUEST_URI']);
$path = realpath("../controllers/" . $url[1] . "Controller.php");

if (empty($url[1])) {
    require realpath("../controllers/HomeController.php");
    $controller = new HomeController;
    $controller->index();
    die();
}

validateController($path, $url);

function validateController($path, $url)
{
    if($path) {
        require $path;
        $controller = $url[1] . "Controller";
        $controller = new $controller;
        executeMethod($controller, $url[2]);
    }
    pageNotFound();
}

function executeMethod($controller, $method)
{
    if (method_exists($controller, $method)) {
        $controller->$method();
        die();
    }
    pageNotFound();
}

function pageNotFound()
{
    http_response_code(404);
    print("De pagina waar je naar op zoekt is er helaas niet (meer)");
    die();
}