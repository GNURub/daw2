<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
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
          <input type="text" name="nombre" class="capitalize" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Nombre:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="apellidos" class="capitalize" required>
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
    <social-buttons fb-url="<?=$fbUrl;?>" go-url="<?=$goUrl;?>"></social-buttons>

  </form>

</div>

<?php require VIEWS . '_layout/footer.php'; ?>
