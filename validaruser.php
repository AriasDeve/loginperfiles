<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="./prueba.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form action="" autocomplete="off">
          <h3>Validar datos de usuario</h3>
          <hr>
          <div class="mb-3">
            <label for="user" class="form-label">Escriba nombre de usuario:</label>
            <div class="input-group">
              <input type="text" class="form-control" id="user">
              <button class="btn btn-success" type="button" id="buscar">Buscar</button>
              <button class="btn btn-primary" type="reset">Reiniciar</button>
            </div>
          </div>
          <!-- Respuestas -->
          <div class="mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="datosuser" readonly="true">
              <label for="datosuser" class="form-label">Datos del usuario:</label>
            </div>
          </div>

          <div class="mb-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="email" readonly="true">
              <label for="email" class="form-label">Correo electrónico:</label>
            </div>
          </div>

          <div class="text-end">
            <button class="btn btn-outline-dark" type="button" id="enviar">Enviar mensaje de restauracion</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- Zona de modales -->
  <div class="modal fade" id="modal-validacion" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog        ">
      <div class="modal-content">
        <div class="modal-header bg-success text-light">
          <i class="fa-solid fa-key fa-sm" style="color: #ffffff;"></i>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form-group text-center" action="" autocomplete="off">
            <h4>INGRESAR CODIGO</h4>
            <label for="clave" class="form-label text-justify">
              Te enviamos un código a tu e-mail para que puedas restablecer tu contraseña.
              Si no lo encuentras revisa el Correo No Deseado.
            </label>
            <div class="form-group mt-3" id="keys">
              <input class="inputc" type="tel" id="key1" maxlength="1" onkeyup="onKeyUp(this, 'key2')" />
              <input class="inputc" type="tel" id="key2" maxlength="1" onkeyup="onKeyUp(this, 'key3')" />
              <input class="inputc" type="tel" id="key3" maxlength="1" onkeyup="onKeyUp(this, 'key4')" />
              <input class="inputc" type="tel" id="key4" maxlength="1" onkeyup="onKeyUp(this, 'comprobar')" />
            </div>
            <div class="form-group mt-3 d-none" id="keys-false">
              <input class="inputc" value="*" type="tel" id="key1" maxlength="1" disable="true"/>
              <input class="inputc" value="*" type="tel" id="key1" maxlength="1" disable="true"/>
              <input class="inputc" value="*" type="tel" id="key1" maxlength="1" disable="true"/>
              <input class="inputc" value="*" type="tel" id="key1" maxlength="1" disable="true"/>
            </div>
            <!-- <button onclick="validarClave()">Verificar código</button> -->
            <!-- <input type="number" maxlength="4" class="form-control" id="clave"> -->
            <div id="inputs-clave" class="d-none">
              <div class="md-3">
                <label for="clave1" class="form-label">Escribe tu  nueva contraseña:</label>
                <input type="password" class="form-control" id="clave1">
              </div>

              <div>
                <label for="clave2" class="form-label">Vuelva a ingresar su contraseña:</label>
                <input type="password" class="form-control" id="clave2">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-lg-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" id="comprobar">Comprobar</button>
          <button type="button" class="btn btn-sm btn-primary d-none" id="actualizar">Actualizar clave</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Fin zona de modales -->
  <script src="./prueba.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> 

