<?php

// Este archivo se "invocará" desde el index(Dashboard) por lo tanto
// ya no es necesario session_start()

// 1. ¿Cuá es nuestro nivel de acceso? - Revise controlador
$permiso = $_SESSION['login']['nivelacceso'];

//2. Cada PERFIL tendrá disponible angunas opciones

$opciones = [];

switch($permiso){
  case "ADM":
    $opciones = [
      ["menu" => "Clientes", "url" => "index.php?view=clientes.php"],
      ["menu" => "Ventas",   "url" => "index.php?view=ventas.php"],
      ["menu" => "Compras",  "url" => "index.php?view=compras.php"],
      ["menu" => "Reportes", "url" => "index.php?view=reportes.php"],
      ["menu" => "Usuarios", "url" => "index.php?view=usuarios.php"]
    ];
  break;
  case "SPV":
    $opciones = [
      ["menu" => "Clientes", "url" => "index.php?view=clientes.php"],
      ["menu" => "Ventas",   "url" => "index.php?view=ventas.php"],
      ["menu" => "Reportes", "url" => "index.php?view=reportes.php"]
    ];
  break;
  case "AST":
    $opciones = [
      ["menu" => "Clientes", "url" => "index.php?view=clientes.php"],
      ["menu" => "Ventas",   "url" => "index.php?view=ventas.php"]
    ];
  break;
}

//3. Ahora renderizamos en la vista(SIDEBAR) las opciones que
// corresponde a cada perfil

foreach($opciones as $item){
  echo "
  <li class='nav-item'>
    <a href='{$item['url']}' class='nav-link'>
        <i class='fas fa-fw fa-chart-area'></i>
          <span>
            {$item['menu']}
          </span>
    </a>
  </li>  
  ";
}

?>