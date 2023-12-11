<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['configuracion']==1) {

 ?>
<div class="content-wrapper">
      <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Configuración email</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i>
          </button>
        </div>
    </div>
    <div class="card-body">
      <section class="content">

        <div class="row">
          <div class="col-md-12">
            <div class="box">
      <!--centro-->
            <div class="panel-body table-responsive" id="listadoregistros">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                  <th>Opciones</th>
                  <th>Host (emisor)</th>
                  <th>Usuario</th>
                  <th>Puerto</th>
                  <th>Correo receptor</th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                   <th>Opciones</th>
                  <th>Host (emisor)</th>
                  <th>Usuario</th>
                  <th>Puerto</th>
                  <th>Correo receptor</th>
                </tfoot>   
              </table>
            </div>
            <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <div class="row">
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Host</label>
                      <input class="form-control" type="hidden" name="id" id="id">
                      <input class="form-control" type="text" name="host" id="host" maxlength="50" placeholder="host" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Usuario (emisor)</label>
                      <input class="form-control" type="text" name="usuario" id="usuario" placeholder="usuario" required>
                  </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Contraseña</label>
                      <input class="form-control" type="password" name="clave" id="clave"  placeholder="clave" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Puerto</label>
                      <input class="form-control" type="text" name="puerto" id="puerto"  placeholder="000" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Correo receptor</label>
                      <input class="form-control" type="text" name="receptor" id="receptor"  placeholder="admin@gmail.com" required>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>

                      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                  </div>
                </form>
            </div>
              <!--fin centro-->
            </div>
          </div>
        </div>
           <!-- /.box -->
      </section>
    </div>
  </div>
    <!-- /.content -->
</div>

<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/email.js"></script>
 <?php 
}

ob_end_flush();
  ?>