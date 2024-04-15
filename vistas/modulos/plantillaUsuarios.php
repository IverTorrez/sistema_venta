<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Usuarios
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar usuarios</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
            Agregar usuario
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Usuario</th>
                  <th>Contraseña</th>
                  <th>Estado</th>
                  <th>Acciones</th>

                </tr>
             </thead>

             <tbody>
               <tr>
                 <td>1</td>
                 <td>Andres</td>
                 <td>Suares</td>
                 <td>andres1</td>
                 <td>andres1</td>
                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
               </tr>
             </tbody>
          </table>
        </div>

        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->  
  </div>
  <!-- /.content-wrapper -->

  <!--MODAL PARA AGREGAR USUSARIOS -->
   <!-- Modal -->
<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <form role="form" method="post" >
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar usuario</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar nombre" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoApellido" placeholder="Ingresar apellido" required="">
              </div>  
            </div>


            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar telefono" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoUsuario" placeholder="Ingresar usuario" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoPassword" placeholder="Ingresar contraseña" required="">
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" >Guardar</button>
      </div>
      </form>
    </div>

  </div>
</div>

