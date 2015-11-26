<?php require VIEWS . '_layout/header.php'; ?>
<div class="content">
  <h2 class="center">Formulario de Producto</h2>
  <form class="signin center" method="post">
    <ul>
      <li>
        <div class="group">
          <input type="text" name="titulo" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Titulo del producto:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="marca" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Marca:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="precio" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Precio:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="gastoenvio" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Gastos de envío:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="descripcion" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Descripcion:</label>
        </div>
      </li>

      <li>
        <button class="btn lg" type="submit"><span>Crear</span></button>
      </li>
    </ul>
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
