<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema | Sistema</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="vistas/img/plantilla/logo-icono.jpg">
   <!--=============================== PLUGIN CSS=================================================-->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- AlerSwit -->
  <link rel="stylesheet" href="vistas/plugins/alertsweet/sweet-alert.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="vistas/dist/css/select2.min.css">



   <!--===================================0PLUGIN JS ================================-->
  <!-- jQuery 3 -->
<script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="vistas/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- AlertSwit -->
<script src="vistas/plugins/alertsweet/sweet-alert.min.js"></script>
<!-- AdminLTE for demo purposes 
<script src="vistas/dist/js/demo.js"></script>-->
<!-- Select2 -->
<script src="vistas/dist/js/select2.full.min.js"></script>



</head>
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
<!-- Site wrapper -->


<?php
if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"]== "ok") {
  # code...

      echo'<div class="wrapper">';
      // MODULO CABEZOTE
      include "modulos/cabezote.php";
      // MODULO MENU
      include "modulos/menu.php";


              // MODULO CONTENIDO
              if (isset($_GET["ruta"])) {
                 if ($_GET["ruta"] =="inicio" || 
                     $_GET["ruta"] == "usuarios" ||
                     $_GET["ruta"] == "categorias" ||
                     $_GET["ruta"] == "marcas" ||
                     $_GET["ruta"] == "administradores" ||
                     $_GET["ruta"] == "proveedores" ||
                     $_GET["ruta"] == "productos" ||
                     $_GET["ruta"] == "productosventa" ||
                      $_GET["ruta"] == "clientes" ||
                      $_GET["ruta"] == "compras" ||
                     $_GET["ruta"] == "crear-ventas" ||
                     $_GET["ruta"] == "crear-ventas01" || /*pagina de prueba para venta*/
                      $_GET["ruta"] == "crear-ventas-nueva" ||
                     $_GET["ruta"] == "reporte-ventas" ||
                     $_GET["ruta"] == "reporte-inventario" ||
                     $_GET["ruta"] == "inventario-reporte" ||
                     $_GET["ruta"] == "reporte-ganacias"||
                     $_GET["ruta"] == "sucursales"||
                     $_GET["ruta"] == "trn-enviadas"||
                     $_GET["ruta"] == "trn-recibidas"||
                     $_GET["ruta"] == "mis-ventas"||
                     $_GET["ruta"] == "cierre-cajas"||
                     $_GET["ruta"] == "reporte-compras"||
                     $_GET["ruta"] == "reporte-compras"||
                     $_GET["ruta"] == "almacen"||
                     $_GET["ruta"] == "salir" ) {
                   include "modulos/".$_GET['ruta'].".php";

                 }else
                   {
                     include "modulos/404.php";
                   }
              }else
                {
                  include "modulos/inicio.php";
                }


      // MODULO foter
      include "modulos/footer.php";
      echo '</div>';
      //<!-- ./wrapper -->
}
else
{
  include "modulos/login.php";
}
?>



<script src="vistas/js/plantilla.js"></script>
</body>
</html>
<script type="text/javascript">
   $(function () {
     //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
