<?php require VIEWS . '_layout/header.php' ?>

<div class="content">
  <div class="multimedia imagenes">
    <?php

      foreach($dirs as $i => $dir){
        $path = !$i ? $dir : $dirs[0] . DIRECTORY_SEPARATOR . $dir;
        $gallery_imgs = scandir(PUBLICO . $path, 1);
        
        foreach ($gallery_imgs as $id => $img){
          $url = PUBLICO . $path . DIRECTORY_SEPARATOR . $img;
          if(isImageValid($url)){
            $urlimg = URL.$path.DIRECTORY_SEPARATOR.$img;
            showImage($id, $urlimg);
          }
        }
      }

      ?>
  </div>
</div>
<?php require VIEWS . '_layout/footer.php' ?>
