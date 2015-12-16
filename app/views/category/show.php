<?php require VIEWS . '_layout/header.php' ?>

<div class="content">
  <div class="items-container">

    <?php
      foreach ($productos as $producto) {
        echo "<x-item num='{$producto['idproducto']}' label='{$producto['titulo']}' descripcion='{$producto['descripcion']}' url='/images/{$producto['path']}'></x-item>";
      }
    ?>
  </div>
</div>
<?php require VIEWS . '_layout/footer.php' ?>
