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
    <link rel="shortcut icon" href="<?=URL; ?>images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?=URL; ?>images/favicon.ico" type="image/x-icon">
    <title>TheCatLong...</title>
    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?=URL; ?>js/wc.js"></script>
    <link href="<?=URL; ?>css/all.css" rel="stylesheet">
    <link rel="import" href="<?=URL; ?>components/item.html">
</head>
<body>
    <header class="cabecera">
        <nav class="utils">
          <div class="logotipo">
            <a href="/" >
              <span class="title pacifico">The Cat Long</span>
            </a>
          </div>
          <div class="buscador">
            <i class="material-icons">search</i>
            <input type="search">
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
                  <a href="/client/">Perfil</a>
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
                  </ul>
                </div>
              <?php
              }else{
              ?>
              <div class="hidden dropdown_menu">
                <ul>
                  <li>
                    <a href="" class="carrito">
                      <i class="material-icons">shopping_basket</i>
                      <small>
                        Tienes <?=self::getSession('productos') ? count(self::getSession('productos')) : 0;?> productos.
                      </small>
                    </a>
                  </li>
                  <li class="btn-li">
                    <button class="btn lg">Cerrar compra</button>
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
            <?php foreach (CategoryModel::$categories as $cat): ?>
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
