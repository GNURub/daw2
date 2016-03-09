<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <h2 class="center">Formulario de Subcategoría</h2>
  <form class="signin center" method="post">
    <ul style="border:0">
      <li>
        <div class="group">
          <input type="text" class="capitalize" name="nombre" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Titulo de la subcategoria:</label>
        </div>
      </li>

      <li>
        <button class="btn lg" type="submit"><span>Crear subcategoría</span></button>
      </li>
    </ul>
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
