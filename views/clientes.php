<?php
require_once './permisos.php';

?>
<div class="row">
  <div class="col-md-12">
    <h2>CLIENTES</h2>
    <p>
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt ea, facilis voluptates dolore aliquam asperiores deleniti aut corporis laudantium nemo, minima pariatur officiis id beatae nam itaque eveniet culpa vitae.
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt ea, facilis voluptates dolore aliquam asperiores deleniti aut corporis laudantium nemo, minima pariatur officiis id beatae nam itaque eveniet culpa vitae.
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt ea, facilis voluptates dolore aliquam asperiores deleniti aut corporis laudantium nemo, minima pariatur officiis id beatae nam itaque eveniet culpa vitae.
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sunt ea, facilis voluptates dolore aliquam asperiores deleniti aut corporis laudantium nemo, minima pariatur officiis id beatae nam itaque eveniet culpa vitae.    
    </p>

   <button class="btn btn-primary" type="button" id="saludar">Saludar</button>
  </div>
</div>

<script>
  const boton = document.querySelector("#saludar");
  boton.addEventListener("click",() => {
    alert("Hola que hace")

  });
</script>