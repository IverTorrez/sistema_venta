
<div id="back">
  
</div>
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Sistema </b>Ventas</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingresa al Sistema</p>

   

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" id="ingUsuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" id="ingPassword">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="btnlogin" name="btnlogin">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>

     
  
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script type="text/javascript">
  /*================FUNCION LOGIN DEL USUARIO ADMINISTRADOR=================*/
  $(document).ready(function() { 
   $("#btnlogin").on('click', function() {
  
   var formDatalogin = new FormData(); 
   
   var ingUsuario=$('#ingUsuario').val();
   var ingPassword=$('#ingPassword').val();
  
   if ( (ingUsuario=='') ||  (ingPassword=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDatalogin.append('ingUsuario',ingUsuario);
     formDatalogin.append('ingPassword',ingPassword);
     
     
      $.ajax({ url: 'controladores/usuarios.controlador.php', 
               type: 'post', 
               data: formDatalogin, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='usuarios'; }, 2000); swal('Redireccionando','',''); 
                     
                  }
                  else
                  {
                    if (response==2) 
                    {
                       setTimeout(function(){ location.href='productosventa'; }, 2000); swal('Redireccionando','',''); 
                    }
                    else
                    {
                      setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                    }
                    
                                       
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });

</script>