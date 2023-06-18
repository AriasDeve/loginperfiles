<?php
session_start();
if (isset($_SESSION['login'])){
  if(isset($_SESSION['login']['status']) && $_SESSION['login']['status']){
    header('Location: ./views/');
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>

  <div class="container">
    <div class="row mt-3">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <h3>Inicio de sesión</h3>
        <p>Por favor complete la información solicitada</p>
        <form action="" autocomplete="off">
          <div class="mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="nombreusuario" placeholder="Nombre de usuario" autofocus>
              <label for="nombreusuario" class="form-label">Nombre de usuario</label>
            </div>
          </div>
          <div class="mb-3">
            <div class="form-floating">
              <input type="password" class="form-control" id="claveacceso" placeholder="Contraseña">
              <label for="claveacceso" class="form-label">Contraseña</label>
            </div>
          </div>
          <div class="d-grid gap-2">
            <button class="btn btn-success" type="button" id="iniciar">Iniciar sesión</button>
            <a class="btn btn-secondary" href="validaruser.php" id="olvide">Olvidé mi contraseña</a>
          </div>
        </form>    
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const botonIniciarSesion = document.querySelector("#iniciar");
      const textPassword = document.querySelector("#claveacceso");
      const textusuario = document.querySelector("#nombreusuario");

      function validarDatos(){
        const parametros = new URLSearchParams();
        parametros.append("operacion", "login")
        parametros.append("usuario", textusuario.value)
        parametros.append("claveIngresada", textPassword.value)

        fetch(`./controllers/Usuario.controller.php`, {
          method: 'POST',
          body: parametros
        })
          .then(respuesta => respuesta.json())
          .then(datos => {
            if (!datos.status){
              alert(datos.mensaje);
              usuario.focus();
            }else{
              window.location.href = './views/';
            }
          })
          .catch(error => {
            console.log(error);
          });
      }

      textPassword.addEventListener("keypress", (evt) => {
        if (evt.charCode == 13) validarDatos();
      });

      botonIniciarSesion.addEventListener("click", validarDatos);
    });
  </script>
  
</body>
</html>