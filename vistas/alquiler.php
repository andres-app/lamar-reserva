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
              <h3 class="card-title">Alquiler de Vehículos <button class="btn btn-success btn-sm" id="btnagregar"
                  onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h3>
            </div>
            <div class="col-sm-6">
              <ol class="float-sm-right">
                <li class="fa fa-dashboard"><a href="escritorio.php"> Escritorio</a> </li> >
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
              <th>Fecha estimada devolucion</th>
              <th>Hora estimada devolucion</th>
              <th>Punto de entrega</th>
              <th>Garantía</th>
              <th>Total pago</th>
              <th>Firma</th>
              <th>DNI frontal</th>
              <th>DNI reverso</th>
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
              <th>Fecha estimada devolucion</th>
              <th>Hora estimada devolucion</th>
              <th>Punto de entrega</th>
              <th>Garantía</th>
              <th>Total pago</th>
              <th>Firma</th>
              <th>DNI frontal</th>
              <th>DNI reverso</th>
              <th>Estado</th>
            </tfoot>
          </table>
        </div>

        <div class="panel-body" id="formularioregistros">
          <form action="" name="formulario" id="formulario" method="POST">
            <div class="row">
              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Tipo alquiler(*)</label>
                <select class="form-control select-picker" name="tipo" id="tipo" data-live-search="true" required>
                  <option value="0">Normal</option>
                  <option value="1">Crédito</option>
                </select>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Cliente(*)</label>
                <select class="form-control select-picker" name="idcliente" id="idcliente" data-live-search="true"
                  required>

                </select>
              </div>

              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Vehículo(*)</label>
                <select class="form-control select-picker" name="idvehiculo" id="idvehiculo" data-live-search="true"
                  required>

                </select>
              </div>

              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Km(*)</label>
                <input class="form-control" type="number" name="km" id="km" required>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Días(*)</label>
                <input class="form-control" type="number" name="dias" id="dias" maxlength="3" onchange="operacion()"
                  required>
              </div>

              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Valor por Día(*)</label>
                <input class="form-control" type="number" name="monto_dia" id="monto_dia" step="0.01" maxlength="10"
                  onchange="operacion()" required>
              </div>

              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Total pagado</label>
                <input class="form-control" type="text" name="total_pagado" id="total_pagado" placeholder="0" required
                  readonly>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Garantía(*)</label>
                <input class="form-control" type="number" name="garantia" id="garantia" step="0.01" placeholder="0.00"
                  required>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Fecha inicio(*)</label>
                <input class="form-control" type="date" name="f_inicio" id="f_inicio" maxlength="20" required>
              </div>

              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Fecha estimada devolucion(*)</label>
                <input class="form-control" type="date" name="f_entrega_estimado" id="f_entrega_estimado" maxlength="20"
                  required>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Hora estimada devolucion(*)</label>
                <input class="form-control" type="time" name="h_entrega_empresa" id="h_entrega_empresa" required
                  step="1">
              </div>

              <div class="form-group col-lg-3 col-md-3 col-xs-12">
                <label for="">Cant. combustible(*)</label>
                <select class="form-control select-picker" name="combustible_al" id="combustible_al"
                  data-live-search="true" required>
                  <option value="1">1/4</option>
                  <option value="2">1/2</option>
                  <option value="3">3/4</option>
                  <option value="4">Full</option>
                </select>
              </div>

              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Punto de entrega(*)</label>
                <input class="form-control" type="text" name="punto_entrega" id="punto_entrega" placeholder="Direccion"
                  required>
              </div>

              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label for="">Observaciones</label>
                <input class="form-control" type="text" name="observaciones_al" id="observaciones_al"
                  placeholder="Observaciones..." required>
              </div>
              <div class="form-group col-lg-12 col-md-12 col-xs-12">
                <div class="card card-success">
                  <div class="card-header">
                    <h3 class="card-title">Accesorios</h3>
                  </div>
                  <div class="card-body">
                    <div class="row" id="accesorios">

                    </div>

                  </div>
                </div>
              </div>

              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                  Guardar</button>

                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                    class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

<!--modal para editar-->

