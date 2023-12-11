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
      <h3 class="card-title">Tipo de Documentos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h3>

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
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Estado</th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                   <th>Opciones</th>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Estado</th>
                </tfoot>   
              </table>
            </div>
            <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                  <div class="row">
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Nombre</label>
                      <input class="form-control" type="hidden" name="iddocumentos" id="iddocumentos">
                      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                      <label for="">Descripcion</label>
                      <input class="form-control" type="text" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripcion">
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
 <script src="scripts/documentos.js"></script>
 <?php 
}

ob_end_flush();
  ?>