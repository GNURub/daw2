<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <div class="wrap">
    <div class="card card-1">
      <form class="ticket" method="POST">
        <h5>Ticket</h5>
        <ul>
          <?php foreach ($productos as $id=>$pro): ?>
            <li>
              <span class="title">
                <?=$pro['titulo']?>
                <input type="hidden" name="productos[<?=$id?>][idproducto]" value="<?=$pro['idproducto']?>">
              </span>
              <span class="q">
                <span>  x</span>
                <input type="number" name="productos[<?=$id?>][q]" min="1" value="<?=$pro['q']?>" title="Cantidad">
              </span>
              <span class="price"><?=$pro['precio']?></span>€
              <input type="hidden" name="productos[<?=$id?>][precio]" value="<?=$pro['precio']?>">
            </li>
          <?php endforeach; ?>
          <li class="divider">
            <span class="title">Subtotal:</span>
            <span class="q"></span>
            <span class="price"></span>€
          </li>
        </ul>
        <input type="hidden" name="amount" value=""/>

        <button <?=count($productos)?"":"disabled"?> style="width: 100%;padding: 0.2em 1em;" >Pagar ahora!</button>
        <a href="/client/ticket" class="" title="Ver PDF del carrito">PDF</a>
      </form>
    </div>
  </div>
</div>
<script charset="utf-8" async>
  $(function(){

    $( "button:first" ).button({
      icons: {
        primary: "ui-icon-cart"
      }
    }).next().button({
      icons: {
        primary: "ui-icon-document"
      }
    });
  });
  var subte = document.querySelector('li.divider span.price');
  var amount = document.querySelector('input[name="amount"]');
  var subt;
  function calc(){
    subt = 0;
    [].forEach.call(document.querySelectorAll('form.ticket li:not(.divider)'), function(e){
      subt += Number(e.querySelector('.q input').value) * Number(e.querySelector('.price').innerHTML);
    });
    subte.innerHTML = subt;
    amount.value = Number(subt);
  };
  calc();
  [].forEach.call(document.querySelectorAll('form.ticket li:not(.divider) input'), function(e){
    e.addEventListener('change', function(){
      calc();
    }, false);
  });
</script>
<?php require VIEWS . '_layout/footer.php'; ?>
