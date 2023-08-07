<?php
 

// # Importamos los controladores en las rutas 
include_once "./controllers/ListatesController.php";


// # -- De esta forma tomamos las partes de la URL para armar la acciones
$controller = $_GET['Controllers'];
$action = $_GET['action'];
$id = $_GET['id'];
 

$ctrlName = $controller . "Controller";
$ctrl = new $ctrlName;
$ctrl->{$action}();