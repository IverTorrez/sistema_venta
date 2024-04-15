<?php
//require_once('tcpdf_include.php');

require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
include_once('../../../model/clscausa.php');
include_once('../../../model/clspostacausa.php');
include_once('../../../model/clsinformeposta.php');
include_once('../../../model/clstipoposta.php');
include_once('../../../model/clsordengeneral.php');

/*$pdf = new TCPDF('L', 'mm', 'Legal', true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();
$pdf->SetFont('','',10);*/
$cod=$_GET['codcausa'];
$decodificado=base64_decode($cod);

   $codigonuevo=$decodificado/1234567;


//$codigonuevo=$_GET['codcausa'];//CODIGO DE LA CAUSA

/*FUNCION PARAVERIFICAR SI ESTA CAUSA TIENE PLANTILA ASIGNADA*/
$objPC=new PostaCausa();
$resulconteo=$objPC->contadorDePostasCausaDeunaCausa($codigonuevo);
$filconteo=mysqli_fetch_object($resulconteo);

if ($filconteo->cantidadPostas>0) 
{
  /*PREGUNTAMOS SI LA POSTA CERO (POSTA INICIO) TIENE DATOS O ESTA VACIA , PARA DARLES LOS COLORES A LA POSTA*/

    $objpstcausa=new PostaCausa();
    $resulpstcausa=$objpstcausa->mostrarPrimerPostaCausa(0,$codigonuevo);
    $filpstcausa=mysqli_fetch_object($resulpstcausa);
    /*PREGUNTA SI YA SE INTRODCIO EL PRIMER PASO, PARA DARLE COLOR A LOS BORDES*/
    if ($filpstcausa->estado=='llena') 
      {
        $colorbordebtnini='#87E534';
         $colorfondopostaini='#87E534';

         $imagentrianguloInicio='trianguloverde.png';
      }
    else/*POR FALSO LOS DEJA CON EL COLOR NONE*/
      {
        $colorbordebtnini='#E5E5E5';
         $colorfondopostaini='#E5E5E5';
         $imagentrianguloInicio='triangulogris.png';
      }
  
  /*SACAMOS LOS DATOS DE LA POSTACAUSA CERO*/
  $objpostacero=new PostaCausa();
  $resulpostacero=$objpostacero->mostaraPostaCeroDeUnaCausa($codigonuevo);
  $filpostacero=mysqli_fetch_object($resulpostacero);

  if ($filpostacero->estado=='llena') 
  {
    $colorNombrepostacero='green';
  }
  else
  {
    $colorNombrepostacero='#B0B0B0';
  }
  /*FUNCION QUE NOS MUESTRA EL INFORME DE LA POSTA CERO (POSTA INICIO)*/
  $objinformeposta=new InformePosta();
  $resulinformep=$objinformeposta->muestraTodoelInformeDePostaParaDemasUsuarios($filpostacero->id_postacausa);
  $filinfor=mysqli_fetch_object($resulinformep);


   /* CODIGO PARA VERIFICAR SI LA SIGUIENTE POSTA ESTA LLENA (POR VERDADERO SE INABILITA EL BOTON ACTUAL)*/
    $idpostasiguiente=$filpostacero->id_postacausa+1;
    $objpostcausa11=new PostaCausa();
    $resulpostcausa11=$objpostcausa11->mostrarUnaPostaCausa($idpostasiguiente,$codigonuevo);
    $filpostasigu=mysqli_fetch_object($resulpostcausa11);
    if ($filpostasigu->estado=='llena') 
    {
      $varabilitaboton="disabled=''";
    }

/*TITULOS PARA EL HISTORIGRAMA*/

   $objcausa=new Causa();
   $resul=$objcausa->mostrarcodcausa($codigonuevo);
   $fil=mysqli_fetch_object($resul);

   $resulcli=$objcausa->mostrarUnacausa($codigonuevo);
    $filcli=mysqli_fetch_object($resulcli);

  $BLOQUE_1=  " <p style='color: #000000;font-size: 10px;text-align: left;'>Cliente: $filcli->clienteasig</p";
   
$BLOQUE_1.=" <h4 style='color: #000000;font-size: 20px;text-align: center;'>AVANCE FISICO DE LA PRESENTE CAUSA: $fil->codigo</h4";

/*FIN DE TITULOS PARA EL HISTORIGRAMA*/

//echo $filpostacero->id_postacausa;
//echo $filpostasigu->estado;
  /*ESTA ES LA TABLA DE LA POSTA CERO*/
  $BLOQUE_1.= "<div class='container'>  
                  <div class='container'>

        <table style='width: 100%;' >
          <tbody>
            <tr style='height: 100px;'>

               <!--PRIMERA COLUMNA (COLUMNA INFORMACION DE DE DATOS DE POSTA CERO)-->
               <td style='width: 44%;'>

               <div style='text-align: right;'>
                              <label class='labelnameposta' style='color: $colorNombrepostacero; font-family:'Arial Narrow',sans-serif;'>$filpostacero->nombrepostacausa</label><br>";



                              if ($filpostacero->estado=='vacia') 
                                {
                                  $BLOQUE_1.= "<label></label><br>
                                        <label></label><br>
                                        <label></label><br>
                                        <label></label><br>
                                        <label></label><br>";
                                 //$varabilitaboton="disabled=''";
                                }
                                else
                                {
                                  /*AQUI ARA EL CALCULO PARA EL GASTO PROCESALES*/
                                  $fechainformeConhora=$filinfor->fechainforme.' '.'23:59';
                                  $oborden=new OrdenGeneral();
                                  $resultgastos=$oborden->mostrarGastosProcesalesHastaUnaPostaDeUnaCausa($codigonuevo,$fechainformeConhora);
                                  $filgastosp=mysqli_fetch_object($resultgastos);
                                  if ($filgastosp->Gastosprocesales>0) 
                                  {
                                    $gastosprocesales1=$filgastosp->Gastosprocesales;
                                  }
                                  else
                                  {
                                    $gastosprocesales1=0;
                                    //$totalgastodecausa=0;
                                  }
                                  
                                   $totalgastodecausa=$gastosprocesales1+$filinfor->informehonorario;
                                  $BLOQUE_1.= "<label>(Foja: $filinfor->fojainforme) </label><br>

                                       <label>$filinfor->fechainforme </label><br>

                                       <label>Gastos Procesales: $gastosprocesales1 Bs </label><br>

                                       <label>Honorarios Profesionales: $filinfor->informehonorario Bs </label><br>

                                       <label> TOTAL: $totalgastodecausa Bs </label><br>";

                                 // $varabilitaboton="enabled=''";
                                }
                              $BLOQUE_1.= "</div>";
        




            $BLOQUE_1.= "</td>";  

            /*PREGUNTA SI EL INFORME DE POSTA TIENE TRUNCAMIENTO OSEA EL ID ES MAYOR A UNO*/
            if ($filinfor->idtipoposta>1 or $filpostasigu->estado=='llena') 
             {
               $varabilitaboton="disabled=''";
             }
             else
             {
               if ($filinfor->idtipoposta==1 and $filpostasigu->estado=='vacia') 
               {
                 $varabilitaboton="disabled=''";
               }
             }


               
              //<!--SEGUNDA COLUMNA (COLUMNA NOMBRE POSTA CERO)-->
          $BLOQUE_1.= "<td style='width: 10%;'>

                <center> 
                 <div style='height: 60px; '>
                 <button class='btniniposta' style='border: 5px solid $colorbordebtnini; background:$colorfondopostaini; font-size: 17px; 
                      color: black; 
                      width: 90px; 
                      height: 57px; 
                      -moz-border-radius:50%; 
                      -webkit-border-radius: 50%; 
                      border-radius: 50%;
                      cursor: pointer;
                      margin-top: -8px; ' $varabilitaboton >$filpostacero->nombrepostacausa</button>
                 </div>
                  <img src='images/$imagentrianguloInicio' style='width:90px; margin-top:8px; margin-left: 2px;'>
                  </center>

           </td>"; 


             // <!--TERCERA COLUMNA (FLECHA DEL TRUNCAMIENTO)-->
            $BLOQUE_1.= "<td style='width: 8%; '>";

               /*IF QUE PREGUNTA SI EL TIPO DE POSTA ES DIFERENTE DE UNO Y SI NO ESTA VACIO (SI ES DIFERENTE ES TRUNCAMIENTE)**/
            if ($filinfor->idtipoposta!=1 and $filinfor->idtipoposta!=null) 
              {
                $objtipoposta1=new TipoPosta();
                $resultpposta1=$objtipoposta1->mostrarUnTipoPosta($filinfor->idtipoposta);
                $filtpposta=mysqli_fetch_object($resultpposta1);

               $BLOQUE_1.= " <div style=' '>
                     <img src='images/flecharojanueva.png' style='width:90px; '>
                     </div>";
                $varabilitaboton="disabled=''";
              }/*FIN DEL IF QUE PREGUNTA SI EL TIPO DE POSTA ES DIFERENTE DE UNO Y SI NO ESTA VACIO**/
          $BLOQUE_1.= "</td>";



             //  <!--CUARTA COLUMNA (NOMBRE DEL TRUNCAMIENTO )-->
          $BLOQUE_1.= "<td style='width: 37%; '>";

             if ($filinfor->idtipoposta!=1 and $filinfor->idtipoposta!=null) 
                {
                  $objtipoposta1=new TipoPosta();
                  $resultpposta1=$objtipoposta1->mostrarUnTipoPosta($filinfor->idtipoposta);
                  $filtpposta=mysqli_fetch_object($resultpposta1);

                  $objinforTrunca=new InformePosta();
                  $resulinfotrunca=$objinforTrunca->mostrarDatosDelTruncamientoDePosta($filpostacero->id_postacausa);
                  $filinfotrunca=mysqli_fetch_object($resulinfotrunca);

                  /*AQUI ARA EL CALCULO PARA EL GASTO PROCESALES*/
                                  $fechainformetrunaConhora=$filinfotrunca->fechainformetrunca.' '.'23:59';
                                  $oborden1=new OrdenGeneral();
                                  $resultgastos1=$oborden1->mostrarGastosProcesalesHastaUnaPostaDeUnaCausa($codigonuevo,$fechainformetrunaConhora);
                                  $filgastosp1=mysqli_fetch_object($resultgastos1);

                                  if ($filgastosp1->Gastosprocesales>0) 
                                  {
                                    $gastosprocesales1=$filgastosp1->Gastosprocesales;
                                  }
                                  else
                                  {
                                    $gastosprocesales1=0;
                                    //$totalgastodecausa=0;
                                  }
                                  
                                   $totalgastodecausatrunca=$gastosprocesales1+$filinfotrunca->informehonorariotrunca;
              /*AL DARLE CLIK AL TRUNCAMIENTO LEVANTA EL MODAL Y LLEVA LOS DATOS PARA EDITAR O ELIMINAR EL TRUNCAMIENTO*/
                  $BLOQUE_1.= " <div style='width: 200px; margin-top: -8px; height: 110px;
                              background: #FF6A49;
                              color: white;
                             
                              -moz-border-radius:20%; 
                            -webkit-border-radius: 20%; 
                            border-radius: 20%;
                            border: 4px solid red;

                            cursor:  pointer;' class='tipotruncamiento' style='height: 90px;
                                        background: #FF6A49;
                                        color: white;
                                       
                                        -moz-border-radius:20%; 
                                      -webkit-border-radius: 20%; 
                                      border-radius: 20%;
                                      border: 4px solid red;

                                      cursor:  pointer;' onclick='funcionllevaidmodaltruncamiento();' parametroidinforme='$filinfor->id_informeposta' parametrofojatrunca='$filinfor->fojainformetrunca' parametroidtipotrunca='$filinfor->idtipoposta' parametrofechatrunca='$filinfor->fechainformetrunca' parametrohonoratrunca='$filinfor->informehonorariotrunca' >

                          <div>
                            
                               <center> <lavel style='text-align: justify;'>$filtpposta->nombretipoposta</lavel></center>";

                                $BLOQUE_1.= "<div style='margin-left: 10px; font-size:13px; cursor:pointer;'> <label>(Foja: $filinfotrunca->fojainformetrunca) </label><br>

                                       <label>$filinfotrunca->fechainformetrunca </label><br>

                                       <label>Gastos Procesales: $gastosprocesales1 Bs </label><br>

                                       <label>Honorarios Profesionales: $filinfotrunca->informehonorariotrunca Bs </label><br>

                                       <label> TOTAL: $totalgastodecausatrunca Bs </label> </div><br>";


                 $BLOQUE_1.= " </div>
                       </div>"; 
                     $varabilitaboton="disabled=''";
                } /*FIN DEL IF QUE PREGUNTA SI EL TIPO DE POSTA ES DIFERENTE DE UNO Y SI NO ESTA VACIO**/


                /*IF QUE PREGUNTA SI LA POSTA INICIO ES UN AVANCE NORMAL, PARA ABILITAR A LOS DEMAS BOTONES DE POSTAS*/
                if ($filinfor->idtipoposta==1) 
                {
                  $varabilitaboton="disabled=''";
                }
                if ($filinfor->id_informeposta==null) 
                {
                 $varabilitaboton="disabled=''";
                }


          $BLOQUE_1.= "</td>";/*FIN DE LA CUARTA COLUMNA*/



           $BLOQUE_1.= "</tr>

          </tbody>
        </table>
    

    </div> ";/*div del container*/
/*HASTA AQUI EMPEZO EL BOTON INICIO CON SU TABLA*/


  //$varabilitaboton="enabled=''"; /*SE ABILITA EL BOTON POSTA ACUAL*/
}/*FIN DEL IF QUE PRESGUNTA SI HAY POSTAS DE ESTA CAUSA*/













