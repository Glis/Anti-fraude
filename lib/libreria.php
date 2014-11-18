<?php

date_default_timezone_set('America/Caracas'); 

/* Constantes */
$AMBIENTE          = 0;                                               // AMBIENTE: 0(Windows), 1(Linux)

$DEBUG             = 1;                                               // Para DEBUG

$RUTA_PHP_WIN      = "c:/AppServ/php6/php.exe";                       // Sentencia Windows
$RUTA_PHP_LIN      = "/usr/bin/php";                                  // Sentencia Linux

$ID_ENV            = "1";                                             // Particion PO

$USER              = "netunoapi";

$VALOR_SI          = 1;                                               // DNIO_SI_NO: Valor Si
$VALOR_NO          = 2;                                               // DNIO_SI_NO: Valor No

$TIPO_PROC_CHEQUEO = 5;                                               // DNIO_TIPO_PROCESO: Proceso de Revision Trafico

$ST_BITACORA_PROC  = 0;                                               // DNIO_ST_BITACORA: Procesando
$ST_BITACORA_OK    = 1;                                               // DNIO_ST_BITACORA: OK
$ST_BITACORA_ERROR = 2;                                               // DNIO_ST_BITACORA: ERROR

$ST_CHEQUEO_PROC   = 0;                                               // DNIO_ST_CHEQUEO: Procesando
$ST_CHEQUEO_OK     = 1;                                               // DNIO_ST_CHEQUEO: OK
$ST_CHEQUEO_ERROR  = 2;                                               // DNIO_ST_CHEQUEO: ERROR

$CACCION_AL        = 1;                                               // DNIO_CLASE_ACCION: Alerta
$CACCION_CU        = 2;                                               // DNIO_CLASE_ACCION: Cuarentena

$NACCION_PLAT      = 1;                                               // DNIO_NIVEL_ACCION: Plataforma
$NACCION_RES       = 2;                                               // DNIO_NIVEL_ACCION: Reseller
$NACCION_CCLASS    = 3;                                               // DNIO_NIVEL_ACCION: Customer Class
$NACCION_CLI       = 4;                                               // DNIO_NIVEL_ACCION: Cliente
$NACCION_CTA       = 5;                                               // DNIO_NIVEL_ACCION: Cuenta


/****************************************************************************************/
/* NOMBRE:       proc_ObtAcciones                                                       */
/****************************************************************************************/
function proc_ObtAcciones ($ArrParams) {
  $NACCION_PLAT      = 1;                                             // DNIO_NIVEL_ACCION: Plataforma
  $NACCION_RES       = 2;                                             // DNIO_NIVEL_ACCION: Reseller
  $NACCION_CCLASS    = 3;                                             // DNIO_NIVEL_ACCION: Customer Class
  $NACCION_CLI       = 4;                                             // DNIO_NIVEL_ACCION: Cliente
  $NACCION_CTA       = 5;                                             // DNIO_NIVEL_ACCION: Cuenta

  if ($ArrParams['nv_Accion']==$NACCION_PLAT) {
    $xAcciones = select_sql("select_af_acc_Plataforma", array('cl_Accion' => $ArrParams['cl_Accion']));

  } elseif ($ArrParams['nv_Accion']==$NACCION_RES) {
    $xAcciones = select_sql("select_af_acc_Resellers", array('cl_Accion'   => $ArrParams['cl_Accion'],
                                                             'c_IReseller' => $ArrParams['c_IReseller']));
  	
  } elseif ($ArrParams['nv_Accion']==$NACCION_CCLASS) {
    $xAcciones = select_sql("select_af_acc_CClass", array('cl_Accion'   => $ArrParams['cl_Accion'],
                                                          'c_IReseller' => $ArrParams['c_IReseller'],
                                                          'c_ICClass'   => $ArrParams['c_ICClass']));
  	
  } elseif ($ArrParams['nv_Accion']==$NACCION_CLI) {
    $xAcciones = select_sql("select_af_acc_Clientes", array('cl_Accion'   => $ArrParams['cl_Accion'],
                                                            'c_IReseller' => $ArrParams['c_IReseller'],
                                                            'c_ICClass'   => $ArrParams['c_ICClass']));

  } elseif ($ArrParams['nv_Accion']==$NACCION_CTA) {
    $xAcciones = select_sql("select_af_acc_Cuentas", array('cl_Accion'   => $ArrParams['cl_Accion'],
                                                           'c_IReseller' => $ArrParams['c_IReseller'],
                                                           'c_ICClass'   => $ArrParams['c_ICClass']));
  }

  $cant = count($xAcciones);
  $i = 1;
    
  while ($i <= $cant) {  	
    // Insertar en tabla AF_LOG_ACCIONES
    $resIns = insert_sql("insert_af_log_Acciones", array('c_IChequeo'    => $ArrParams['c_IChequeo'],
                                                         'c_IDestino'    => $ArrParams['c_IDestino'],
                                                         'cl_Accion'     => $ArrParams['cl_Accion'],
                                                         't_Accion'      => $xAcciones[$i]['t_Accion'],
                                                         'nv_Accion'     => $ArrParams['nv_Accion'],
                                                         'q_Min_Destino' => $ArrParams['q_Min_Destino'],
                                                         'c_IReseller'   => $ArrParams['c_IReseller'],
                                                         'c_ICClass'     => $ArrParams['c_ICClass'],
                                                         'c_ICliente'    => $ArrParams['c_ICliente'],
                                                         'c_ICuenta'     => $ArrParams['c_ICuenta']));
    $i = $i +1;
  }
  
  return "";
}

?>
