<?php require VIEWS . '_layout/header.php' ?>

<div class="content">
  <div class="multimedia imagenes">
    <?php foreach ($gallery_imgs as $id => $img): ?>
      <?php if (isImageValid(PUBLICO. 'images_gallery'. DIRECTORY_SEPARATOR . $img)):
        $urlimg = URL.'images_gallery'.DIRECTORY_SEPARATOR.$img;
      ?>
          <div class="lightbox card card-2">
            <a class="lightbox" href="#<?=$id?>">
              <img src="<?=$urlimg?>" alt="" />
            </a>
          </div>
          <div class="lightbox-target" id="<?=$id?>">
            <img src="<?=$urlimg?>"/>
            <a class="lightbox-close" href="#"></a>
          </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>
<?php require VIEWS . '_layout/footer.php' ?>
