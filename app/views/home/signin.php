<?php require VIEWS . '_layout/header.php'; ?>

<div class="content">
  <h2 class="center">Formulario de Login</h2>
  <div class="wrap">
    <form class="signin center" action="/client/signin/" method="post">
      <ul>
        <li>
          <div class="group">
            <input type="text" name="username" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Username/Email:</label>
          </div>
        </li>
        <li>
          <div class="group">
            <input type="password" name="password" autocomplete="off" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Contraseña:</label>
          </div>
        </li>
        <li>
          <small><a href="<?=URL.'home/lost';?>">Olvidé la contraseña</a></small>
        </li>
        <li>
          <button class="btn lg" type="submit"><span>Login</span></button>
        </li>
      </ul>
    </form>
  </div>
</div>

<?php require VIEWS . '_layout/footer.php'; ?>