<script>
  document.addEventListener("DOMContentLoaded",() =>{

    //Variable para almacenar IDUSUARIO
    let idusuario = -1;

    //Objeto para manipular al MODAL
     const modal = new bootstrap.Modal(document.querySelector("#modal-validacion"));

    function buscador(){
      let parametros = new URLSearchParams();
      parametros.set("operacion","searchUser")
      parametros.set("user",document.querySelector("#user").value)

      fetch(`./controllers/Usuario.controller.php`,{
        method:'POST',
        body:parametros

      })
        .then(respuesta => respuesta.text())
        .then(datos => {
          if(datos != ""){
            const registro = JSON.parse(datos)
            //Enviando datos a formulario
            idusuario = registro.idusuario;
            document.querySelector("#datosuser").value = `${registro.apellidos} ${registro.nombres}`;
            document.querySelector("#email").value = registro.email;
          }else{
            alert("Usuario no encontrado");
            idusuario = -1;
            document.querySelector("#datosuser").value = '';
            document.querySelector("#email").value = '';
          }
        });
    }

    function generarEnviarCodigo(){
      const parametros = new URLSearchParams()
      parametros.append("operacion","enviarCorreo");
      parametros.append("email",document.querySelector("#email").value);
      parametros.append("idusuario",idusuario);

      fetch('./controllers/Usuario.controller.php',{
        method: 'POST',
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datos => {
          console.log(datos);
          alert(datos.mensaje);
        });
    }

    function validarClave(){
      const parametros = new URLSearchParams();
      const key1 = document.getElementById("key1").value;
      const key2 = document.getElementById("key2").value;
      const key3 = document.getElementById("key3").value;
      const key4 = document.getElementById("key4").value;
      const enterCode = `${key1}${key2}${key3}${key4}`;
      parametros.append("operacion","validarClave");
      parametros.append("idusuario",idusuario);
      parametros.append("clavegenerada", enterCode);

      fetch(`./controllers/Usuario.controller.php`,{
        method: 'POST',
        body: parametros

      })
        .then(respuesta => respuesta.json())
        .then(datos => {
          console.log(datos);
          //Analizando los datos
          if(datos.status == "PERMITIDO"){
            document.querySelector("#inputs-clave").classList.remove("d-none");
            document.querySelector("#actualizar").classList.remove("d-none");
            document.querySelector("#keys").classList.add("d-none");
            document.querySelector("#keys-false").classList.remove("d-none");
            document.querySelector("#comprobar").classList.add("d-none");
          }else{
            alert("Clave incorrecta, revise su correo por favor");
          }
        });
    }

    function actualizarClave(){
      const clave1 = document.querySelector("#clave1").value;
      const clave2 = document.querySelector("#clave2").value;

      //Si ninguna caja esta vacia
      if(clave1 != "" && clave2 != ""){
        if(clave1 == clave2){
          const parametros = new URLSearchParams();
          parametros.append("operacion","actualizarClave");
          parametros.append("idusuario",idusuario);
          parametros.append("claveacceso", clave1);
          fetch(`./controllers/Usuario.controller.php`,{
            method: 'POST',
            body : parametros
          })
            .then(respuesta => respuesta.json())
            .then(datos => {
              alert("Se actualizó su clave.. vuelva a iniicar sesión");
              window.location.href = './index.php';
            });
         
        }
      }

    }
    //Evento nativo del MODAL....  "Al abrir el modal"
    modal._element.addEventListener("shown.bs.modal",()=>{
      document.querySelector("#key1").focus();
    });

     //Evento nativo del MODAL....  "Al cerrar el modal"
    modal._element.addEventListener("hidden.bs.modal",()=>{
      document.querySelector("#form-clave").reset();
    });

    //Evento click para abrir MODAL
    document.querySelector("#enviar").addEventListener("click",()=>{
      if(idusuario != -1){
        generarEnviarCodigo();
        modal.toggle();  
      }else{
        alert("Debe buscar el nombre de usuario");
        document.querySelector("#user").focus();
      }      
    });

    //Evento click para bóton
    document.querySelector("#buscar").addEventListener("click",buscador);
    document.querySelector("#comprobar").addEventListener("click", validarClave);
    document.querySelector("#actualizar").addEventListener("click", actualizarClave);

    //Evento keypress(ENTER) caja de texto
    document.querySelector("#user").addEventListener("keypress",(key) =>{
      if(key.keyCode == 13){
        buscador();
      }
    })

  })
</script>




</body>
</html>