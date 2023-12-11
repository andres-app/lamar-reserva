<?php 
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['clientes']==1) {
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
              <h3 class="card-title">Clientes <button class="btn btn-success btn-sm" id="btnagregar"
                  onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h3>
            </div>
            <div class="col-sm-6">
              <ol class="float-sm-right">
                <li class="fa fa-dashboard"><a href="escritorio.php"> Escritorio</a> </li> >
                <li class="fa fa-users active"> Clientes</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->

        <div class="panel-body table-responsive" id="listadoregistros">
          <table id="tbllistado" class="text-nowrap table table-striped table-bordered table-condensed table-hover">
            <thead>
              <th>Opciones</th>
              <th>Tipo persona</th>
              <th>Nombres</th>
              <th>Documento</th>
              <th>Numero</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Licencia</th>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <th>Opciones</th>
              <th>Tipo persona</th>
              <th>Nombres</th>
              <th>Documento</th>
              <th>Numero</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Licencia</th>
            </tfoot>
          </table>
        </div>

        <div class="panel-body" id="formularioregistros">
          <div class="row">
            <div class="form-group has-success col-lg-6 col-md-6 col-xs-12">
              <label for="">Buscar por DNI...</label>
              <div class="input-group input-group">
                <input class="form-control" type="text" id="dni" name="dni" value="" maxlength="11" autocomplete="off"
                  placeholder="">
                <span class="input-group-btn">
                  <button class="btn btn-success btn-flat hidden-sm" type="submit"
                    onclick="busqueda_dni(); return false">
                    <i class="fa fa-search"></i> Buscar</button>
                </span>
              </div>
            </div>
            <div class="form-group has-success col-lg-6 col-md-6 col-xs-12">
              <label for="">Buscar por RUC...</label>
              <div class="input-group input-group">
                <input class="form-control" type="text" id="ruc" name="ruc" value="" maxlength="11" autocomplete="off"
                  placeholder="">
                <span class="input-group-btn">
                  <button class="btn btn-success btn-flat hidden-sm" type="submit" onclick="busqueda(); return false">
                    <i class="fa fa-search"></i> Buscar</button>
                </span>
              </div>
            </div>
          </div>
          <form action="" name="formulario" id="formulario" method="POST">
            <div class="row">
              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Tipo Persona</label>
                <select class="form-control select-picker" name="tipo_cliente" id="tipo_cliente" data-live-search="true"
                  required>
                  <option value="Natural">Natural</option>
                  <option value="Juridica">Juridica</option>
                </select>
              </div>
              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Nombre</label>
                <input class="form-control" type="hidden" name="idcliente" id="idcliente">
                <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100"
                  placeholder="Nombre del cliente" required onkeyup="mayus(this);" autofocus="autofocus" />
              </div>

              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Apellidos</label>
                <input class="form-control" type="text" name="apellidos" id="apellidos" maxlength="100"
                  placeholder="Apellidos" onkeyup="mayus(this);" />
              </div>

              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Tipo Dcumento</label>
                <select class="form-control select-picker" name="tipo_documento" id="tipo_documento"
                  data-live-search="true" required>

                </select>
              </div>

              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Número Documento</label>
                <input class="form-control" type="text" name="num_documento" id="num_documento" maxlength="20"
                  placeholder="Número de Documento">
              </div>

              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Direccion</label>
                <input class="form-control" type="text" name="direccion" id="direccion" maxlength="70"
                  placeholder="Direccion" onkeyup="mayus(this);">
              </div>

              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Telefono</label>
                <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20"
                  placeholder="Número de Telefono">
              </div>

              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Email</label>
                <input class="form-control" type="email" name="email" id="email" maxlength="50" placeholder="Email"
                  onkeyup="minus(this);">
              </div>

              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">Licencia(*)</label>
                <input class="form-control" type="text" name="licencia" id="licencia" maxlength="50"
                  placeholder="Licencia" required onkeyup="mayus(this);">
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
<?php 
}else{
 require 'noacceso.php'; 
}
require 'footer.php';
 ?>
<script src="scripts/cliente.js"></script>
<?php 
}

ob_end_flush();
  ?>