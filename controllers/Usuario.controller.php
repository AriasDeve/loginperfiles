<?php
//Iniciamos/heredamos la sesión
session_start();

//La sesión contendrá datos del login en formato de arreglo
$_SESSION["login"] = [];

require_once '../models/Usuario.php';
require_once '../models/Mail.php';

if (isset($_POST['operacion'])){

  $usuario = new Usuario();

  if ($_POST['operacion'] == 'login'){
    //Buscamos al usuario a través de su nombre
    $datoObtenido = $usuario->login($_POST['usuario']);
    //Arreglo que contiene datos de login
    $resultado = [
      "status"        => false,
      "apellidos"     => "",
      "nombres"       => "",
      "nivelacceso"   => "",
      "mensaje"       => ""
    ];
    
    if ($datoObtenido){
      //Encontramos el registro
      $claveEncriptada = $datoObtenido['claveacceso'];
      if (password_verify($_POST['claveIngresada'], $claveEncriptada)){
        //Clave correcta
        $resultado["status"] = true;
        $resultado["apellidos"] = $datoObtenido["apellidos"];
        $resultado["nombres"] = $datoObtenido["nombres"];
        $resultado["nivelacceso"] = $datoObtenido["nivelacceso"];
      }else{
        //Clave incorrecta
        $resultado["mensaje"] = "Contraseña incorrecta";
      }
    }else{
      //Usuario no encontrado
      $resultado["mensaje"] = "No se encuentra el usuario";
    }

    //Actualizando la información en la variable de sesión
    $_SESSION["login"] = $resultado;
    
    //Enviando información de la sesión a la vista
    echo json_encode($resultado);
  }

  if($_POST ['operacion'] == 'searchUser'){
    $datoObtenido = $usuario->searchUser($_POST['user']);
    if($datoObtenido){
      echo json_encode($datoObtenido);
    }
  }

  if($_POST['operacion'] == 'enviarCorreo'){
    //VALIDAR QUE ESTE PROCESO ¡NO! SE EJECUTE SINO HASTA DESPUÉS 15MIN
    $respuesta = $usuario->validarTiempo(["idusuario" => $_POST['idusuario']]);

    $retornoDatos = ["mensaje" => "Ya se te envió una clave, revisa tu correo"];


    if($respuesta ["status"] == "GENERAR"){
      //Crear un valor aleatorio de 4 dígitos
      $valorAleatorio = random_int(1000,9999);

      //Cuerpo del mensaje a enviar por EMAIL
      $mensaje = "
        <h3> App SENATI </h3>
        <strong> Recuperación de cuenta </strong>
        <hr>
        <p> Estimado usuario, para recuperación el acceso, utilice la siguiente contraseña: </p>
        <h3> {$valorAleatorio}</h3>
      ";

      //Arreglo con datos a guardar en la tabla de recuperación
      $data = [
          "idusuario"     => $_POST['idusuario'],
          "email"         => $_POST['email'],
          "clavegenerada" => $valorAleatorio

      ];

      //Creando registro
      $usuario->registraRecuperacion($data);

      //Enviando correo
      enviarCorreo($_POST['email'],'Código de Restauración',$mensaje);
       $retornoDatos["mensaje"] = "Se ha generado y enviado la clave al email indicado";
    }
    //Enviado a la vista
    echo json_encode($retornoDatos);
    
  }

  if($_POST['operacion'] == 'validarClave'){
    $datos = [
      "idusuario"     => $_POST['idusuario'],
      "clavegenerada" => $_POST['clavegenerada'] //modal
    ];
    $resultado = $usuario->validarClave($datos);
    echo json_encode($resultado);
  }

  if ($_POST['operacion'] == 'actualizarClave'){
   
    $claveEncriptada = password_hash($_POST['claveacceso'],PASSWORD_BCRYPT);
    $idusuario = $_POST['idusuario'];
    $datos =[
      "idusuario"   => $idusuario,
      "claveacceso" => $claveEncriptada
    ];
    echo json_encode($usuario->actualizarClave($datos));
  }

}

if (isset($_GET['operacion']) == 'destroy'){
  session_destroy();
  session_unset();
  header("location:../");
}

?>