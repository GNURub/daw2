<?php
  use \stojg\crop\CropEntropy;
  // Validar email
  function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  // Validar Pass
  function isValidPassword($pass){
    return preg_match('/^[\w\s\S]{8,}$/', $pass);
  }

  // Enviar email
  function sendEmail($force, $clients, $subject, $body, $resources = array()){
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = EMAIL;
    $mail->Password   = PASSWORD;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port       = SMTP_PORT;
    $mail->setFrom(EMAIL, 'The cat long');
    $mail->isHTML(true);
    $mail->Subject = $subject;

    foreach ($clients as $client) {
      if((EMAIL != $client['email'] && !empty($client['news'])) || !!$force){
        $mail->addAddress($client['email']);
      }
    }
    $mail->Body    = $body;
    foreach ($resources as $i) {
      if( !isset($i['absolute']) ){
        $mail->addAttachment(IMGS. $i['path']);
      }else{
        $mail->addAttachment($i['path']);
      }
    }
    $mail->AltBody = $body;

    if($mail->send()) {
      return header('location: /');
    }
  }

  function isImageValid($file){
    return !!preg_match('/image\/*/', mime_content_type($file));
  }

  function isNew($product, $msg = "Novedad", $days = 14){
    $dStart = new DateTime($product['createdAt']);
    $dEnd  = new DateTime();
    $dDiff = $dStart->diff($dEnd);
    $new = ($dDiff->days <= $days) ? "new='{$msg}'" : "";
    return $new;
  }

  function isJson($string) {
   json_decode($string, true);
   return (json_last_error() == JSON_ERROR_NONE);
  }

  function escapeText($text){
    return htmlspecialchars(htmlentities($text));
  }

  // Subir imagen
  function uploadImage($file){

    $target_file = IMGS . uniqid() . basename($file["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $check = getimagesize($file["tmp_name"]);
    if(!$check) {
      throw new Exception("No es una imagen", 1);
    }

    if (file_exists($target_file)) {
      throw new Exception("La imagen ya existe", 1);
    }

    if ($file["size"] > 500000) {
      throw new Exception("La imagen es demasiado grande", 1);
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      throw new Exception("Solo se permiten subir imagenes", 1);
    }

    $temp = explode(".", $file["name"]);
    $newfilename = uniqid() . '.' . end($temp);

    if (move_uploaded_file($file["tmp_name"], IMGS . $newfilename)) {
      $center = new CropEntropy(IMGS . $newfilename);
      $croppedImage = $center->resizeAndCrop(300, 225);
      $croppedImage->writeimage(IMGS . $newfilename);
      return $newfilename;
    }
    throw new Exception("Error al subir la imagen", 1);
  }

  // To transparently support this function on older versions of PHP
  if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
      if(strlen($str1) != strlen($str2)) {
        return false;
      } else {
        $res = $str1 ^ $str2;
        $ret = 0;
        for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
        return !$ret;
      }
    }
  }

function generate_ticket($productos = array()){
  ob_start();
  include APP.'/templates/pdf/ticket.php';
  $content = ob_get_contents();
  ob_end_clean();
  $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', 0);
  $html2pdf->pdf->SetDisplayMode('fullpage');
  $html2pdf->writeHTML($content);
  return $html2pdf->Output('ticket.pdf');
}

  // Generar Factura
  function generate_facture($productos = array(), $client = array()){
      // print_r($productos);
      // exit;
      $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
      $pdf->AddPage();
      $pdf->addSociete( "TheCatLong",
      "Av. España N°76, Illes Balears.\n" .
      "07800 Eivissa, Illes Balea\n".
      "Capital: 18000 " . EURO );
      $pdf->fact_dev( "Devis ", "TEMPO" );
      $pdf->temporaire( "Factura" );
      $pdf->addDate( "03/12/2003");
      $pdf->addClient("CL01");
      $pdf->addPageNumber("1");
      $pdf->addClientAdresse("Ste\nM. XXXX\n3ème étage\n33, rue d'ailleurs\n75000 PARIS");
      $pdf->addReglement("Pago online");
      $pdf->addEcheance("03/12/2003");
      $pdf->addNumTVA("FR888777666");
      $pdf->addReference("Devis ... du ....");
      $cols=array( "REFERENCIA"    => 23,
      "DESCRIPCION"  => 78,
      "CANTIDAD"     => 22,
      "PRECIO UNI."      => 26,
      "PRECIO TOTAL" => 30,
      "I.V.A."          => 11 );
      $pdf->addCols( $cols);
      $cols=array( "REFERENCIA"    => "L",
      "DESCRIPCION"  => "L",
      "CANTIDAD"     => "C",
      "PRECIO UNI."      => "R",
      "PRECIO TOTAL" => "R",
      "I.V.A."          => "C" );
      $pdf->addLineFormat( $cols);
      $pdf->addLineFormat($cols);


      $y  = 109;
      $total = 0;

      foreach ($productos as $id => $pro) {
          $totalProducto = ($pro["precio"] + ($pro["precio"] * 0.21));
          $total += $totalProducto;
          $line = array( "REFERENCIA"    => "REF". $pro['idproducto'],
          "DESCRIPCION"  => ucfirst($pro['descripcion']),
          "CANTIDAD"     => "1",
          "PRECIO UNI."      => $pro["precio"] . " ". EURO,
          "PRECIO TOTAL" => $totalProducto,
          "I.V.A."          => "21%" );
          $size = $pdf->addLine( $y, $line );
          $y   += $size + 2;
      }


      $pdf->addCadreTVAs();

      $tot_prods = array( array ( "px_unit" => $totalProducto, "qte" => 1, "tva" => 1 ),
      array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
      $tab_tva = array( "1"       => 19.6,
      "2"       => 5.5);
      $params  = array( "RemiseGlobale" => 1,
      "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
      "remise"         => 0,       // {montant de la remise}
      "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
      "FraisPort"     => 1,
      "portTTC"        => 10,      // montant des frais de ports TTC
      // par defaut la TVA = 19.6 %
      "portHT"         => 0,       // montant des frais de ports HT
      "portTVA"        => 21,    // valeur de la TVA a appliquer sur le montant HT
      "AccompteExige" => 1,
      "accompte"         => 0,     // montant de l'acompte (TTC)
      "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
      "Remarque" => "Avec un acompte, svp..." );

      $pdf->addTVAs( $params, $tab_tva, $tot_prods);
      $pdf->addCadreEurosFrancs();
      $tmpFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR .  uniqid(time()) . 'factura.pdf';
      $pdf->Output($tmpFile, 'F');

      return sendEmail(
        true,
        $client,
        'Factura',
        'Ya tiene disponible su factura. Grácias por su compra',
        array(
          array(
            'absolute' => true,
            'path' => $tmpFile
          )
        )
      );
  }


 ?>
