<?php
  // Validar email
  function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  // Validar Pass
  function isValidPassword($pass){
    return preg_match('/^[\w\s\S]{8,}$/', $pass);
  }

  function escapeText($text){
    return htmlentities(htmlspecialchars($text));
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


  // Generar Factura
  function generate_facture($productos = array()){
      // print_r($productos);
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
      $pdf->addReglement("Chèque à réception de facture");
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
      // productos
      $y    = 109;


      foreach ($productos as $id => $pro) {
        foreach ($pro as $key => $value) {
          $line = array( "REFERENCIA"    => "REF". $value['idproducto'],
          "DESCRIPCION"  => ucfirst($value['descripcion']),
          "CANTIDAD"     => "1",
          "PRECIO UNI."      => $value["precio"] . " ". EURO,
          "PRECIO TOTAL" => "600.00",
          "I.V.A."          => "1" );
          $size = $pdf->addLine( $y, $line );
          $y   += $size + 2;
        }
      }


      $pdf->addCadreTVAs();

      $tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
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
      "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
      "AccompteExige" => 1,
      "accompte"         => 0,     // montant de l'acompte (TTC)
      "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
      "Remarque" => "Avec un acompte, svp..." );

      $pdf->addTVAs( $params, $tab_tva, $tot_prods);
      $pdf->addCadreEurosFrancs();
      $pdf->Output();
  }


 ?>
