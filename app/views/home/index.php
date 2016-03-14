<?php require VIEWS . '_layout/header.php'; ?>

<!-- <div class="container">
    <h2>You are in the View: application/view/home/index.php (everything in the box comes from this file)</h2>
    <p>In a real application this could be the homepage.</p>
</div>
 -->

<div class="content index">
  <div class="menu-container animated bounceInLeft">
    <div class="title-container">
      <h4>Categorias</h4>
    </div>
    <menu>
      <ul>
        <?php foreach ($subcategories as $subcat): ?>
          <li>
            <a href="/subcategory/<?=$subcat['idsubcategoria'] ?>" class="capitalize">
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
      foreach ($productos as $i=>$producto) {
        $new = isNew($producto);
        echo "<x-item class='animated zoomIn' style='animation-delay: {$i}00ms;' {$imAdmin} {$new} url='/images/{$producto['path']}' num='{$producto['idproducto']}' label='{$producto['titulo']}' descripcion='{$producto['descripcion']}'></x-item>";
      }
      ?>
    </div>
  </div>
</div>
<script charset="utf-8" defer>
'use strict';
  window.onload = function(){

      document.querySelector("#search-form").addEventListener('submit', function(e){
        e.preventDefault();
        var query = document.querySelector('#buscador').value;
        document.querySelector('#buscador').value = '';
        query = !!query ? '?q=' + encodeURI(query) : '';
        window.fetch('/api/product/' + query).then(function(response){
          return response.json();
        }).then(function(e){
          if(e.length){
            var container = document.querySelector('.items-container');
            container.innerHTML = '';
            e.forEach(function(e, i){
              var item = `<x-item class='animated zoomIn' style='animation-delay: ${i}00ms;' url='${e.path}' num='${e.idproducto}' label='${e.titulo}' descripcion='${e.descripcion}'></x-item>`;
              container.innerHTML += item;
            })
          }
        })
      }, false);

  }
</script>
 <?php require VIEWS . '_layout/footer.php'; ?>
