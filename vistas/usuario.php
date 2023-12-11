<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

require 'header.php';
if ($_SESSION['acceso']==1) {
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
          <h3 class="card-title">Usuarios <button class="btn btn-success btn-sm" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i>Agregar</button></h3>
          </div>
          <div class="col-sm-6">
            <ol class="float-sm-right">
              <li class="fa fa-dashboard"><a href="escritorio.php"> Escritorio</a>  </li> >
              <li class="fa fa-users active"> Usuarios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->

            <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="text-nowrap table table-striped table-bordered table-condensed table-hover">
					<thead>
					<th>Opciones</th>
					<th>Nombre</th>
					<th>Documento</th>
					<th>Numero Documento</th>
					<th>Telefono</th>
					<th>Email</th>
					<th>Login</th>
					<th>Foto</th>
					<th>Estado</th>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
					<th>Opciones</th>
					<th>Nombre</th>
					<th>Documento</th>
					<th>Numero Documento</th>
					<th>Telefono</th>
					<th>Email</th>
					<th>Login</th>
					<th>Foto</th>
					<th>Estado</th>
					</tfoot>
                </table>
          </div>

		  <div class="panel-body" id="formularioregistros">
		  <form action="" name="formulario" id="formulario" method="POST">
		  	<div class="row">
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Nombre(*):</label>
		      <input class="form-control" type="hidden" name="idusuario" id="idusuario">
		      <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Tipo Documento(*):</label>
		     <select name="tipo_documento" id="tipo_documento" class="form-control select-picker" required>
		       <option value="DNI">DNI</option>
		       <option value="RUC">RUC</option>
		       <option value="CEDULA">CEDULA</option>
		     </select>
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Numero de Documento(*):</label>
		      <input type="text" class="form-control" name="num_documento" id="num_documento" placeholder="Documento" maxlength="20">
		    </div>
		       <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Direccion</label>
		      <input class="form-control" type="text" name="direccion" id="direccion"  maxlength="70">
		    </div>
		       <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Telefono</label>
		      <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="Número de telefono">
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Email: </label>
		      <input class="form-control" type="email" name="email" id="email" maxlength="70" placeholder="email">
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Cargo</label>
		      <input class="form-control" type="text" name="cargo" id="cargo" maxlength="20" placeholder="Cargo">
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Login(*):</label>
		      <input class="form-control" type="text" name="login" id="login" maxlength="20" placeholder="nombre de usuario" required>
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12" id="claves">
		      <label for="">Clave(*):</label>
		      <input class="form-control" type="password" name="clave" id="clave" maxlength="64" placeholder="Clave">
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label>Permisos</label>
		      <ul id="permisos" style="list-style: none;">

		      </ul>
		    </div>
		    <div class="form-group col-lg-6 col-md-6 col-xs-12">
		      <label for="">Imagen:</label>
		      <input class="form-control" type="file" name="imagen" id="imagen">
		      <input type="hidden" name="imagenactual" id="imagenactual">
		      <img src="" alt="" width="150px" height="120" id="imagenmuestra">
		    </div>
		    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
		      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
		      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
		    </div>
		    </div>
		  </form>
		</div>
		<div class="panel-body" id="formulario_clave">
		  <form action="" name="formularioc" id="formularioc" method="POST">
		       <div class="form-group">
		            <label for="recipient-name" class="col-form-label">Nueva clave:</label>
		            <input class="form-control" type="hidden" name="idusuarioc" id="idusuarioc">
		            <input class="form-control" type="password" name="clavec" id="clavec" maxlength="64" placeholder="Clave">
		       </div>
		       <button class="btn btn-primary" type="submit" id="btnGuardar_clave"><i class="fa fa-save"></i>  Guardar</button>
		      <button class="btn btn-danger" onclick="cancelarform_clave()" type="button" ><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
 <script src="scripts/usuario.js"></script>
 <script type="text/javascript">
			$('#imagen').filestyle({
				htmlIcon : '<span class="fa fa-folder"></span> ',
				text: 'Seleccionar',
				placeholder : 'Seleccione su foto',
			});
		</script>
 <?php
}

ob_end_flush();
  ?>
