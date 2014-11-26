<?php
include_once ("C:/AppServ/www/netuno/libreria.php");
include_once ("C:/AppServ/www/netuno/libreriaBD.php");
include_once ("C:/AppServ/www/netuno/libreriaBDPO.php");
include_once ("C:/AppServ/www/netuno/nui.php");

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

set_time_limit(0);
ini_set('memory_limit', -1);
date_default_timezone_set('America/Caracas');

// Obtener los datos de acceso al API
$xDatos = select_sql("select_af_config", "");
$user      = $xDatos[1]['x_Usuario_Api'];
$pass      = $xDatos[1]['x_Passw_Api'];
$wsdl_url  = $xDatos[1]['x_Url_Wsdl'];

$salida = new nui($user,$pass,$wsdl_url);

if (!$salida->logged) {
    goto fin1;
}

//**************************************
// DESBLOQUEO DE CUENTA
//**************************************
// Paso1: Desbloqueo usando llamada al API
$i_account= $_GET['i_account'];
$iter = 1;
//echo "DESBLOQUEO DE CUENTA:" . $i_account . "<br>";
$salida2 = $salida->update_account($i_account, "N", $iter);

if (!$salida2) {
  goto fin3;
}

// Paso2: Actualizar el campo i_Bloqueo y f_Desbloqueo de la tabla af_chequeo_Det_Cuentas
update_sql("update_af_chequeo_Det_Cuentas", array('c_ICuenta'            => $i_account,
                                                  'c_Usuario_Desbloqueo' => $USER_LOGEADO));

goto fin;

fin1:
echo "ERROR de conexion al API" . "<br>";
goto fin;

fin3:
echo "ERROR Desbloqueando al CUENTA" . "<br>";
goto fin;

fin:
?>
