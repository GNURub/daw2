<?php require VIEWS . '_layout/header.php'; ?>
<!-- <?php print_r($categorias); ?> -->
<div class="content form">
  <h2 class="center">Formulario de Producto</h2>
  <form class="signin center" method="post" enctype="multipart/form-data">
    <ul>

      <li>
        <div class="mdl-selectfield">
          <label>Categoria: </label>
          <select class="browser-default capitalize" name="categoria[]" multiple required>
            <option value="" disabled>Elige una categoría</option>
            <?php
              foreach ($categorias as $categoria) {
                echo "<option value='{$categoria["idcategoria"]}' class='capitalize'>{$categoria["idcategoria"]}</option>";
              }
            ?>
          </select>
        </div>
      </li>

      <li>
        <div class="mdl-selectfield">
          <label>Subcategoria: </label>
          <select class="browser-default capitalize" name="subcategoria" required>
            <option value="" disabled>Elige una subcategoría</option>
            <?php
              foreach ($subcategorias as $subcategoria) {
                echo "<option value='{$subcategoria["idsubcategoria"]}' class='capitalize'>{$subcategoria["idsubcategoria"]}</option>";
              }
            ?>
          </select>
        </div>
      </li>


      <li>
        <div class="group">
          <input type="text" name="titulo" class="capitalize" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Titulo del producto:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="marca" class="capitalize" required>
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
        <div class="group">
          <input type="file" style="opacity:0" accept="image/*;capture=camera" name="imagen" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Imagen:</label>
        </div>
      </li>

      <li>
        <button class="btn lg" type="submit"><span>Crear</span></button>
      </li>
    </ul>
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
