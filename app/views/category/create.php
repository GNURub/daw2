<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <h2 class="center">Formulario de Categoría</h2>
  <form class="signin center" method="post">
    <ul style="border:0">
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
          <select class="browser-default" name="subcategoria[]" multiple required>
            <option value="" disabled>Elige las subcategorias</option>
            <?php
              foreach ($subcategorias as $sub) {
                echo "<option value='{$sub["idsubcategoria"]}' class='capitalize'>{$sub["idsubcategoria"]}</option>";
              }
            ?>
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
