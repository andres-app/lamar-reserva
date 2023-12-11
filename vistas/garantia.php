<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['alquiler']==1) {
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
          <h3 class="card-title">Devolucion de garantias</h3>
          </div>
          <div class="col-sm-6">
            <ol class="float-sm-right">
              <li class="fa fa-dashboard"><a href="escritorio.php"> Escritorio</a>  </li> >
              <li class="fa fa-calendar active"> Garantias</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
 
            <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="text-nowrap table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Garantía</th>
                    <th>Cliente</th>
                    <th>Vehículo</th>
                    <th>Placa</th>
                    <th>Dias</th>
                    <th>Valor/Dia</th>
                    <th>Fecha inicio</th>
                    <th>Fecha entrega</th>
                    <th>Hora entrega</th>
                    <th>Garantía</th>
                    <th>Total pago</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                   <th>Garantía</th>
                    <th>Cliente</th>
                    <th>Vehículo</th>
                    <th>Placa</th>
                    <th>Dias</th>
                    <th>Valor/Dia</th>
                    <th>Fecha inicio</th>
                    <th>Fecha entrega</th>
                    <th>Hora entrega</th>
                    <th>Garantía</th>
                    <th>Total pago</th>
                    <th>Estado</th>
                  </tfoot>   
                </table>
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
 <script src="scripts/garantia.js"></script>
 <?php 
}

ob_end_flush();
  ?>
