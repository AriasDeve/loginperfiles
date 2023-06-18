<?php
//Contiene todos los accesos/restriciones pro cada usuario/vista
session_start();

//1. ¿Qué nivel de acceso tenemos? Niveles = ADM, SPV, AST
$perfil = $_SESSION['login']['nivelacceso'];

//2. Debemos identificar a qué vista estamos tratando de acceder (URL)
$url = $_SERVER['REQUEST_URI'];
$url_array = explode("/",$url);
$vistaActiva = $url_array[count($url_array)-1];  //Ejemplo: ventas.php

//3. Permisos de acuerdo al PERFIL
$permisos = [
  "ADM" => ["clientes.php","ventas.php","compras.php","reportes.php","usuarios.php"],
  "SPV" => ["clientes.php","ventas.php","reportes.php"],
  "AST" => ["clientes.php","ventas.php"]
];

//Bandera
$autorizado = false;

//4. Comprobar si la vista coincide con el perfil(nivel acceso)
$vistasPermitidas = $permisos[$perfil];

foreach($vistasPermitidas as $vista){
  if($vista == $vistaActiva){
    $autorizado = true;
  }
}

//5. Sino está autorizado, bloqueamos la carga de la vista
if(!$autorizado){
  echo "<h2>Acceso Restringido</h2>";
  exit();
}


?>