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
          <h3 class="card-title">Datos de la Empresa <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h3>

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
  <table id="tbllistado" class="text-nowrap  table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Opcion</th>
      <th>logo</th>
      <th>Nombre</th>
      <th>Documento</th>
      <th>Direccion</th>
      <th>Telefono</th>
      <th>E-mail</th>
      <th>Pais/Ciudad</th>
      <th>Impuesto</th>
      <th>Moneda</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
     <th>Opcion</th>
      <th>logo</th>
      <th>Nombre</th>
      <th>Documento</th>
      <th>Direccion</th>
      <th>Telefono</th>
      <th>E-mail</th>
      <th>Pais/Ciudad</th>
      <th>Impuesto</th>
      <th>Moneda</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
  	<div class="row">
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Logo(*):</label>
      <input class="form-control" type="file" name="logo" id="logo">
      <input type="hidden" name="logoactual" id="logoactual">
      <img src="" alt="" width="150px" height="120" id="logomuestra">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombre(*):</label>
      <input class="form-control" type="hidden" name="id_negocio" id="id_negocio">
      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Nombre del documento:(*)</label>
      <input class="form-control" type="text" name="ndocumento" placeholder="NRT - NIF" id="ndocumento"  required >
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Documento:(*)</label>
      <input class="form-control" type="text" name="documento" id="documento"  required>
    </div>
    <div class="form-group col-lg-12 col-md-12 col-xs-12">
      <label for="">Dirección(*):</label>
      <input class="form-control" type="text" name="direccion" id="direccion" maxlength="256" placeholder="Dirección" required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Pais:</label>
      <input class="form-control" type="text" name="pais" id="pais">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Telefono(*):</label>
      <input class="form-control" type="text" name="telefono" id="telefono"  required>
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">E-mail:</label>
      <input class="form-control" type="email" name="email" id="email">
    </div>
    <div class="form-group col-lg-6 col-md-6 col-xs-12">
      <label for="">Ciudad:</label>
      <input class="form-control" type="text" name="ciudad" id="ciudad" >
    </div>
    <div class="form-group col-lg-12 col-md-12 col-xs-12">
      <label for="">Datos Financieros</label>
    </div>
    <div class="form-group col-lg-3 col-md-3 col-xs-12">
      <label for="">Nombre Imp:</label>
      <input class="form-control" type="text" name="nombre_impuesto" id="nombre_impuesto" placeholder="IVA - IGV" >
    </div>
    <div class="form-group col-lg-3 col-md-3 col-xs-12">
      <label for="">Monto (%):</label>
      <input class="form-control" type="text" name="monto_impuesto" id="monto_impuesto" >
    </div>
    <div class="form-group col-lg-3 col-md-3 col-xs-12">
      <label for="">Moneda:</label>
      <input class="form-control" type="text" name="moneda" id="moneda" placeholder="dolare - euros" >
    </div>
    <div class="form-group col-lg-3 col-md-3 col-xs-12">
      <label for="">Simbolo:</label>
      <input class="form-control" type="text" name="simbolo" id="simbolo" placeholder="$ - €" >
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
      <!-- /.card -->
    <!-- /.content -->
 	</div>

<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php'
 ?>
 <script src="scripts/negocio.js"></script>

 <?php 
}

ob_end_flush();
  ?>