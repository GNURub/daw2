<?php require VIEWS . '_layout/header.php' ?>
<div class="content">

  <div class="multimedia imagenes">
    <div id="accordion" style="width:100%">
    <?php

      foreach($dirs as $i => $dir){
        $path = !$i ? $dir : $dirs[0] . DIRECTORY_SEPARATOR . $dir;
        $gallery_imgs = scandir(PUBLICO . $path, 1);
        $cat = $dir == $dirs[0] ? 'índice' : $dir;
        echo "<h3>{$cat}</h3>";
        echo "<div>";
        foreach ($gallery_imgs as $id => $img){
          $url = PUBLICO . $path . DIRECTORY_SEPARATOR . $img;
          if(isImageValid($url)){
            $urlimg = URL.$path.DIRECTORY_SEPARATOR.$img;
            showImage($id, $urlimg);
          }
        }
        echo "</div>";

      }

      ?>
          <!-- </div> -->
    </div>
  </div>
</div>
<?php require VIEWS . '_layout/footer.php' ?>
