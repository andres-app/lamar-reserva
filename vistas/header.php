 <?php 
if (strlen(session_id())<1) 
  session_start();
require_once "../modelos/Negocio.php";
  $cnegocio = new Negocio();
  $rsptan = $cnegocio->listar();
  $regn=$rsptan->fetch_object();
  if (empty($regn)) {
    $nombrenegocio='Configurar datos de su Empresa';
    $logo='';

  }else{
    $nombrenegocio=$regn->nombre;
    $logo=$regn->logo;
  };

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

 <title><?php echo $nombrenegocio; ?> | Sis</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../public/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->

 <link rel="stylesheet" type="text/css" href="../public/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!-- Theme style -->
   
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="../public/img/gestion.svg">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <!-- DATATABLES -->
  <link rel="stylesheet" href="../public/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/datatables/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/datatables/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link href="../public/plugins/iCheck/flat/blue.css" rel="stylesheet">
    <link href="../public/plugins/datepicker/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../public/dist/css/bootstrap-select.min.css">

</head>
<body class="hold-transition sidebar-mini text-sm">
<!--<body class="sidebar-mini layout-fixed control-sidebar-slide-open sidebar-closed sidebar-collapse text-sm">-->
<!--<body class="sidebar-mini layout-fixed control-sidebar-slide-open text-sm sidebar-open">-->


<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark bg-primary border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="escritorio.php" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="alquiler.php" class="nav-link">Alquiler</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="vehiculo.php" class="nav-link">Vehículo</a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="fa fa-user-o"> 
           <?php echo $_SESSION['nombre']; ?></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          <div class="dropdown-divider"></div>
          <div class="dropdown-item">
            <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
            <?php echo $_SESSION['nombre']; ?>
          </div>
          <div class="dropdown-divider"></div>
          <div class="dropdown-item">
          <a href="../ajax/usuario.php?op=salir" class="btn btn-block btn-secondary"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
        </div>
      </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link bg-primary">
       <?php echo "<img src='../files/negocio/".$logo."' alt='AdminLTE Logo' class='brand-image img-circle elevation-3'
           style='opacity: .8'>" ; ?>
      
      <span class="brand-text font-weight-light"><?php echo $nombrenegocio; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle elevation-2" alt="usuario imagen">
            </div>
            <div class="info">
              <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
            </div>
          </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class-->

       <?php 
          if ($_SESSION['escritorio']==1) {
              echo '<li class="nav-item has-treeview menu-open">
                      <a href="../vistas/escritorio.php" class="nav-link active">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                          Escritorio
                        </p>
                      </a>
                    </li>';
              }
      ?>
      <?php 
        if ($_SESSION['clientes']==1) {
          echo '<li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-users"></i>
                    <p>
                      Clientes
                      <i class="fa fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="../vistas/cliente.php" class="nav-link">
                        <i class="fa fa-circle-o nav-icon"></i>
                        <p>Clientes</p>
                      </a>
                    </li>

                  </ul>
                </li>';
            }
      ?>

 <?php 
  if ($_SESSION['alquiler']==1) {
    echo ' <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-calendar"></i>
              <p>
                Alquiler
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../vistas/alquiler.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Alquiler</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../vistas/garantia.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Garantías</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="../vistas/ralquiler.php" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Reporte</p>
              </a>
            </li>
            </ul>
          </li>';
    }
?>

<?php 
  if ($_SESSION['vehiculo']==1) {
    echo '<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-car"></i>
              <p>
                Autos/Vehículo
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="../vistas/vehiculo.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Vehículos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../vistas/tipo_vehiculo.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Tipo Vehículo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../vistas/marca_vehiculo.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Marca vehículo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../vistas/modelo_vehiculo.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Modelo vehículo</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="../vistas/poliza.php" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Poliza</p>
              </a>
            </li>
            </ul>
          </li>';
    }
?>  
          
<?php 
  if ($_SESSION['acceso']==1) {
    echo '<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-key"></i>
              <p>
                Acceso
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../vistas/usuario.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../vistas/permiso.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Permiso</p>
                </a>
              </li>
            </ul>
          </li>';
    }
?>
          
<?php 
  if ($_SESSION['configuracion']==1) {
   echo '<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Configuración
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../vistas/negocio.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Datos Generales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../vistas/doc.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Doc</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../vistas/documentos.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Documentos</p>
                </a>
              </li>
            </ul>
          </li>';
    }
?> 
<li class="nav-header">Consultas</li>       
<?php 
  if ($_SESSION['consultac']==1) {
    echo '  <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-bar-chart"></i>
              <p>
                Consulta Alquiler
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../vistas/alquilerfecha.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Alquiler por fecha</p>
                </a>
              </li>
            </ul>
          </li>';
    }
?> 
          
<?php 
  if ($_SESSION['consultav']==1) {
    echo '<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-bar-chart"></i>
              <p>
                Consultas
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../vistas/consltafechacliente.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Consulta de por fechas</p>
                </a>
              </li>
            </ul>
          </li>';
    }
?>
           
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-th"></i>
              <p>
                Ayuda
                <span class="right badge badge-warning">pdf</span>
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>