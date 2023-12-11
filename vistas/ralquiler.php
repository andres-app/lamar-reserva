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
                            <h3 class="card-title">Alquileres devueltos</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="float-sm-right">
                                <li class="fa fa-dashboard"><a href="escritorio.php"> Escritorio</a> </li> >
                                <li class="fa fa-calendar active"> devuelto</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->

                <div class="panel-body table-responsive" id="listadoregistros">
                    <table id="tbllistado"
                        class="text-nowrap table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <th>Contrato</th>
                            <th>Alquiler</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Placa</th>
                            <th>Dias</th>
                            <th>Valor/Dia</th>
                            <th>Fecha inicio</th>
                            <th>Fecha estimada devolucion</th>
                            <th>Fecha devolucion real</th>
                            <th>Hora estimada de devolución</th>
                            <th>Hora devolucion real</th>
                            <th>Punto de entrega</th>
                            <th>Punto de recepcion</th>
                            <th>Garantía</th>
                            <th>Dias exedidos</th>
                            <th>Pago por dias exedidos</th>
                            <th>Total pago</th>
                            <th>Total a pagar</th>
                            <th>Estado garantía</th>
                            <th>Estado alquiler</th>
                            <th>Observaciones</th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <th>Contrato</th>
                            <th>Alquiler</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Placa</th>
                            <th>Dias</th>
                            <th>Valor/Dia</th>
                            <th>Fecha inicio</th>
                            <th>Fecha estimada devolucion</th>
                            <th>Fecha devolucion real</th>
                            <th>Hora estimada de devolución</th>
                            <th>Hora devolucion real</th>
                            <th>Punto de entrega</th>
                            <th>Punto de recepcion</th>
                            <th>Garantía</th>
                            <th>Dias exedidos</th>
                            <th>Pago por dias exedidos</th>
                            <th>Total pago</th>
                            <th>Total a pagar</th>
                            <th>Estado garantía</th>
                            <th>Estado alquiler</th>
                            <th>Observaciones</th>
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
<script src="scripts/ralquiler.js"></script>
<?php 
}

ob_end_flush();
  ?>