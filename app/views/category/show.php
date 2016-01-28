<?php require VIEWS . '_layout/header.php' ?>

<div class="content index">
  <div class="menu-container">
    <div class="title-container">
      <h4>Categorias</h4>
    </div>
    <menu>
      <ul>
        <li>
          <a href="#">
            Camiseta
          </a>
        </li>
        <li>
          <a href="#">
            Pantalones
          </a>
        </li>
        <li>
          <a href="#">
            Zapatillas
          </a>
        </li>
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

        echo "<x-item {$imAdmin}  url='/images/{$producto['path']}' num='{$producto['idproducto']}' label='{$producto['titulo']}' descripcion='{$producto['descripcion']}'></x-item>";
      }
      ?>
    </div>
  </div>
</div>
<?php require VIEWS . '_layout/footer.php' ?>
