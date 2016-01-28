<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
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
        <div class="mdl-selectfield">
          <label>Seleccione las Subcategorias: </label>
          <select class="browser-default" name="subcategoria[]" multiple>
            <option value="" disabled selected>Elige las subcategorias</option>
            <!-- <?php
              foreach ($categorias as $categoria) {
                echo "<option value='{$categoria["idcategoria"]}' class='capitalize'>{$categoria["idcategoria"]}</option>";
              }
            ?> -->
          </select>
        </div>
      </li>

      <li>
        <button class="btn lg" type="submit"><span>Crear Categoría</span></button>
      </li>
    </ul>
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
