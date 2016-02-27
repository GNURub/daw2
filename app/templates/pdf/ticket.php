<?php
  $total = 0;
 ?>
<style type="text/css">
  h1{
    font-family: Helvetica, sans-serif;

  }
  .address{
    text-align: center;
    color: rgb(111, 111, 111);
    font-size: 10px;
    font-weight: bold;
  }
  .center{
    text-align: center;
    display: block;
  }
  .margin{
    margin-bottom: 50px;
  }
  table{
    width: 100%;
  }
  th{
    font-size: 10px;
  }
  td{
    font-size: 9px;
  }
  .footer{
    position: absolute;
    width: 100%;
    bottom: 0;
    margin: 20px auto;
    font-size: 7px;
  }
  .descript{
    text-transform: uppercase;
  }
</style>
<page format="130x90" orientation="R" backcolor="#fff" style="font: arial;">
  <h1 class="center">
    <img src="<?=IMGS.'icons/android-icon-36x36.png'?>" alt="" />
    The Cat Long
  </h1>
  <div class="address center">Avenida Perez Matutes Noguera</div>
  <div class="address center">Ibiza, 07800</div>
  <div class="address center">(+34) 971 39 10 39</div>
  <div class="address center margin"><?php echo date('d/m/Y H:i'); ?></div>
  <table style="width: 100%;border: none;" cellspacing="4mm" cellpadding="0">
      <tr>
          <th style="width: 25%">
            #REF
          </th>
          <th style="width: 25%">
            DESCRIPCION
          </th>
          <th style="width: 25%">
            CANTIDAD
          </th>
          <th style="width: 25%">
            PRECIO
          </th>
          <!-- <td colspan="2" style="width: 100%"> -->
          <!-- </td>
          <td colspan="2" style="width: 100%">
          </td> -->
      </tr>
      <?php foreach ($productos as $product):
              $total += ($product['q'] * $product['precio']);
      ?>
        <tr>
            <td style="width: 25%">
              <?=$product['idproducto'] ?>
            </td >
            <td style="width: 25%" class="descript">
              <?=$product['descripcion'] ?>
            </td>
            <td style="width: 25%">
              <?=$product['q'] ?>
            </td>
            <td style="width: 25%">
              <?=$product['precio'] ?> €
            </td>
        </tr>
      <?php endforeach; ?>
  </table>
  <table style="width: 100%;border: none;" cellspacing="4mm" cellpadding="0">
    <tr>
      <th style="width: 75%">
        Subtotal:
      </th>
      <td style="width: 25%; text-align:center">
        <?=$total ?> €
      </td>
    </tr>
    <tr>
      <th style="width: 75%">
        Total (+21% IVA):
      </th>
      <td style="width: 25%; text-align:center">
        <?=$total + ($total * 0.21) ?> €
      </td>
    </tr>
  </table>
  <div class="footer center">
    No se efecturan cambios, con una fecha de compra superior a los 30 dias.
    Los elementos de seguridad estan excentos de cambios depués de haber sido usados.
    Los cambios de los productos se deben realizar con la factura.
    Grácias por haber comprado en TheCatLong!.
  </div>
</page>