/*--------------------------------DESDE AQUI LAS DEMAS POSTAS APARTE DE LA POSTA INICIO--------*/



/*PRUEBA PARA EL HITORGRMA SIN RESPONSIVE CON TABLA */
/*ENLISTA TODAS LAS POSTAS EXEPTO LA POSTA CERO (ENLISTA APARYIR DE LA POSTA 1) */
$objposca=new PostaCausa();
$reulpcau=$objposca->listarPostasDeCausaApartirDePosta1($codigonuevo);
while ($filposta=mysqli_fetch_object($reulpcau)) 
{

  $objinformeposta=new InformePosta();
  $resulinformep=$objinformeposta->muestraTodoelInformeDePostaParaDemasUsuarios($filposta->id_postacausa);
  $filinfor=mysqli_fetch_object($resulinformep);
   /*PREGUNTA SI LA POSTA ACTUAL ESTA LLENA, DEPENDE DE ESO COLOREARA LOS BORDES DE LOS CIRCULOS Y LAS FLECHAS Y LE PERMITIRA USAR EL BOTON */
    if ($filposta->estado=='llena') 
    {
      $colorflechalinea='#87E534';
      $colorflechatriang='#87E534';

      $colorbordePosta='#87E534';
      $colorfondoposta='#87E534';
      /*SE ABILITA BOTON NUMEROPOSTA*/
    //  $varabilitaboton="enabled=''";
       $colorNombreposta='green';
    }
    else
    {
      $colorflechalinea='#B0B0B0';
      $colorflechatriang='#B0B0B0';

      $colorbordePosta='#E5E5E5';
      $colorfondoposta='#E5E5E5';
      /*SE DESABILITA EL BOTON*/
   //   $varabilitaboton="disabled=''";
      $colorNombreposta='#B0B0B0';
    }
    /*****************************************************************************/


   /* CODIGO PARA VERIFICAR SI LA SIGUIENTE POSTA ESTA LLENA (POR VERDADERO SE INABILITA EL BOTON ACTUAL)*/
    $idpostasiguiente=$filposta->id_postacausa+1;
    $objpostcausa11=new PostaCausa();
    $resulpostcausa11=$objpostcausa11->mostrarUnaPostaCausa($idpostasiguiente,$codigonuevo);
    $filpostasigu=mysqli_fetch_object($resulpostcausa11);
    if ($filpostasigu->estado=='llena') 
    {
      $varabilitaboton="disabled=''";
    }











/*****************************************************DESDE AQUI AGREGAMOS LA TABLA*********************************************/

/*EMPIEZA LAS FLACHAS CON LA TABLA*****************************************************************************************/
$BLOQUE_1.= "<div class='container'>
   <table>
   <tr><td> <div style='margin-left:373px; height: 100px;'>
        <div style=''>
        <div class='linea' style='background:$colorflechalinea; height: 90px;
                width: 4px;
                   ;' ></div>   
            <div class='triangulo' style='margin-left:-8px; border-bottom: 20px solid $colorflechatriang ; width: 0;
                height: 0;
                border-left: 10px solid transparent;
                border-right: 10px solid transparent;

                border-top: 10px solid transparent;
                
                 border-bottom: 20px solid $colorflechatriang ;

                 transform: rotate(180deg);
                -webkit-transform: rotate(180deg);
                -moz-transform: rotate(180deg);
                -o-transform: rotate(180deg);'>
            </div>
        </div>
    </div>
    </td>
    </tr>
    </table>";
  

  $BLOQUE_1.= "<table style='width: 100%;' ><!--EMPIEZA LA TABLA QUE MUESTRA LAS POSTAS-->
  <tbody>
    <tr style='height: 100px;'>";
   /*empieza la primera columna de la tabla informacion de posta*/
   $BLOQUE_1.= "<td style='width: 46%;'>
                             <div style='text-align: right;'>
                              <label class='labelnameposta' style='color: $colorNombreposta; font-family:'Arial Narrow',sans-serif;'>$filposta->nombrepostacausa</label><br>";
                              if ($filposta->estado=='vacia') 
                                {
                                  $BLOQUE_1.= "<label></label><br>
                                        <label></label><br>
                                        <label></label><br>
                                        <label></label><br>
                                        <label></label><br>";
                                 //$varabilitaboton="disabled=''";
                                }
                                else
                                {
                                  /*AQUI ARA EL CALCULO PARA EL GASTO PROCESALES*/
                                  $fechainformeConhora=$filinfor->fechainforme.' '.'23:59';
                                  $oborden=new OrdenGeneral();
                                  $resultgastos=$oborden->mostrarGastosProcesalesHastaUnaPostaDeUnaCausa($codigonuevo,$fechainformeConhora);
                                  $filgastosp=mysqli_fetch_object($resultgastos);
                                  if ($filgastosp->Gastosprocesales>0) 
                                  {
                                    $gastosprocesales1=$filgastosp->Gastosprocesales;
                                  }
                                  else
                                  {
                                    $gastosprocesales1=0;
                                    //$totalgastodecausa=0;
                                  }
                                  
                                   $totalgastodecausa=$gastosprocesales1+$filinfor->informehonorario;
                                  $BLOQUE_1.= "<label>(Foja: $filinfor->fojainforme) </label><br>

                                       <label>$filinfor->fechainforme </label><br>
                                       <label>Gastos Procesales: $gastosprocesales1 Bs </label><br>
                                       <label>Honorarios Profesionales: $filinfor->informehonorario Bs </label><br>
                                       <label> TOTAL: $totalgastodecausa Bs </label><br>";

                                 // $varabilitaboton="enabled=''";
                                }
                              $BLOQUE_1.= "</div>";
        
     $BLOQUE_1.= "</td>";/*termina la primera columna de latabla*/
     /*IF QUE PREGUNTA SI EL TIPO DE POSTA ES DIFERENTE DE UNO Y SI NO ESTA VACIO (SI ES DIFERENTE ES TRUNCAMIENTE)**/
            if ($filinfor->idtipoposta!=1 and $filinfor->idtipoposta!=null) 
            {
                $varabilitaboton="disabled=''";
            }


  
  /*empieza la segunda columna de la tabla numero de posta*/
   $BLOQUE_1.= "<td style='width: 8%;'>

        <button onclick='funcionllevaidmodal($filposta->id_postacausa)' parametro='$filposta->estado' parametro2='$filinfor->fojainforme' parametro3='$filinfor->informehonorario' parametro4='$filposta->nombrepostacausa' parametro5='$filinfor->fechainforme' parametro6='$filinfor->idtipoposta' parametro7='$filinfor->id_informeposta' parametrogastopro='$gastosprocesales1' parametrogastototal='$totalgastodecausa' class='btnpostanuevo' style='border-color: $colorbordePosta ; background:$colorfondoposta; font-size: 23px; 
                                                  color: black; 
                                                  width: 60px; 
                                                  height: 60px; 
                                                  -moz-border-radius:50%; 
                                                  -webkit-border-radius: 50%; 
                                                  border-radius: 50%;
                                                  cursor: pointer;

                                                  border-width:9px;
                                                  margin-bottom: 20px;' $varabilitaboton >$filposta->numeropostacausa</button>

        </td>";/*termina la segunda columna*/
/*PREGUNTA SI LA POSTA ACTUAL ESTA VACIA, POR VERDADERA DESABILITARA LOS BOTONES SIGUIENTES*/
if ($filposta->estado=='vacia')
{
  $varabilitaboton="disabled=''";
}
else
{
  $varabilitaboton="disabled=''";
}




   /*empieza la tercera columna de la tabla flecha del truncamiento*/
    $BLOQUE_1.= "<td style='width: 8%;'>";
           /*IF QUE PREGUNTA SI EL TIPO DE POSTA ES DIFERENTE DE UNO Y SI NO ESTA VACIO (SI ES DIFERENTE ES TRUNCAMIENTE)**/
            if ($filinfor->idtipoposta!=1 and $filinfor->idtipoposta!=null) 
            {
              $objtipoposta1=new TipoPosta();
              $resultpposta1=$objtipoposta1->mostrarUnTipoPosta($filinfor->idtipoposta);
              $filtpposta=mysqli_fetch_object($resultpposta1);
                  
                  /*FUNCION QUE MUESTRA LOS DATOS DEL TRUNCAMIENTO De esta posta */
                  $objinforTrunca=new InformePosta();
                  $resulinfotrunca=$objinforTrunca->mostrarDatosDelTruncamientoDePosta($filinfor->id_postacausa);
                  $filinfotrunca=mysqli_fetch_object($resulinfotrunca);

                  /*AQUI ARA EL CALCULO PARA EL GASTO PROCESALES HASTA EL TRUNCAMIENTO*/
                  $fechainformetrunaConhora=$filinfotrunca->fechainformetrunca.' '.'23:59';
                  $oborden1=new OrdenGeneral();
                  $resultgastos1=$oborden1->mostrarGastosProcesalesHastaUnaPostaDeUnaCausa($codigonuevo,$fechainformetrunaConhora);
                  $filgastosp1=mysqli_fetch_object($resultgastos1);

                  if ($filgastosp1->Gastosprocesales>0) 
                  {
                  $gastosprocesales1=$filgastosp1->Gastosprocesales;
                  }
                  else
                  {
                  $gastosprocesales1=0;
                    //$totalgastodecausa=0;
                  }
                                  
                  $totalgastodecausatrunca=$gastosprocesales1+$filinfotrunca->informehonorariotrunca;


           $BLOQUE_1.= " <div style='width: 100%;'>
                    <img src='images/flecharojanueva.png' style='width:85px; '>
                 </div>";
            $varabilitaboton="disabled=''";
          }/*FIN DEL IF QUE PREGUNTA SI EL TIPO DE POSTA ES DIFERENTE DE UNO Y SI NO ESTA VACIO**/
    
     $BLOQUE_1.= "</td>";/*termina la tercera columna de la tabla*/



  /*empieza la cuarta columna de la tabla , el tipode truncamiento*/
  $BLOQUE_1.= "<td style='width: 38%;'>";
        if ($filinfor->idtipoposta!=1 and $filinfor->idtipoposta!=null) 
            {
              $objtipoposta1=new TipoPosta();
              $resultpposta1=$objtipoposta1->mostrarUnTipoPosta($filinfor->idtipoposta);
              $filtpposta=mysqli_fetch_object($resultpposta1);
          $BLOQUE_1.= " <div style=' width:220px; margin-top: -8px; height: 110px;
                    background: #FF6A49;
                    color: white;
                   
                    -moz-border-radius:20%; 
                  -webkit-border-radius: 20%; 
                  border-radius: 20%;
                  border: 4px solid red;

                  cursor:  pointer;' class='tipotruncamiento' onclick='funcionllevaidmodaltruncamiento();' parametroidinforme='$filinfor->id_informeposta' parametrofojatrunca='$filinfor->fojainformetrunca' parametroidtipotrunca='$filinfor->idtipoposta' parametrofechatrunca='$filinfor->fechainformetrunca' parametrohonoratrunca='$filinfor->informehonorariotrunca'>
                  <div>
                    
                        <label style='text-align: justify;'>$filtpposta->nombretipoposta</label>";
                       $BLOQUE_1.= "<div style='margin-left: 10px; font-size:13px; cursor:pointer;'> 
                                      <label>(Foja: $filinfotrunca->fojainformetrunca) </label><br>
                                       <label>$filinfotrunca->fechainformetrunca </label><br>
                                       <label>Gastos Procesales: $gastosprocesales1 Bs </label><br>
                                       <label>Honorarios Profesionales: $filinfotrunca->informehonorariotrunca Bs </label><br>
                                       <label> TOTAL: $totalgastodecausatrunca Bs </label> </div><br>";
               $BLOQUE_1.= "  </div>
               </div>"; 
             $varabilitaboton="disabled=''";
           } /*FIN DEL IF QUE PREGUNTA SI EL TIPO DE POSTA ES DIFERENTE DE UNO Y SI NO ESTA VACIO**/
        
    $BLOQUE_1.= "</td>";/*termina la cuarta columna de la tabla , el tipode truncamiento*/


  $BLOQUE_1.= " </tr>

  </tbody>
</table><!--FIN DE LA TABALA-->
</div>
</div><!--FIN DEL CONTAINER-->"; 

  
}/*FIN DEL WHILE QUE RECORRE TODAS LAS POSTAS DE UNA CAUSA*/




//echo $BLOQUE_1;




$dompdf=new Dompdf();
//CODIGO PARA DESCARGAR EL PDF SIN VISUALIZACION PREVIA
/*$dompdf->loadHtml($BLOQUE_1);
$dompdf->setPaper('A4','L');
$dompdf->render();
$pdf=$dompdf->output();
$dompdf->stream("AvanceFisico.pdf");*/



//CODIGO PARA VISUALIZAR EL PDF
$dompdf->load_html($BLOQUE_1);
$dompdf->setPaper('LEGAL','L');
ini_set("memory_limit", "32M"); 
$dompdf->render();

$nameFile="AvanceFisico_".$fil->codigo.".pdf";
$dompdf->stream($nameFile,array("Attachment" => 0));





/*$bloque1=<<<EOF
<div>$BLOQUE_1</div>
EOF;
$pdf->writeHTML($bloque1,false,false,false,false,'');


$pdf->Output();

//echo $BLOQUE_1;*/

?>


 


















 








