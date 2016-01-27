<?php require VIEWS . '_layout/header.php' ?>

<div class="content">
  <article class="wrapper">
    <div class="why-its-rad">
      <?php foreach ($gallery_imgs as $id => $img): ?>
        <?php if (isImageValid(PUBLICO. 'images_gallery'. DIRECTORY_SEPARATOR . $img)):
          $urlimg = URL.'images_gallery'.DIRECTORY_SEPARATOR.$img;
        ?>
          <section class="columns">
            <div class="column" class="lightbox">
              <a class="lightbox" href="#<?=$id?>">
                <img src="<?=$urlimg?>" alt="" />
              </a>
            </div>
            <div class="lightbox-target" id="<?=$id?>">
              <img src="<?=$urlimg?>"/>
              <a class="lightbox-close" href="#"></a>
            </div>
            <div class="column">
              <h3>Hola</h3>
              <p >
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              </p>
            </div>
          </section>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </article>
  <!-- <article class="full-img" >

  </article> -->


</div>
<?php require VIEWS . '_layout/footer.php' ?>
