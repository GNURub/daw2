<div class="content">
  <h2 class="center">Formulario de Registro</h2>
  <form class="signin center" action="/client/create/" method="post">
    <ul>
      <li>
        <div class="group">
          <input type="text" name="username" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Nombre de usuario:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="nombre" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Nombre:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="apellidos" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Apellidos:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="email" name="email" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Email:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="password" name="password" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Contraseña:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="password" name="con_password" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Confirmar Contraseña:</label>
        </div>
      </li>

      <li>
        <button class="btn lg" type="submit"><span>Registrarse</span></button>
      </li>
    </ul>
  </form>
</div>
<script>
  // (function(doc){
  //   doc.querySelector('form').addEventListener('submit', function(e){
  //     e.preventDefault();
  //     console.dir(e.target.action);
  //     var inputs = Array.from(doc.querySelectorAll('form input'));
  //     var url = '';
  //     for (input of inputs) {
  //       url += input.value + '/';
  //     }
  //     window.location.href = e.target.action + url;
  //   }, false);
  // })(document);
</script>
