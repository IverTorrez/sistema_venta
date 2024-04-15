<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">

          
             
			<li class="active">
				<a href="inicio">
					<i class="fa fa-home"></i>
					<span>Inicio</span>
				</a>
				
			</li>

  <!--======================= Registros de usuarios ===============================-->
  <?php
  if ($_SESSION["tipo_user"]=="admin") 
  {
  ?>
  		<li class="treeview">
				<a href="">
					<i class="fa fa fa-users"></i>
					<span>Usuarios</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li>
						<a href="usuarios">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Usuarios</span>
						</a>
					</li>

					<li>
						<a href="clientes">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Clientes</span>
						</a>
					</li>
					<li>
						<a href="proveedores">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Proveedores</span>
						</a>
					</li>
					
					
				</ul>
				
			</li>
             <!--./treeview -->

   <!-- ---==============Registros============================================  -->
			<li class="treeview">
				<a href="">
					<i class="fa fa-registered"></i>
					<span>Registros</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li>
						<a href="marcas">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Marcas</span>
						</a>
					</li>

					<li>
						<a href="categorias">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Categorias</span>
						</a>
					</li>
					<li>
						<a href="almacen">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Almacen</span>
						</a>
					</li>

					<!-- <li>
						<a href="sucursales">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Sucursales</span>
						</a>
					</li> -->
					
					
				</ul>
				
			</li>
             <!--./treeview -->

 <!--============================Registros de productos================-->
			<li class="treeview">
				<a href="">
					<i class="fa fa-product-hunt"></i>
					<span>Productos</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li>
						<a href="productos">
							<i class="fa fa-circle-o"></i>
							<span>Reg.  Productos</span>
						</a>
					</li>

					<li>
						<a href="">
							<i class="fa fa-circle-o"></i>
							<span>Reportes</span>
						</a>
					</li>
					
					
				</ul>
				
			</li>
             <!--./treeview -->

 
<!--====================================Registros de Compras======================= -->
			<li class="treeview">
				<a href="">
					<i class="fa fa-cart-arrow-down"></i>
					<span>Compras</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li>
						<a href="compras">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Compras</span>
						</a>
					</li>

					<li>
						<a href="reporte-compras">
							<i class="fa fa-circle-o"></i>
							<span>Reportes</span>
						</a>
					</li>		
				</ul>
			</li>
             <!--./treeview -->

          

<?php
  }
 ?>
 			<li class="treeview">
				<a href="">
					<i class="fa fa-bar-chart"></i>
					<span>Reportes</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<!-- REPORTE PARA EL ADMINISTRADOR -->
					<?php
                    if ($_SESSION["tipo_user"]=="admin") 
                    {
                    ?>
                     <li>
						<a href="reporte-inventario">
							<i class="fa fa-circle-o"></i>
							<span>Rep. Inventario</span>
						</a>
					</li>

					<li>
						<a href="reporte-ganacias">
							<i class="fa fa-circle-o"></i>
							<span>Rep. de Ganancias</span>
							
						</a>
					</li>

                    <?php	
                    }
                    else
                    {
                    ?>
                    <!-- REPORTE PARA LOS EMPLEADOS -->
					<li>
						<a href="inventario-reporte">
							<i class="fa fa-circle-o"></i>
							<span>Rep. Inventario</span>
						</a>
					</li>	

					<li>
						<a href="inventario-reporte">
							<i class="fa fa-circle-o"></i>
							<span>Rep. Mis ventas</span>
						</a>
					</li>	

                    <?php
                    }
					?>
					
                    	
				</ul>
			</li>





			<li class="treeview">
				<a href="">
					<i class="fa fa-fw fa-exchange"></i>
					<span>Intercambios</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<!-- REPORTE PARA EL ADMINISTRADOR -->
					<?php
                    if ($_SESSION["tipo_user"]=="admin") 
                    {
                    ?>
                 <!--    <li>
						<a href="trn-enviadas">
							<i class="fa fa-circle-o"></i>
							<span>Enviados</span>
						</a>
					</li>

					<li>
						<a href="trn-recibidas">
							<i class="fa fa-circle-o"></i>
							<span>Recividos</span>
							
						</a>
					</li>-->

                    <?php	
                    }
                    else
                    {
                    ?>
                    <!-- REPORTE PARA LOS EMPLEADOS -->
					<li>
						<a href="inventario-reporte">
							<i class="fa fa-circle-o"></i>
							<span>Reporte Inventario</span>
						</a>
					</li>	

                    <?php
                    }
					?>
					
                    	
				</ul>
			</li>
             <!--./treeview -->



	  <!--  <li class="">
				<a href="reporte-inventario">
					<i class="fa fa-bar-chart"></i>
					<span>Reporte Inventario</span>
				</a>				
	  </li> -->

			<li class="">
				<a href="productosventa">
					<i class="fa fa-product-hunt"></i>
					<span>Productos Venta</span>
				</a>
       <?php
       // $datosUsuario=$_SESSION["usuarioEmp"];
        if ($datosUsuario["permiso_especial"]==1)
        {
        	
       ?>
				<ul class="treeview-menu">
					<li>
						<a href="productos">
							<i class="fa fa-circle-o"></i>
							<span>Reg.  Productos</span>
						</a>
					</li>

					<li>
						<a href="">
							<i class="fa fa-circle-o"></i>
							<span>Reportes</span>
						</a>
					</li>
							
				</ul>

				<!--====================================Registros de Compras para empleados======================= -->
			<li class="treeview">
				<a href="">
					<i class="fa fa-cart-arrow-down"></i>
					<span>Compras</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li>
						<a href="compras">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Compras</span>
						</a>
					</li>

					<li>
						<a href="reporte-compras">
							<i class="fa fa-circle-o"></i>
							<span>Reportes</span>
						</a>
					</li>		
				</ul>
			</li>
				<?php
       
        }
       ?>
				
			</li>
            

			

			

			<li class="treeview">
				<a href="">
					<i class="fa fa-list-ul"></i>
					<span>Ventas</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li>
						<a href="crear-ventas-nueva">
							<i class="fa fa-circle-o"></i>
							<span>Reg. Ventas</span>

						</a>
					</li>

					<?php
                    if ($_SESSION["tipo_user"]=="admin") 
                    {
                    ?>
					
					<li>
						<a href="reporte-ventas">
							<i class="fa fa-circle-o"></i>
							<span>Reportes de Ventas</span>
							
						</a>
					</li>

					<!--<li>
						<a href="cierre-cajas">
							<i class="fa fa-circle-o"></i>
							<span>Cierre de caja</span>
							
						</a>
					</li>
					<li>
						<a href="reporte-cierre">
							<i class="fa fa-circle-o"></i>
							<span>Reporte de cierres</span>
							
						</a>
					</li>-->
					<?php
				    }
					?>
          <li>
						<a href="mis-ventas">
							<i class="fa fa-circle-o"></i>
							<span>Mis Ventas</span>

						</a>
					</li>
					
					
				</ul>
				
			</li>
             <!--./treeview -->
       <?php
       if ($_SESSION["tipo_user"]=="admin") 
        {
        ?>
       <li class="treeview">
				<a href="">
					<i class="fa fa-database"></i>
					<span>Backup de datos</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>

				<ul class="treeview-menu">
					<li>
						<a href="respaldos/myphp-backup.php" target="_blank">
							<i class="fa fa-circle-o"></i>
							<span>Generar Backup</span>
						</a>
					</li>
					<!--<li>
						<a href="">
							<i class="fa fa-circle-o"></i>
							<span>Reportes</span>
						</a>
					</li>	-->	
				</ul>
			</li>
			<?php
				 }
			?>

			
			
		</ul>
		
	</section>
	
</aside>