<?php
//rutas generales
define("SERVER", "localhost");
define("NAMEAPP", "aplicationRestaurantGuaye");
define("ROUTEAPP","http://".SERVER."/".NAMEAPP);

// RUTA RECURSOS
define("ROUTECSS",ROUTEAPP.'/assets/css');
define("ROUTEJS",ROUTEAPP.'/assets/js');
define("ROUTEFILES",'assets/img/blog/');
define("ROUTEIMG",'assets/img/');

//encabezado y pie
define('HEADER', 'view/templates/header.php');
define('FOOTER', 'view/templates/footer.php');
define("PANELS","view/templates/panels.php");
define("NAVIGATION","view/templates/navigation.php");

// RUTAS PARA BASE DE DATOS
define("SERVERDB", "localhost");
define("PORT", "3306");
define("NAMEDB", "guaye");
define("USER", "root");
define("PASSWORD", "");


//
define("ADMINISTRADOR",101);
define("MODERADOR",303);
define("CLIENTE",102);
