<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);

$routes = array(
  'home' => array(
    'controller' => 'Layers',
    'action' => 'index'
  ),
  'registreer' => array(
    'controller' => 'Layers',
    'action' => 'registreer'
  ),
  'nieuwwachtwoord' => array(
    'controller' => 'Layers',
    'action' => 'nieuwwachtwoord'
  ),
  'opdracht' => array(
    'controller' => 'Layers',
    'action' => 'opdracht'
  ),
  'opdrachten' => array(
    'controller' => 'Layers',
    'action' => 'opdrachten'
  ),
  'opdrachttoevoegen' => array(
    'controller' => 'Layers',
    'action' => 'opdrachttoevoegen'
  ),
  'profiel' => array(
    'controller' => 'Layers',
    'action' => 'profiel'
  ),
  'schoolagenda' => array(
    'controller' => 'Layers',
    'action' => 'schoolagenda'
  ),
  'schoolagendaToevoegen' => array(
    'controller' => 'Layers',
    'action' => 'schoolagendaToevoegen'
  ),
  'vaktoevoegen' => array(
    'controller' => 'Layers',
    'action' => 'vaktoevoegen'
  ),
  'logout' => array(
    'controller' => 'Layers',
    'action' => 'logout'
  )
);

if (empty($_GET['page'])) {
  $_GET['page'] = 'home';
}
if (empty($routes[$_GET['page']])) {
  header('Location: index.php');
  exit();
}

// basic .env file parsing
if (file_exists("../.env")) {
  $variables = parse_ini_file("../.env", true);
  foreach ($variables as $key => $value) {
    putenv("$key=$value");
  }
}

$route = $routes[$_GET['page']];
$controllerName = $route['controller'] . 'Controller';

require_once __DIR__ . '/controller/' . $controllerName . ".php";

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();
