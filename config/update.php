<?php 
require_once(dirname(__FILE__,2) . '/config/Conexion.php');

//ACTUALIZA LA TABLA CLIENTE(AGREGA NUESVOS CAMPOS)
/*$upd_alquiler="ALTER TABLE alquiler ADD COLUMN dni_cliente_anv VARCHAR(45) NULL, 
               ADD COLUMN dni_cliente_rev VARCHAR(45) NULL,
               ADD COLUMN firma_cliente VARCHAR(45) NULL 
               AFTER combustible_dev";

$updt=ejecutarUpdate($upd_alquiler);
if($updt==1){
    echo 'La base datos se actualizó correctamente';
    $sql="SHOW COLUMNS FROM alquiler";
    $res=ejecutarUpdate($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {                
            echo $row['Field'].'<br/>';
        }
    }

}else{
    echo $updt; 
}*/


//ACTUALIZA LA BASE DE DATOS(AGREGA TABLA PROVEEDOR)
/*$add_proveedor = "CREATE table proveedor (
    id INt PRIMARY KEY AUTO_INCREMENT,
    tipo_documento VARCHAR(5) NOT NULL,
    num_documento VARCHAR(20) NOT NULL,
    nombres VARCHAR(64) NOT NULL,
    email VARCHAR(45) NOT NULL,
    telefono VARCHAR(45) NOT NULL,
    marca_vehiculo VARCHAR(45) NOT NULL,
    placa_vehiculo VARCHAR(20) NOT NULL,
    modelo_vehiculo VARCHAR(20) NOT NULL
    )";
$addProveedor=ejecutarUpdate($add_proveedor);
if($addProveedor==1){
    echo 'La base datos se actualizó correctamente';
    $add_proveedor="SHOW COLUMNS FROM proveedor";
    $res=ejecutarUpdate($add_proveedor);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {                
            echo $row['Field'].'<br/>';
        }
    }

}else{
    echo $addProveedor; 
}*/

echo 'La base datos se actualizó correctamente';