<div class="modal fade" id="ModalEditar">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar alquiler</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

      </div>
      <form action="" name="formulario_editar" id="formulario_editar" method="POST">
        <div class="modal-body">
          <div class="row">
            <!-- /.form-group -->
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Tipo alquiler(*)</label>
              <select class="form-control select-picker" name="tipo_e" id="tipo_e" data-live-search="true" required>
                <option value="0">Normal</option>
                <option value="1">Crédito</option>
              </select>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Cliente(*)</label>
              <input class="form-control" type="hidden" name="id" id="id">
              <select class="form-control select-picker" name="idcliente_e" id="idcliente_e" data-live-search="true"
                required>

              </select>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Vehículo(*)</label>
              <select class="form-control select-picker" name="idvehiculo_e" id="idvehiculo_e" data-live-search="true"
                required>

              </select>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Km(*)</label>
              <input class="form-control" type="number" name="km_e" id="km_e" required>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Días(*)</label>
              <input class="form-control" type="number" name="dias_e" id="dias_e" maxlength="3" onchange="operacion()"
                required>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Valor por Día(*)</label>
              <input class="form-control" type="number" name="monto_dia_e" id="monto_dia_e" step="0.01" maxlength="10"
                onchange="operacion()" required>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Total pagado</label>
              <input class="form-control" type="text" name="total_pagado_e" id="total_pagado_e" placeholder="0" required
                readonly>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Garantía(*)</label>
              <input class="form-control" type="number" name="garantia_e" id="garantia_e" step="0.01" placeholder="0.00"
                required>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Fecha inicio(*)</label>
              <input class="form-control" type="date" name="f_inicio_e" id="f_inicio_e" maxlength="20" required>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Fecha estimada devolucion(*)</label>
              <input class="form-control" type="date" name="f_entrega_estimado_e" id="f_entrega_estimado_e"
                maxlength="20" required>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Hora estimada devolucion(*)</label>
              <input class="form-control" type="time" name="h_entrega_empresa_e" id="h_entrega_empresa_e" required
                step="1">
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Cant. combustible(*)</label>
              <select class="form-control select-picker" name="combustible_al_e" id="combustible_al_e"
                data-live-search="true" required>
                <option value="1">1/4</option>
                <option value="2">1/2</option>
                <option value="3">3/4</option>
                <option value="4">Full</option>
              </select>
            </div>

            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Punto entrega(*)</label>
              <input class="form-control" type="text" name="punto_entrega_e" id="punto_entrega_e" maxlength="90"
                placeholder="Direccion" required>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-xs-12">
              <label for="">Observaciones</label>
              <input class="form-control" type="text" name="observaciones_al_e" id="observaciones_al_e"
                placeholder="Observaciones..." required>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>
            Cancelar</button>
          <button class="btn btn-primary" type="submit" id="btnEditar"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<!--modal para agregar devolucion-->

<div class="modal fade" id="Modaldevolucion">
  <div class="modal-dialog modal-lg">
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
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">fecha devolucion(*)</label>
              <input class="form-control" type="hidden" name="idalquiler" id="idalquiler">
              <input class="form-control" type="hidden" name="idv" id="idv">
              <input class="form-control" type="date" name="f_entrega_real" id="f_entrega_real" required>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Hora devolucion(*)</label>
              <input class="form-control" type="time" name="h_entrega_cliente" id="h_entrega_cliente" step="1">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Dias exedidos (<span id="horas_exedidos"> 0</span>)</label>
              <input class="form-control" type="text" name="dias_exedidos" id="dias_exedidos" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Pago por dias exedidos</label>
              <input class="form-control" type="text" name="pago_exedido" id="pago_exedido" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">KM entrega(*)</label>
              <input class="form-control" type="number" name="km_entrega" id="km_entrega">
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Punto entrega(*)</label>
              <input class="form-control" type="text" name="punto_recepcion" id="punto_recepcion" required>
            </div>

            <div class="form-group col-lg-4 col-md-4 col-xs-12">
              <label for="">Cant. combustible(*)</label>
              <select class="form-control select-picker" name="combustible_dev" id="combustible_dev"
                data-live-search="true" required>
                <option value="1">1/4</option>
                <option value="2">1/2</option>
                <option value="3">3/4</option>
                <option value="4">Full</option>
              </select>
            </div>

            <div class="form-group col-lg-8 col-md-8 col-xs-12">
              <label for="">Observacion</label>
              <textarea name="observaciones" id="observaciones" class="form-control" rows="1"></textarea>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-xs-12">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Accesorios</h3>
                </div>
                <div class="card-body">
                  <div class="row" id="accesorios_dev">

                  </div>

                </div>
              </div>
            </div>

          </div>
          <!-- /.col -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>
            Cancelar</button>
          <button class="btn btn-primary" type="submit" id="btnGuardar_dev"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<!--modal para agregar firma-->

