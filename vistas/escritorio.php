<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

 
require 'header.php';

if ($_SESSION['escritorio']==1) {
  /*require_once "../modelos/Negocio.php";
  $cnegocio = new Negocio();
  $rsptan = $cnegocio->listar();
  $regn=$rsptan->fetch_object();
  if (empty($regn)) {
    $nombrenegocio='Configurar datos de su Empresa';
    $smoneda='Simbolo de moneda';
    $logo='inserta un logo';
  }else{
    $nombrenegocio=$regn->nombre;
    $smoneda=$regn->simbolo;
    $logo=$regn->logo;
  };
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();
  $rsptac = $consulta->totalcomprahoy();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total_compra;*/

  /*$rsptav = $consulta->totalventahoy();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total_venta;*/

  //obtener valores para cargar al grafico de barras
  /*$compras10 = $consulta->comprasultimos_10dias();
  $fechasc='';
  $totalesc='';
  while ($regfechac=$compras10->fetch_object()) {
    $fechasc=$fechasc.'"'.$regfechac->fecha.'",';
    $totalesc=$totalesc.$regfechac->total.',';
  }
  //quitamos la ultima coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0,-1);*/
    //obtener valores para cargar al grafico de barras
  /*$ventas12 = $consulta->ventasultimos_12meses ();
  $fechasv='';
  $totalesv='';
  while ($regfechav=$ventas12->fetch_object()) {
    $fechasv=$fechasv.'"'.$regfechav->fecha.'",';
    $totalesv=$totalesv.$regfechav->total.',';
  }*/


  //quitamos la ultima coma
  //$fechasv=substr($fechasv, 0, -1);
  //$totalesv=substr($totalesv, 0,-1);
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h4 style="font-size: 17px;">
                  <strong><?php echo $smoneda.' '.$totalc; ?> </strong>
                </h4>
                <p>Compras</p>
              </div>
              <div class="icon">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
              </div>
              <a href="ingreso.php" class="small-box-footer">Compras <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h4 style="font-size: 17px;">
                  <strong><?php echo $smoneda.' '.$totalv; ?> </strong>
                </h4>
                <p>Ventas</p>
              </div>
              <div class="icon">
                 <i class="fa fa-shopping-cart" aria-hidden="true"></i>
              </div>
              <a href="venta.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent text-center">
                <h3 class="card-title"><?php echo $nombrenegocio; ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-2">
                <div class="row">             
            <!-- compras de los ultimos 10 dias -->
            <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Compras de los ultimos 10 dias</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="compras"  width="300" height="200"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            </div>
            <!-- /.card -->

            <!-- ventas de los ultimos 12 mese -->
            <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Ventas de los ultimos 12 meses</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="ventas" width="300" height="200"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            </div>
             </div>
            <!-- /.card -->
              <!-- /.card-body -->
              <div class="card-footer clearfix">
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
}else{
 require 'noacceso.php'; 
}

require 'footer.php';
 ?>
 <script src="../public/js/Chart.bundle.min.js"></script>
 <script src="../public/js/Chart.min.js"></script>

 <script>
var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php //echo $fechasc ?>],
        datasets: [{
            label: '# Compras en <?php //echo $smoneda ?> de los últimos 10 dias',
            data: [<?php //echo $totalesc ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                 'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php //echo $fechasv ?>],
        datasets: [{
            label: '# Ventas en <?php //echo $smoneda ?> de los últimos 12 meses',
            data: [<?php //echo $totalesv ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                 'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                 'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

 <?php 
}

ob_end_flush();
  ?>