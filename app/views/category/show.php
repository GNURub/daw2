<?php require VIEWS . '_layout/header.php' ?>

<div class="content index">
  <div class="menu-container">
    <div class="title-container">
      <h4>Categorias</h4>
    </div>
    <menu>
      <ul>
        <?php foreach ($subcategories as $subcat): ?>
          <li>
            <a href="/category/<?=$selectedCategory ?>/<?=$subcat['idsubcategoria'] ?>" class="capitalize">
              <?=$subcat['idsubcategoria'] ?>
            </a>
          </li>
        <?php endforeach; ?>
        <li>
          <a href="/home/multimedia">
            Multimedia
          </a>
        </li>
      </ul>
    </menu>
  </div>
  <div class="main-container">
    <div class="title-container">
      <h4>Productos</h4>
    </div>
    <div class="items-container">
      <?php
      $imAdmin = self::getSession('admin') && self::getSession('username') ? "admin" : null;
      foreach ($productos as $producto) {
        $new = isNew($producto);
        echo "<x-item {$imAdmin} {$new} url='/images/{$producto['path']}' num='{$producto['idproducto']}' label='{$producto['titulo']}' descripcion='{$producto['descripcion']}'></x-item>";
      }
      ?>
    </div>
  </div>
</div>
<?php require VIEWS . '_layout/footer.php' ?>
