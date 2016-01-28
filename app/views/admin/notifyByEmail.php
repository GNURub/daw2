<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <h2 class="center">Notificar promoción</h2>
  <form class="signin center" action="/admin/notify/" method="post">
    <ul>
      <li>
        <div class="group">
          <input type="text" name="title" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Título:</label>
        </div>
      </li>

      <li>
        <div class="group">
          <input type="text" name="detalles" class="capitalize" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Detalles:</label>
        </div>
      </li>
      <li>
        <input type="hidden" name="itemid" value="<?=$itemId?>">
      </li>
      <li>
        <button class="btn lg" type="submit"><span>Notificar</span></button>
      </li>
    </ul>
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
