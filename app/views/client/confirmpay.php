<?php require VIEWS . '_layout/header.php'; ?>
<style media="screen">
  html{
    height: 100%;
    min-height: inherit!important;
  }
</style>
<div class="content form">
  <form name="frm" class="signin center" action="http://jguasch.esy.es/redsys/lacaixa.php" method="POST" target="_blank">
    <input type="hidden" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/>
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/>
    <input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>"/>
    <input type="submit" style="padding:1em" class="btn btn-lg" value="Confimar pago" >
  </form>
</div>
<?php require VIEWS . '_layout/footer.php'; ?>
