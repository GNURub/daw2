<?php require VIEWS . '_layout/header.php'; ?>

<!-- <div class="container">
    <h2>You are in the View: application/view/home/index.php (everything in the box comes from this file)</h2>
    <p>In a real application this could be the homepage.</p>
</div>
 -->

<div class="content">
  <?php
    foreach ($productos as $producto) {
      echo "<x-item label='{$producto['titulo']}' descripcion='{$producto['descripcion']}'></x-item>";
    }
  ?>
</div>
 <?php require VIEWS . '_layout/footer.php'; ?>
