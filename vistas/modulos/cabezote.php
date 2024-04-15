<?php
error_reporting(E_ERROR);
if ($_SESSION["usuarioAdmin"]!="") 
{
  $datosUsuario=$_SESSION["usuarioAdmin"];
  $nombreUser=$datosUsuario["nombre_administrador"];
  $iduseractual=$datosUsuario["id_administrador"];
  $_SESSION["tipouser"]="admin";
}
if ($_SESSION["usuarioEmp"]!="") 
{
  $datosUsuario=$_SESSION["usuarioEmp"];
  $nombreUser=$datosUsuario["nombre_empleado"];
  $iduseractual=$datosUsuario["id_empleado"];
  $_SESSION["tipouser"]="empl";
}

?>
<header class="main-header">
	<!--============================
		LOGOTIPO
		=============================-->
	
   <a href="" class="logo">
   	<!---logo mini-->
   	  <span class="logo-mini">
   	  	<img src="vistas/img/plantilla/logosonido-mini.jpg" class="img-responsive" style="padding: 10px; ">
   	  </span>
   	<!---logo normal-->
   	  <span class="logo-lg">
   	  	<img src="vistas/img/plantilla/logosonido-normal.jpg" class="img-responsive" style="padding: 10px 0px">
   	  </span>

   </a>


 <!--============================
		BARRA DE NAVEGACION
  =============================-->
  <nav class="navbar navbar-static-top" role="navigation">
  	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
  		<span class="sr-only">Toggle navigation</span>
  		<!-- <span class="icon-bar"></span>
  		<span class="icon-bar"></span>
  		<span class="icon-bar"></span> -->
  	</a>


  	<!-- PERFILES DE USUARIO -->
  	<div class="navbar-custom-menu">
  		 <ul class="nav navbar-nav">
  		 	<li class="dropdown user user-menu">
  		 		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
  		 			<img src="vistas/img/usuarios/img-admin.png" class="user-image">
  		 			<span class="hidden-xs">Usuario: <?php echo $nombreUser; ?></span>
  		 			
  		 		</a>
  		 		<!-- Dropdown-toggle -->
				  	<ul class="dropdown-menu">
				  		<li class="user-body">
				  			<div class="pull-right">
				  				<a href="salir" class="btn btn-default btn-float">Salir</a>
				  				
				  			</div>
				  			
				  		</li>
				  		
				  	</ul>
  		 		
  		 	</li>
  		 	
  		 </ul>
  		
  	</div>


  	
  	 
  </nav>
	
</header>