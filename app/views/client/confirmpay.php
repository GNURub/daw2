<?php require VIEWS . '_layout/header.php'; ?>
<div class="content form">
  <form name="frm" class="signin center" action="http://redsys.byethost12.com/lacaixa.php" method="POST" target="_blank">
  Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/></br>
  Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/></br>
  Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="<?php echo $signature; ?>"/></br>
  <input type="submit" class="btn btn-lg" value="Enviar" >
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
