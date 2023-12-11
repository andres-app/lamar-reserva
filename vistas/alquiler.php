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
          <h3 class="card-title">Alquiler de Vehículos <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h3>
          </div>
          <div class="col-sm-6">
            <ol class="float-sm-right">
              <li class="fa fa-dashboard"><a href="escritorio.php"> Escritorio</a>  </li> >
              <li class="fa fa-calendar active"> Alquiler</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
 
            <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="text-nowrap table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
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
                   <th>Opciones</th>
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

          <div class="panel-body" id="formularioregistros">
          <form action="" name="formulario" id="formulario" method="POST">
            <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Tipo alquiler(*)</label>
            <select class="form-control select-picker" name="tipo" id="tipo" data-live-search="true" required>
                <option value="0">Normal</option>
                <option value="1">Crédito</option>
            </select>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Cliente(*)</label>
                <input class="form-control" type="hidden" name="id" id="id">
                <select class="form-control select-picker" name="idcliente" id="idcliente" data-live-search="true" required>

                </select>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Vehículo(*)</label>
            <select class="form-control select-picker" name="idvehiculo" id="idvehiculo" data-live-search="true" required>

            </select>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Días(*)</label>
              <input class="form-control" type="number" name="dias" id="dias" maxlength="3" onchange="operacion()" required>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Valor por Día(*)</label>
              <input class="form-control" type="number" name="monto_dia" id="monto_dia" step="0.01" maxlength="10" onchange="operacion()" required>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Total pagado</label>
              <input class="form-control" type="text" name="total_pagado" id="total_pagado" placeholder="0" required readonly>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Fecha inicio(*)</label>
              <input class="form-control" type="date" name="f_inicio" id="f_inicio" maxlength="20" required>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Fecha entrega(*)</label>
              <input class="form-control" type="date" name="f_entrega_estimado" id="f_entrega_estimado" maxlength="20" required>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Hora entrega(*)</label>
              <input class="form-control" type="time" name="h_entrega_empresa" id="h_entrega_empresa" required step="1">
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Garantía(*)</label>
              <input class="form-control" type="number" name="garantia" id="garantia" step="0.01" placeholder="0.00" required>
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



<!--modal para agregar devolucion-->

<div class="modal fade" id="Modaldevolucion">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Entrega de alquiler</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>

            </div>
            <form action="" name="formulario_dev" id="formulario_dev" method="POST">
            <div class="modal-body">
            <div class="row">
                <!-- /.form-group -->
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">fecha entrega(*)</label>
                    <input class="form-control" type="hidden" name="idalquiler" id="idalquiler">
                    <input class="form-control" type="hidden" name="idv" id="idv">
                    <input class="form-control" type="date" name="f_entrega_real" id="f_entrega_real" required>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Hora entrega(*)</label>
                    <input class="form-control" type="time" name="h_entrega_cliente" id="h_entrega_cliente">
                </div>
                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                    <label for="">Observacion</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="2"></textarea>
                </div>
                
              </div>
              <!-- /.col -->
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
              <button class="btn btn-primary" type="submit" id="btnGuardar_dev"><i class="fa fa-save"></i>  Guardar</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php';
 ?>
 <script src="scripts/alquiler.js"></script>
 <?php 
}

ob_end_flush();
  ?>
