<?php
  $isAdmin = (
    self::getSession('admin') &&
    self::getSession('username')
  );
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="57x57" href="<?=URL; ?>images/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=URL; ?>images/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=URL; ?>images/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=URL; ?>images/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=URL; ?>images/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=URL; ?>images/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=URL; ?>images/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=URL; ?>images/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=URL; ?>images/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=URL; ?>images/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URL; ?>images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=URL; ?>images/icons/favicon-96x96.png">
    <link rel="shortcut icon" href="<?=URL; ?>images/icons/favicon-16x16.png" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=URL; ?>images/icons/favicon-16x16.png">
    <link rel="manifest" href="<?=URL; ?>images/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=URL; ?>images/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#303F9F">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <title>TheCatLong...</title>

    <!-- Style Sheets  -->
    <link href="<?=URL; ?>css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/flick/jquery-ui.css">
    <script  src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script  src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- Libs -->

    <!-- // <script src="https://cdnjs.cloudflare.com/ajax/libs/webcomponentsjs/0.7.21/webcomponents.min.js" async></script> -->
    <!-- Web Components -->
    <link rel="import" href="<?=URL; ?>components/item.html">
    <link rel="import" href="<?=URL; ?>components/x-order.html">
    <link rel="import" href="<?=URL; ?>components/x-notification.html">
    <link rel="import" href="<?=URL; ?>components/social-buttons.html">
</head>
<body>
    <?php
      flash('msg');
     ?>
    <header class="cabecera">
        <nav class="utils">
          <div class="logotipo">
            <a href="/" >
              <span class="title pacifico">The Cat Long</span>
            </a>
          </div>
            <div class="buscador">
              <form id="search-form" enctype="multipart/form-data" method="GET" action="/">
                <i class="material-icons">search</i>
                <input type="search" id="buscador" name="q">
              </form>
            </div>
          <ul class="menu">
            <li></li>
            <li>
              <?php
                if (!self::getSession('username')) {
              ?>
                  <a href="/home/signup">Registro</a>
              <?php
                }else{
              ?>
                  <a href="/client/"><?=is_numeric(self::getSession('username')) ? "Perfil" : ucfirst(self::getSession('username'))?></a>
              <?php
                }
              ?>
            </li>
            <li style="position:relative;">
              <a href="javascript: void(0)" class="button-icon btn_dropdown"><i class="material-icons">more_vert</i></a>
              <?php
                if ($isAdmin) {
              ?>
                <div class="hidden dropdown_menu">
                  <ul >
                    <li>
                      <a href="/product/create">
                        Crear Producto.
                      </a>
                    </li>
                    <li>
                      <a href="/category/create">
                        Crear Categoria.
                      </a>
                    </li>
                    <li>
                      <a href="/subcategory/create">
                        Crear Subcategoria.
                      </a>
                    </li>
                    <li>
                      <a href="">
                        Adm.Acounts
                      </a>
                    </li>
                    <li>
                      <a href="/client/checkout">
                        Carrito
                      </a>
                    </li>
                  </ul>
                </div>
              <?php
              }else{
              ?>
              <div class="hidden dropdown_menu">
                <ul>
                  <li>
                    <a href="<?=self::getSession('username') ? '/client/checkout' : '/home/signin'?>" class="carrito">
                      <i class="material-icons">shopping_basket</i>
                      <small>
                        Tienes <?=self::getSession('productos') ? count(self::getSession('productos')) : 0 ?> productos.
                      </small>
                    </a>
                  </li>
                  <li class="btn-li">
                    <a class="btn lg green" href="<?=self::getSession('username') ? '/client/checkout' : '/home/signin'?>">Cerrar compra</a>
                  </li>
                </ul>
              </div>
              <?php } ?>

            </li>
            <li>
              <?php
                if (!self::getSession('username')) {
              ?>
                  <a href="/home/signin">Login</a>
              <?php
                }else{
              ?>
                  <a href="/home/logout">Logout</a>
              <?php
                }
              ?>
            </li>
          </ul>
        </nav>
        <nav class="submenu">
          <ul>
            <?php
              // categorias personalizadas o las de la bbdd
              $categories = (!isset($categories) || empty($categories)) ? CategoryModel::$categories : $categories;
              $subcategories = (!isset($subcategories) || empty($subcategories)) ? SubcategoryModel::$subcategories : $subcategories;
              foreach ($categories as $cat): ?>
              <li>
                <?php if (isset($selectedCategory) && $selectedCategory == $cat['idcategoria']){ ?>
                  <a href="/category/<?=$cat['idcategoria']?>" class="capitalize active"><?=$cat['idcategoria']?></a>
                <?php }else{ ?>
                  <a href="/category/<?=$cat['idcategoria']?>" class="capitalize"><?=$cat['idcategoria']?></a>
                <?php } ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </nav>
    </header>
    <div id="dialog-item" title="Editar Producto">
      <form id="dialog-form" name="dialogproduct" action="/product/update" enctype="multipart/form-data" method="POST">
        <div>
          <div class="group">
            <input type="text" name="titulo" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Título</label>
          </div>
          <div class="group">
            <input type="text" name="marca" class="capitalize" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Marca:</label>
          </div>
          <!-- <div class="group">
            <input type="text" name="stock" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Stock:</label>
          </div> -->
          <div class="group">
            <input type="text" name="precio" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Precio:</label>
          </div>
          <div class="group">
            <input type="text" name="gastoenvio" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Gastos de envío:</label>
          </div>
          <div class="group">
            <input type="text" name="descripcion" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Descripcion:</label>
          </div>
          <div class="group">
            <input type="file" style="opacity:0" accept="image/*;capture=camera" name="imagen" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Imagen:</label>
          </div>
        </div>
        <input name="id" id="id-product" type="hidden" value="" />
      </form>
    </div>
