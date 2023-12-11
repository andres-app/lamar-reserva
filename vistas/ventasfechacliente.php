<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['consultav']==1) {

 ?>
  	<div class="content-wrapper">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Consulta de Ventas por Fecha</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
 <section class="content">

      <!-- Default box -->
      <div class="row">
        <div class="col-md-12">
      <div class="box">
<!--box-header-->
<!--centro-->
<div class="panel-body table-responsive" id="listadoregistros">
	<div class="row">
  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <label>Fecha Inicio</label>
    <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
  </div>
  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <label>Fecha Fin</label>
    <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
  </div>
  <div class="form-inline col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <label>Cliente</label>
    <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true" required>
    </select>
    <br>
    <button class="btn btn-success" onclick="listar()"> Mostrar</button>
  </div>
</div>
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Fecha</th>
      <th>Usuario</th>
      <th>Cliente</th>
      <th>Comprobante</th>
      <th>Número</th>
      <th>Total Ventas</th>
      <th>Impuesto</th>
      <th>Estado</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Fecha</th>
      <th>Usuario</th>
      <th>Proveedor</th>
      <th>Comprobante</th>
      <th>Número</th>
      <th>Total Compra</th>
      <th>Impuesto</th>
      <th>Estado</th>
    </tfoot>   
  </table>
</div>

<!--fin centro-->
      </div>
      </div>
      </div>
      <!-- /.box -->

    </section>
        </div>
      </div>
      <!-- /.card -->
    <!-- /.content -->
 	</div>

<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/ventasfechacliente.js"></script>
 <?php 
}

ob_end_flush();
  ?>