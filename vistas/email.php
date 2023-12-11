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
<div class="content-wrapper">
      <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Correos enviados</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fa fa-times"></i>
          </button>
        </div>
    </div>
    <div class="card-body">
      <section class="content">

        <div class="row">
          <div class="col-md-12">
            <div class="box">
      <!--centro-->
            <div class="panel-body table-responsive" id="listadoregistros">
              <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                <th>Opcion</th>
                  <th>Fecha</th>
                  <th>Asunto</th>
                  <th>Mensaje</th>
                  <th>Estado</th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <th>Opcion</th>
                  <th>Fecha</th>
                  <th>Asunto</th>
                  <th>Mensaje</th>
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
    <!-- /.content -->
</div>

<?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="scripts/email_enviados.js"></script>
 <?php 
}

ob_end_flush();
  ?>