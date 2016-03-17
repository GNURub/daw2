<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <div class="wrap">
    <div class="card card-1">
      <form class="ticket" method="POST" enctype="multipart/form-data"  name="productsinfo">
        <h5>Ticket</h5>
        <ul>
          <?php foreach ($productos as $id=>$pro): ?>
            <li data-id="<?=$pro['idproducto']?>">
              <span class="title">
                <?=$pro['titulo']?>
                <input type="hidden" name="productos[<?=$id?>][idproducto]" value="<?=$pro['idproducto']?>">
              </span>
              <span class="q">
                <span>  x</span>
                <input type="number" name="productos[<?=$id?>][q]" min="1" value="<?=$pro['q']?>" title="Cantidad">
              </span>
              <span class="size">
                <select id="size" required name="productos[<?=$id?>][size]">
                </select>
              </span>
              <span class="color">
                <select id="color" required name="productos[<?=$id?>][color]">
                </select>
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
        <a href="/client/ticket" class="" id="ticket" title="Ver PDF del carrito">PDF</a>
      </form>
    </div>
  </div>
</div>
<script charset="utf-8" async>
'use strict';
  $(function(){
    var size = $('#size');
    var color = $('#color');

    size.on('change', function(e){
      var id = $(this).parents('li[data-id]').attr('data-id');
      window.fetch('/api/properties/' + id + '/' + size.val()).then(function(response){
        return response.json();
      }).then(function(r){
        color.empty();
        r.forEach(function(o){
          color.append('<option>' + o.idcolor + '</option>');
        })
      })
      // console.log(size.val())
    });

    $('button:first').button({
      icons: {
        primary: "ui-icon-cart"
      }
    }).next().button({
      icons: {
        primary: "ui-icon-document"
      }
    });

    // Ajax ticket
    if(!!$('#ticket')){
      $('#ticket').on('click',function(e){
        e.preventDefault();
        var body = new FormData(document.forms.namedItem("productsinfo"));
        window.fetch('/client/ticket', {
          method: 'POST',
          body: body,
          credentials: 'include'
        }).then(function(response){
          return response.text();
        }).then(function(r){
          location.href = "/client/ticket";
        })
      });
    }
    $('li[data-id]').each(function(i,e){
      var id = e.dataset.id;
      window.fetch('/api/properties/' + id, {
        credentials: 'include'
      }).then(function(response){
        return response.json();
      }).then(function(sizes){
        size.empty();
        size.append('<option disabled selected>Seleccionar</option>');
        sizes.forEach(function(e){
          size.append('<option>' + e.idtalla +'</option>');
        });
      })
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
