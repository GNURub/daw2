<?php


  class Admin extends Controller {
      private $_params;
      private $product;
      private $category;
      private $clients;
      static $products;
      private $isAdmin;
      static $lastItem;

      public function __construct($params = array())
      {
          $this->product    = new ProductModel();
          $this->clients    = new ClientModel();
          $this->category   = new CategoryModel();
          $this->_params    = $params;
          self::$products   = $this->product->toArray();
          $this->isAdmin    = (self::getSession('admin') == "admin" ||
                              self::getSession('admin') == "administrador");
      }

      public function index($params = array()){
          if(empty($params[0])){
            require VIEWS . 'error/404.php';
          }else{
            header('location: /');
          }
          return;
      }

      public function notifyAction()
      {
        if($this->isAdmin){
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            extract($_POST);
            $itemid = (!isset($itemid) || empty($itemid)) ? null : $itemid;
            $pro = $this->product->toArray($itemid);
            if(empty($itemid) || empty($pro)){
              header('location: /');
            }
            $clientes = $this->clients->toArray();
            $item = $this->product->toArray($itemid);


            $mail = new PHPMailer;
            // $mail->SMTPDebug = 3;

            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL;
            $mail->Password   = PASSWORD;
            $mail->SMTPSecure = SMTP_SECURE;
            $mail->Port       = SMTP_PORT;
            $mail->setFrom(EMAIL, 'The cat long');
            $mail->isHTML(true);
            $mail->Subject = $title;

            foreach ($clientes as $value) {
              if(EMAIL != $value['email']){
                $mail->addAddress($value['email']);
              }
              $mail->Body    = "<html>
                                  <head>
                                    <title>$title</title>
                                  </head>
                                  <body>
                                    <h2>$title</h2>
                                    <p>
                                      $detalles
                                    </p>
                                  </body>
                                </html>";
            }
            foreach ($item as $i) {
              $mail->addAttachment(IMGS. $i['path']);
            }
            $mail->AltBody = $detalles;

            if($mail->send()) {
                header('location: /');
                return;
            }



          }
          $pa = $this->product->toArray($this->_params[0]);
          if(empty($this->_params[0]) || empty($pa)){
            header('location: /');
            return;
          }
          $itemId = $this->_params[0];
          self::$lastItem = $itemId;

          return require VIEWS . 'admin/notifyByEmail.php';
        }
        return require VIEWS . 'error/401.php';
      }


      public function factureAction()
      {
        // $pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
        // $pdf->AddPage();
        // $pdf->addSociete( "TheCatLong",
        //                   "Av. España N°76, Illes Balears.\n" .
        //                   "07800 Eivissa, Illes Balea\n".
        //                   "Capital: 18000 " . EURO );
        // $pdf->fact_dev( "Devis ", "TEMPO" );
        // $pdf->temporaire( "Factura" );
        // $pdf->addDate( "03/12/2003");
        // $pdf->addClient("CL01");
        // $pdf->addPageNumber("1");
        // $pdf->addClientAdresse("Ste\nM. XXXX\n3ème étage\n33, rue d'ailleurs\n75000 PARIS");
        // $pdf->addReglement("Chèque à réception de facture");
        // $pdf->addEcheance("03/12/2003");
        // $pdf->addNumTVA("FR888777666");
        // $pdf->addReference("Devis ... du ....");
        // $cols=array( "REFERENCIA"    => 23,
        //              "DESIGNATION"  => 78,
        //              "CANTIDAD"     => 22,
        //              "PRECIO UNI."      => 26,
        //              "MONTANT H.T." => 30,
        //              "TVA"          => 11 );
        // $pdf->addCols( $cols);
        // $cols=array( "REFERENCIA"    => "L",
        //              "DESIGNATION"  => "L",
        //              "CANTIDAD"     => "C",
        //              "PRECIO UNI."      => "R",
        //              "MONTANT H.T." => "R",
        //              "TVA"          => "C" );
        // $pdf->addLineFormat( $cols);
        // $pdf->addLineFormat($cols);
        // // productos
        // $y    = 109;
        // $line = array( "REFERENCIA"    => "REF1",
        //                "DESIGNATION"  => "Carte Mère MSI 6378\n" .
        //                                  "Processeur AMD 1Ghz\n" .
        //                                  "128Mo SDRAM, 30 Go Disque, CD-ROM, Floppy, Carte vidéo",
        //                "CANTIDAD"     => "1",
        //                "PRECIO UNI."      => "600.00",
        //                "MONTANT H.T." => "600.00",
        //                "TVA"          => "1" );
        // $size = $pdf->addLine( $y, $line );
        // $y   += $size + 2;
        //
        // $line = array( "REFERENCIA"    => "REF2",
        //                "DESIGNATION"  => "Câble RS232",
        //                "CANTIDAD"     => "1",
        //                "PRECIO UNI."      => "10.00",
        //                "MONTANT H.T." => "60.00",
        //                "TVA"          => "1" );
        // $size = $pdf->addLine( $y, $line );
        // $y   += $size + 2;
        //
        // $pdf->addCadreTVAs();
        //
        // $tot_prods = array( array ( "px_unit" => 600, "qte" => 1, "tva" => 1 ),
        //                     array ( "px_unit" =>  10, "qte" => 1, "tva" => 1 ));
        // $tab_tva = array( "1"       => 19.6,
        //                   "2"       => 5.5);
        // $params  = array( "RemiseGlobale" => 1,
        //                       "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
        //                       "remise"         => 0,       // {montant de la remise}
        //                       "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
        //                   "FraisPort"     => 1,
        //                       "portTTC"        => 10,      // montant des frais de ports TTC
        //                                                    // par defaut la TVA = 19.6 %
        //                       "portHT"         => 0,       // montant des frais de ports HT
        //                       "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
        //                   "AccompteExige" => 1,
        //                       "accompte"         => 0,     // montant de l'acompte (TTC)
        //                       "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
        //                   "Remarque" => "Avec un acompte, svp..." );
        //
        // $pdf->addTVAs( $params, $tab_tva, $tot_prods);
        // $pdf->addCadreEurosFrancs();
        // $pdf->Output();
      }

      public function updateAction()
      {
          //update a todo item
      }

      public function deleteAction()
      {
          //delete a todo item
      }
  }

 ?>
