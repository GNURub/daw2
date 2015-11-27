<?php require VIEWS . '_layout/header.php'; ?>
<div class="content">
  <h2 class="center">Formulario de Categoría</h2>
  <form class="signin center" method="post">
    <ul>
      <li>
        <div class="group">
          <input type="text" class="capitalize" name="nombre" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Titulo de la categoria:</label>
        </div>
      </li>

      <li>
        <button class="btn lg" type="submit"><span>Crear Categoría</span></button>
      </li>
    </ul>
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
