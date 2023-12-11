<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: login.html");
}else{

 
require 'header.php';

if ($_SESSION['escritorio']==1) {
  require_once "../modelos/Negocio.php";
  $cnegocio = new Negocio();
  $rsptan = $cnegocio->listar();
  if (empty($rsptan)) {
    $nombrenegocio='Configurar datos de su Empresa';
    $smoneda='Simbolo de moneda';
    $logo='inserta un logo';
  }else{
    $regn=$rsptan->fetch_object();
    $nombrenegocio=$regn->nombre;
    $smoneda=$regn->simbolo;
    $logo=$regn->logo;
  };
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();

  $rsptalqui = $consulta->totalalquiler();
  if(empty($rsptalqui)){
    $talqui='0';   
  }else{
    $regalqui=$rsptalqui->fetch_object();
  $talqui=$regalqui->total_alquiler;
  }

  $rsptac = $consulta->totaldisponibles();
  if(empty($rsptac)){
    $vdisponibles='0';   
  }else{
    $regc=$rsptac->fetch_object();
  $vdisponibles=$regc->total_disponibles;
  }
  
  $rsptav = $consulta->totalalquilados();
  if(empty($rsptav)){
    $valquilados='0';   
  }else{
    $regv=$rsptav->fetch_object();
    $valquilados=$regv->total_alquilados;
  }

  $rsptacli = $consulta->totalalclientes();
  if(empty($rsptacli)){
    $tclientes='0';   
  }else{
    $regcli=$rsptacli->fetch_object();
    $tclientes=$regcli->total_clientes;
  }

  //obtener valores para cargar al grafico de barras
  $alquiler10 = $consulta->alquilerultimos_10dias();
  if(empty($alquiler10)){
    $fechasc='';
    $totalesc='';  
  }else{
    $fechasc='';
    $totalesc='';
    while ($regfechac=$alquiler10->fetch_object()) {
      $fechasc=$fechasc.'"'.$regfechac->fecha.'",';
      $totalesc=$totalesc.$regfechac->total.',';
    }
      //quitamos la ultima coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0,-1); 
  }


    //obtener valores para cargar al grafico de barras
  $alquiler12m = $consulta->alquilerultimos_12meses ();
  if(empty($alquiler12m)){
    $fechasv='';
    $totalesv='';
  }else{
    $fechasv='';
    $totalesv='';
  while ($regfechav=$alquiler12m->fetch_object()) {
    $fechasv=$fechasv.'"'.$regfechav->fecha.'",';
    $totalesv=$totalesv.$regfechav->total.',';
  }
  //quitamos la ultima coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0,-1);
}
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

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h4 style="font-size: 17px;">
                                <strong><?php echo $smoneda.' '.$talqui; ?> </strong>
                            </h4>
                            <p>Alquiler</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <a href="alquiler" class="small-box-footer">Alquiler <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h4 style="font-size: 17px;">
                                <strong><?php echo $tclientes; ?> </strong>
                            </h4>
                            <p>Clientes</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <a href="cliente" class="small-box-footer">Clientes <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h4 style="font-size: 17px;">
                                <strong><?php echo $vdisponibles; ?> </strong>
                            </h4>
                            <p>Vehiculos disponibles</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-car" aria-hidden="true"></i>
                        </div>
                        <a href="vehiculo" class="small-box-footer">Vehiculos <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h4 style="font-size: 17px;">
                                <strong><?php echo $valquilados; ?> </strong>
                            </h4>
                            <p>Vehiculos alquilados</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-car" aria-hidden="true"></i>
                        </div>
                        <a href="vehiculo" class="small-box-footer">Vehiculos <i
                                class="fa fa-arrow-circle-right"></i></a>
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
                                    <h3 class="card-title">Alquiler en los ultimos 10 dias</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="alquiler10" width="300" height="200"></canvas>
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
                                    <h3 class="card-title">Alquiler en los ultimos 12 meses</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="alquier12m" width="300" height="200"></canvas>
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
        var ctx = document.getElementById("alquiler10").getContext('2d');
        var alquiler10 = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo $fechasc ?>],
                datasets: [{
                    label: '# Alquiler en los últimos 10 dias',
                    data: [<?php echo $totalesc ?>],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        '#E74C3C',
                        '#3498DB',
                        '#F4D03F',
                        '#E67E22',
                        '#BDC3C7',
                        '#1A5276',
                        '#E74C3C',
                        '#3498DB',
                        '#F4D03F',
                        '#E67E22',
                        '#BDC3C7',
                        '#1A5276'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        var ctx = document.getElementById("alquier12m").getContext('2d');
        var alquier12m = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo $fechasv ?>],
                datasets: [{
                    label: '# Alquiler en los últimos 12 meses',
                    data: [<?php echo $totalesv ?>],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        '#E74C3C',
                        '#3498DB',
                        '#F4D03F',
                        '#E67E22',
                        '#BDC3C7',
                        '#1A5276',
                        '#E74C3C',
                        '#3498DB',
                        '#F4D03F',
                        '#E67E22',
                        '#BDC3C7',
                        '#1A5276'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
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