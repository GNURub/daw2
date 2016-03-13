<?php require VIEWS . '_layout/header.php'; ?>
<div class="content">
  <div class="wrapper profile card card-6">
    <header class="header-profile">
      <a class="avatar avatar-xlarge" href="javascript:void(0)">
        <img src="https://byuc.files.wordpress.com/2012/07/avat-2.jpg" alt="" />
        <span class="ring"></span>
      </a>
      <h1 class="header-username"><?=$userData['username']?></h1>
      <h2 class="header-sublime">
        <span class="realname">
          <?=html_entity_decode($userData['nombre']) .' '
         . html_entity_decode($userData['apellidos']) ?>
        </span>
        <span class="location">ibiza</span>
        <ul>
          <li></li>
          <li></li>
        </ul>
      </h2>
      <p class="header-bio">
        <?=html_entity_decode($userData['estado'])?>
      </p>
    </header>
    <section class="stream-container">
      <x-order username="<?=$userData['username']?>"></x-order>
    </section>
  </div>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
