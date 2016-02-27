<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <h2 class="center">Recuperación de contraseña</h2>
  <form class="signin center" method="post" action="/client/restore">
    <ul>
      <li>
        <div class="group">
          <input type="email" name="email" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Email:</label>
        </div>
      </li>
      <li>
        <button class="btn lg" type="submit"><span>Recordar</span></button>
      </li>
    </ul>
  </form>
</div>

<?php require VIEWS . '_layout/footer.php'; ?>
