<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <div class="wrap">
    <div class="card card-1">
      <form class="ticket" method="POST">
        <h5>Ticket</h5>
        <ul>
          <?php foreach ($productos as $pro): ?>
            <li>
              <span class="title">
                <?=$pro['titulo']?>
                <input type="hidden" name="idproduct[]" value="<?=$pro['idproducto']?>">
              </span>
              <span class="q">
                <span>  x</span>
                <input type="number" name="q[]" min="1" max="99" value="<?=$pro['q']?>">
              </span>
              <span class="price"><?=$pro['precio']?></span>€
              <input type="hidden" name="precio[]" value="<?=$pro['precio']?>">
            </li>
          <?php endforeach; ?>
          <li class="divider">
            <span class="title">Subtotal:</span>
            <span class="q"></span>
            <span class="price"></span>€
          </li>
        </ul>
        <input type="hidden" name="amount" value=""/>
        <!-- <a href="" class="btn btn-lg red">PDF</a> -->
        <button class="btn btn-lg red" style="width: 100%;padding: 0.2em 1em;">Pagar ahora!</button>
      </form>
    </div>
  </div>
</div>
<script charset="utf-8" async>
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
