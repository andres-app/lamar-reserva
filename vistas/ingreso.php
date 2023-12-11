<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{


require 'header.php';

if ($_SESSION['compras']==1) {
  require_once "../modelos/Negocio.php"; 
  $cnegocio = new Negocio();
  $rsptan = $cnegocio->listar();
  $regn=$rsptan->fetch_object();
  $nombrenegocio=$regn->nombre;
  $smoneda=$regn->simbolo;
  $tipo_impuesto=$regn->nombre_impuesto;

 ?>
  	<div class="content-wrapper">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Ingresos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h3>

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
  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
    <thead>
      <th>Opciones</th>
      <th>Fecha</th>
      <th>Proveedor</th>
      <th>Usuario</th>
      <th>Documento</th>
      <th>Número</th>
      <th>Total Compra</th>
      <th>Estado</th>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
      <th>Opciones</th>
      <th>Fecha</th>
      <th>Proveedor</th>
      <th>Usuario</th>
      <th>Documento</th>
      <th>Número</th>
      <th>Total Compra</th>
      <th>Estado</th>
    </tfoot>   
  </table>
</div>
<div class="panel-body" style="height: 400px;" id="formularioregistros">
  <form action="" name="formulario" id="formulario" method="POST">
    <div class="row">
      <input class="form-control" type="hidden" name="idingreso" id="idingreso">
    <div class="form-group col-lg-8 col-md-8 col-xs-12">
      <label for="">Proveedor(*):</label>
      <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true" required>
        
      </select>
    </div>
      <div class="form-group col-lg-4 col-md-4 col-xs-12">
      <label for="">Fecha(*): </label>
          <div class="input-group">
                <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                   <input class="form-control" type="date" name="fecha_hora" id="fecha_hora" required>
                <!-- /.input group -->
          </div>      
    </div>
     <div class="form-group col-lg-4 col-md-4 col-xs-6">
      <label for="">Tipo Comprobante(*): </label>
     <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" data-live-search="true" required>
      
     </select>
    </div>
     <div class="form-group col-lg-2 col-md-2 col-xs-6">
      <label for="">Serie: </label>
      <input class="form-control" type="text" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
    </div>
     <div class="form-group col-lg-2 col-md-2 col-xs-6">
      <label for="">Número: </label>
      <input class="form-control" type="text" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" required>
    </div>
     <div class="form-group col-lg-4 col-md-4 col-xs-6">
        <label for="">Aplicar Impuesto: </label>
            <div class="input-group">
                <input class="form-control" onchange="modificarSubtotales();" type="text" name="impuesto" id="impuesto">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary">
                      <span class="input-group-addon">%</span>
                    </span>
                </div>
            </div>
                  <!-- /input-group -->
    </div>
    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <a data-toggle="modal" href="#myModal">
       <button id="btnAgregarArt" type="button" class="btn btn-primary"><span class="fa fa-plus"></span>Agregar Articulos</button>
     </a>
    </div>
<div class="form-group col-lg-12 col-md-12 col-xs-12">
     <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
       <thead class="bg-info">
        <th>Opciones</th>
        <th>Articulo</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Precio Venta</th>
        <th>Subtotal</th>
       </thead>
       <tfoot style="background-color:#A9D0F5">
         <th><span>SubTotal</span><br><span id="valor_impuesto"><?php echo $tipo_impuesto; ?> 0.00</span><br><span>TOTAL</span></th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th><span id="total"><?php echo $smoneda; ?> 0.00</span><br><span id="most_imp" maxlength="4">0.00</span><br><span id="most_total">0.00</span><input type="hidden" step="0.01" name="total_compra" id="total_compra"></th> 
       </tfoot>
       <tbody>
         
       </tbody>
     </table>
    </div>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
      <button class="btn btn-danger" onclick="cancelarform()" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

  <!--Modal-->
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Selecciona Articulos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th>Opciones</th>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Código</th>
              <th>Stock</th>
              <th>Imagen</th>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <th>Opciones</th>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Código</th>
              <th>Stock</th>
              <th>Imagen</th>
            </tfoot>
          </table>
          </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>

  <!--modal para ver la venta-->
<div class="modal fade bd-example-modal-lg" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vista de Ingreso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-lg-8 col-md-8 col-xs-12">
                <label for="">Proveedor(*):</label>
                <input class="form-control" type="hidden" name="idingreso" id="idingreso">
                <input class="form-control" type="text" name="idproveedorm" id="idproveedorm" readonly>
          </div>
          <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Fecha(*): </label>
          <div class="input-group">
                <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                   <input class="form-control" type="text" name="fecha_horam" id="fecha_horam" readonly>
                <!-- /.input group -->
          </div> 
         </div>
         <div class="form-group col-lg-4 col-md-4 col-xs-6">
                <label for="">Tipo Comprobante(*): </label>
                <input class="form-control" type="text" name="tipo_comprobantem" id="tipo_comprobantem" readonly>
         </div>
         <div class="form-group col-lg-2 col-md-2 col-xs-6">
                  <label for="">Serie: </label>
                  <input class="form-control" type="text" name="serie_comprobantem" id="serie_comprobantem" maxlength="7" readonly>
         </div>
         <div class="form-group col-lg-2 col-md-2 col-xs-6">
                  <label for="">Número: </label>
                  <input class="form-control" type="text" name="num_comprobantem" id="num_comprobantem" maxlength="10" readonly>
         </div>
         <div class="form-group col-lg-4 col-md-4 col-xs-6">
              <label for="">Impuesto: </label>
            <div class="input-group">
                <input class="form-control" type="text" name="impuestom" id="impuestom" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary">
                      <span class="input-group-addon">%</span>
                    </span>
                </div>
            </div>
         </div>
         <div class="form-group col-lg-12 col-md-12 col-xs-12">
              <table id="detallesm" class="table table-striped table-bordered table-condensed table-hover">
                 <tbody>
                     
                 </tbody>
             </table>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
</div>


  <!-- fin Modal-->
<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/ingreso.js"></script>
 <?php 
}

ob_end_flush();
  ?>