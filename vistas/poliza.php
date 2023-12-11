<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['vehiculo']==1) {
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">

        <div class="card-body">
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row text-sm">
          <div class="col-sm-6">
          <h3 class="card-title">Poliza <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h3>
          </div>
          <div class="col-sm-6">
            <ol class="float-sm-right">
              <li class="fa fa-dashboard"><a href="escritorio.php"> Escritorio</a>  </li> >
              <li class="fa fa-users active"> Poliza</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
 
            <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="text-nowrap table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                  </tfoot>   
                </table>
          </div>

          <div class="panel-body" id="formularioregistros">
          <form action="" name="formulario" id="formulario" method="POST">
            <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Nombre(*)</label>
              <input class="form-control" type="hidden" name="id" id="id">
              <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required onkeyup="mayus(this);" autofocus="autofocus"> 
            </div>
            
            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Contacto</label>
              <input class="form-control" type="text" name="contacto" id="contacto" maxlength="100" placeholder="Contacto" required onkeyup="mayus(this);"> 
            </div>

            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>

              <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
            </div>

            </div>
          </form>
        </div>


        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php';
 ?>
 <script src="scripts/poliza.js"></script>
 <?php 
}

ob_end_flush();
  ?>