<div class="modal fade" id="Modalfirma">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <!-- /.form-group -->
          <div class="col-lg-12 col-md-12 col-xs-12">

            <input class="form-control" type="hidden" name="idAlquilerf" id="idAlquilerf">

            <div id="signature-pad" class="signature-pad">
              <div class="signature-pad--body">
                <canvas id="capturaFirma"></canvas>
              </div>
              <div class="signature-pad--footer">
                <span>Firma digital</span>

                <div class="signature-pad--actions">
                  <div>
                    <button type="button" class="btn btn-danger" id="fborrar" onclick="limpiar_pad();"><i
                        class="fa fa-trash"></i> Borrar</button>
                  </div>
                  <div>
                    <button type="button" class="btn btn-info" id="fguardar" onclick="guardar_pad();"><i
                        class="fa fa-save"></i> Guardar</button>
                  </div>
                  <div>
                    <button type="button" class="btn btn-success" onclick="resizeCanvas();" id="fhabilitar"><i
                        class="fa fa-check"></i> Activar</button>
                  </div>
                  <div>
                    <button type="button" class="btn btn-danger" onclick="deshabilitar();"><i
                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>

      </div>
      <!-- /.col -->
    </div>
  </div>
  <!-- /.modal-content -->
</div>


<!--modal para agregar dni frontal-->
<div class="modal fade" id="Modaldnia">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">DNI frontal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" name="formulariodnia" id="formulariodnia" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <!-- /.form-group -->
            <div class="form-group col-lg-12 col-md-12 col-xs-12">
              <label for="">Imagen frontal:</label>
              <input class="form-control" type="hidden" name="idalquilerdnia" id="idalquilerdnia">
              <input class="form-control" type="file" name="dni_cliente_anv" id="dni_cliente_anv" required>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>
            Cancelar</button>
          <button class="btn btn-primary" type="submit" id="btnGuardardnia"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!--modal para agregar dni reverso-->
<div class="modal fade" id="Modaldnir">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">DNI reverso</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" name="formulariodnir" id="formulariodnir" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <!-- /.form-group -->
            <div class="form-group col-lg-12 col-md-12 col-xs-12">
              <label for="">Imagen reverso:</label>
              <input class="form-control" type="hidden" name="idalquilerdnir" id="idalquilerdnir">
              <input class="form-control" type="file" name="dni_cliente_rev" id="dni_cliente_rev" required>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>
            Cancelar</button>
          <button class="btn btn-primary" type="submit" id="btnGuardardnir"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!--modal para ver dni-->
<div class="modal fade" id="ModalVerDNI">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">DNI</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center" id="print">
        <div class="row">
          <!-- /.form-group -->


          <div class="form-group col-lg-12 col-md-12 col-xs-12">
            <label for="">Frontal:</label>
            <img src="" class="img-thumbnail" alt="" width="450px" height="250px" id="dnianverso">
          </div>
          <div class="form-group col-lg-12 col-md-12 col-xs-12">
            <label for="">Reverso:</label>
            <img src="" class="img-thumbnail" alt="" width="450px" height="250px" id="dnireverso">
          </div>
        </div>
        <!-- /.col -->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>
          Cancelar</button>
        <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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
<script src="scripts/foto.js"></script>
 <script src="../public/js/moment.min.js"></script>
<script type="text/javascript">
  $('#dni_cliente_anv').filestyle({
    htmlIcon: '<span class="fa fa-folder"></span> ',
    text: 'Seleccionar',
    placeholder: 'DNI frontal',
  });
  $('#dni_cliente_rev').filestyle({
    htmlIcon: '<span class="fa fa-folder"></span> ',
    text: 'Seleccionar',
    placeholder: 'DNI reverso',
  });
</script>


<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39365077-1']);
  _gaq.push(['_trackPageview']);

  (function () {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
  })();
</script>

<script src="../signature_pad/docs/js/signature_pad.umd.js"></script>
<script src="../signature_pad/docs/js/app.js"></script>
<script src="../public/js/jquery.PrintArea.js"></script>
<?php 
}

ob_end_flush();
  ?>