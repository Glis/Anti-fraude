<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
include_once "lib/libreriaBDPO.php";
include_once "lib/libreria.php";
include_once "lib/libreriaBD.php";




if($_GET['type'] == 'calidad_destino'){

	header('Content-disposition: attachment; filename=rep_CalidadDestino_'.str_replace('-', '', $_GET['desde']). "_" 
												   .str_replace('-', '', $_GET['hasta']). "_"
												   .gmdate('YmdHis'));
	header('Content-type: text/plain');

	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$reseller = $_GET['reseller'] == '' ? 'NULL' : $_GET['reseller'];
	$cclass = $_GET['cclass'] == '' ? 'NULL' : $_GET['cclass'];
	$destino = $_GET['destino'];

	$data = array('f_Inicio' => $desde, 'f_Fin' => $hasta, 'i_Env' => $ID_ENV, 'c_IReseller' => $reseller, 
		'c_ICClass' => $cclass, 'destination' => $destino );


	$res = select_PO_sql('select_repCalidadDestino', $data);


	echo "RESELLER|CUSTOMERCLASS|CUSTOMER|ACCOUNT|COUNTRY|DESTINATION|DISCONNECT_CAUSE|LLAMADAS|MINUTOS";
	echo "\r\n";
	$k = 1;
	$cant = count($res);
	while ($k <= $cant) { 
		echo $res[$k]['reseller']."|".
			$res[$k]['customerclass']."|".
			$res[$k]['customer']."|".
			$res[$k]['account']."|".
			$res[$k]['country']."|".
			$res[$k]['destination']."|".
			$res[$k]['disconnect_cause']."|".
			$res[$k]['llamadas']."|".
			$res[$k]['minutos'];
		echo "\r\n";
		$k++;

	}
}

if($_GET['type'] == 'minutos_destino'){

	header('Content-disposition: attachment; filename=rep_MinDestino_'.str_replace('-', '', $_GET['desde']). "_" 
												   .str_replace('-', '', $_GET['hasta']). "_"
												   .gmdate('YmdHis'));
	header('Content-type: text/plain');

	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$reseller = $_GET['reseller'] == '' ? 'NULL' : $_GET['reseller'];
	$cclass = $_GET['cclass'] == '' ? 'NULL' : $_GET['cclass'];
	$destino = $_GET['destino'];

	$data = array('f_Inicio' => $desde, 'f_Fin' => $hasta, 'i_Env' => $ID_ENV, 'c_IReseller' => $reseller, 
		'c_ICClass' => $cclass, 'destination' => $destino );


	$res = select_PO_sql('select_repMinDestino', $data);


	echo "RESELLER|CUSTOMERCLASS|COUNTRY|DESTINATION|LLAMADAS|MINUTOS";
	echo "\r\n";
	$k = 1;
	$cant = count($res);
	while ($k <= $cant) { 
		echo $res[$k]['reseller']."|".
			$res[$k]['customerclass']."|".
			$res[$k]['country']."|".
			$res[$k]['destination']."|".
			$res[$k]['llamadas']."|".
			$res[$k]['minutos'];
		echo "\r\n";
		$k++;

	}
}

if($_GET['type'] == 'clientes_bloq'){

	header('Content-disposition: attachment; filename=rep_ClientesBloqueados_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	
	$reseller = $_GET['reseller'] == '' ? 'NULL' : $_GET['reseller'];
	

	$data = array('c_IReseller' => $reseller);


	$res = select_sql('select_repClientesBloq', $data);

	echo "CUSTOMER|COUNTRY|DESTINATION|COD_CHEQUEO|ALERTA?|CUARENTENA?|FECHA_BLOQUEO";
	echo "\r\n";
	$k = 1;
	$cant = count($res);
	while ($k <= $cant) { 
		$cus = $_SESSION['customersList'][$res[$k]['c_icliente']]['name'];
		$country = $_SESSION['countriesList'][$_SESSION['destinosList'][$res[$k]['c_idestino'].""]['country']]['name'];
		$dest = $_SESSION['destinosList'][$res[$k]['c_idestino'].""]['description'];

		echo $cus."|".
			$country."|".
			$dest."|".
			$res[$k]['c_ichequeo']."|".
			$res[$k]['alerta']."|".
			$res[$k]['cuarentena']."|".
			$res[$k]['f_Bloqueo'];
		echo "\r\n";
		$k++;

	}
}

if($_GET['type'] == 'cuentas_bloq'){

	header('Content-disposition: attachment; filename=rep_CuentasBloqueadas_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	$reseller = $_GET['reseller'] == '' ? 'NULL' : $_GET['reseller'];

	$data = array('c_IReseller' => $reseller);


	$res = select_sql('select_repCuentasBloq', $data);


	echo "CUSTOMER|ACCOUNT|DESTINATION|COD_CHEQUEO|ALERTA?|CUARENTENA?|FECHA_BLOQUEO";
	echo "\r\n";
	$k = 1;
	$cant = count($res);
	while ($k <= $cant) { 
		$cus = $_SESSION['customersList'][$res[$k]['c_icliente']]['name'];
		$acc = $_SESSION['accountsList'][$res[1]['account']]['id'];
		$dest = $_SESSION['destinosList'][$res[$k]['c_idestino'].""]['description'];

		echo $cus."|".
			$acc."|".
			$dest."|".
			$res[$k]['c_ichequeo']."|".
			$res[$k]['alerta']."|".
			$res[$k]['cuarentena']."|".
			$res[$k]['f_Bloqueo'];
		echo "\r\n";
		$k++;

	}
}

if ($_GET['type'] == 'CDR_destinos') {
	
	header('Content-disposition: attachment; filename=CDRsDestPlat_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	// Obtener el rango de fechas de la ventana de chequeo
	$ID_CHEQUEO = $_GET['c_chequeo'];
	$C_IDESTINO = $_GET['c_dest'];

	$xChequeo = select_sql("select_af_chequeo2", array('c_IChequeo' => $ID_CHEQUEO));
	$fInicioVent = $xChequeo[1]['f_Inicio_Vent'];
	$fFinVent    = $xChequeo[1]['f_Fin_Vent'];

	$xCDrsPl = select_PO_sql("select_CDRsDestPlat", array('f_Inicio_Vent'     => $fInicioVent,
	                                                      'f_Fin_Vent'        => $fFinVent,
	                                                      'i_Env'             => $ID_ENV,
	                                                      'c_IDestino'        => $C_IDESTINO));
	$cant_xCDrsPl = count($xCDrsPl);
	$i = 1;
	echo "Cantidad: " . $cant_xCDrsPl;
	echo "\r\n";
	echo 'I_CUSTOMER|CUSTOMER_NAME|ACCOUNT_ID|CLI|CLD|I_DEST|COUNTRY|DESCRIPTION|CONNECT_TIME|DISCONNECT_TIME|CHARGED_AMOUNT|CHARGED_QUANTITY|USED_QUANTITY|CALL_ID';
	echo "\r\n";
	while ($i <= $cant_xCDrsPl) {
		echo $xCDrsPl[$i]['i_customer']           . '|' . 
	       $xCDrsPl[$i]['customer_name']        . '|' . 
	       $xCDrsPl[$i]['account_id']           . '|' . 
	       $xCDrsPl[$i]['cli']                  . '|' . 
	       $xCDrsPl[$i]['cld']                  . '|' . 
	       $xCDrsPl[$i]['i_dest']               . '|' . 
	       $xCDrsPl[$i]['country']              . '|' . 
	       $xCDrsPl[$i]['description']          . '|' . 
	       $xCDrsPl[$i]['connect_time']         . '|' . 
	       $xCDrsPl[$i]['disconnect_time']      . '|' . 
	       $xCDrsPl[$i]['charged_amount']       . '|' . 
	       $xCDrsPl[$i]['charged_quantity']     . '|' . 
	       $xCDrsPl[$i]['used_quantity']        . '|' . 
	       $xCDrsPl[$i]['call_id'];
	    echo "\r\n";
	  
	  $i++;;
	}

}

if ($_GET['type'] == 'CDR_resellers') {
	
	header('Content-disposition: attachment; filename=CDRsDestRes_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	// Parametros
	$ID_CHEQUEO = $_GET['c_chequeo'];
	$C_IDESTINO  = $_GET['c_dest'];
	$C_IRESELLER = $_GET['c_reseller'];

	// Obtener el rango de fechas de la ventana de chequeo
	$xChequeo = select_sql("select_af_chequeo2", array('c_IChequeo' => $ID_CHEQUEO));
	$fInicioVent = $xChequeo[1]['f_Inicio_Vent'];
	$fFinVent    = $xChequeo[1]['f_Fin_Vent'];

	$xCDrsPl = select_PO_sql("select_CDRsDestRes", array('f_Inicio_Vent'     => $fInicioVent,
	                                                     'f_Fin_Vent'        => $fFinVent,
	                                                     'i_Env'             => $ID_ENV,
	                                                     'c_IDestino'        => $C_IDESTINO,
	                                                     'c_IReseller'       => $C_IRESELLER));
	$cant_xCDrsPl = count($xCDrsPl);
	$i = 1;
	echo "Cantidad: " . $cant_xCDrsPl;
	echo "\r\n";
	echo 'I_CUSTOMER|CUSTOMER_NAME|ACCOUNT_ID|CLI|CLD|I_DEST|COUNTRY|DESCRIPTION|CONNECT_TIME|DISCONNECT_TIME|CHARGED_AMOUNT|CHARGED_QUANTITY|USED_QUANTITY|CALL_ID';
	echo "\r\n";
	while ($i <= $cant_xCDrsPl) {
	  echo $xCDrsPl[$i]['i_customer']           . '|' . 
	       $xCDrsPl[$i]['customer_name']        . '|' . 
	       $xCDrsPl[$i]['account_id']           . '|' . 
	       $xCDrsPl[$i]['cli']                  . '|' . 
	       $xCDrsPl[$i]['cld']                  . '|' . 
	       $xCDrsPl[$i]['i_dest']               . '|' . 
	       $xCDrsPl[$i]['country']              . '|' . 
	       $xCDrsPl[$i]['description']          . '|' . 
	       $xCDrsPl[$i]['connect_time']         . '|' . 
	       $xCDrsPl[$i]['disconnect_time']      . '|' . 
	       $xCDrsPl[$i]['charged_amount']       . '|' . 
	       $xCDrsPl[$i]['charged_quantity']     . '|' . 
	       $xCDrsPl[$i]['used_quantity']        . '|' . 
	       $xCDrsPl[$i]['call_id']; 
	   echo "\r\n"; 
	  $i++;
	}

}


if ($_GET['type'] == 'CDR_cclass') {
	
	header('Content-disposition: attachment; filename=CDRsDestCClass_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	// Parametros
	$ID_CHEQUEO = $_GET['c_chequeo'];
	$C_IDESTINO  = $_GET['c_dest'];
	$C_IRESELLER = $_GET['c_reseller'];
	$C_ICCLASS   = $_GET['c_cclass'];

	// Obtener el rango de fechas de la ventana de chequeo
	$xChequeo = select_sql("select_af_chequeo2", array('c_IChequeo' => $ID_CHEQUEO));
	$fInicioVent = $xChequeo[1]['f_Inicio_Vent'];
	$fFinVent    = $xChequeo[1]['f_Fin_Vent'];

	$xCDrsPl = select_PO_sql("select_CDRsDestCClass", array('f_Inicio_Vent'     => $fInicioVent,
	                                                        'f_Fin_Vent'        => $fFinVent,
	                                                        'i_Env'             => $ID_ENV,
	                                                        'c_IDestino'        => $C_IDESTINO,
	                                                        'c_IReseller'       => $C_IRESELLER,
	                                                        'c_ICClass'         => $C_ICCLASS));
	$cant_xCDrsPl = count($xCDrsPl);
	$i = 1;
	echo "Cantidad: " . $cant_xCDrsPl;
	echo 'I_CUSTOMER|CUSTOMER_NAME|ACCOUNT_ID|CLI|CLD|I_DEST|COUNTRY|DESCRIPTION|CONNECT_TIME|DISCONNECT_TIME|CHARGED_AMOUNT|CHARGED_QUANTITY|USED_QUANTITY|CALL_ID';
	echo "\r\n";
	while ($i <= $cant_xCDrsPl) {
	  echo $xCDrsPl[$i]['i_customer']           . '|' . 
	       $xCDrsPl[$i]['customer_name']        . '|' . 
	       $xCDrsPl[$i]['account_id']           . '|' . 
	       $xCDrsPl[$i]['cli']                  . '|' . 
	       $xCDrsPl[$i]['cld']                  . '|' . 
	       $xCDrsPl[$i]['i_dest']               . '|' . 
	       $xCDrsPl[$i]['country']              . '|' . 
	       $xCDrsPl[$i]['description']          . '|' . 
	       $xCDrsPl[$i]['connect_time']         . '|' . 
	       $xCDrsPl[$i]['disconnect_time']      . '|' . 
	       $xCDrsPl[$i]['charged_amount']       . '|' . 
		   $xCDrsPl[$i]['charged_quantity']     . '|' . 
		   $xCDrsPl[$i]['used_quantity']        . '|' . 
		   $xCDrsPl[$i]['call_id'];
	  echo "\r\n";
	  
	  $i++;
	}

}

if ($_GET['type'] == 'CDR_clientes') {
	
	header('Content-disposition: attachment; filename=CDRsDestCli_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	// Parametros
	$ID_CHEQUEO = $_GET['c_chequeo'];
	$C_IDESTINO  = $_GET['c_dest'];
	$C_IRESELLER = $_GET['c_reseller'];
	$C_ICCLASS   = $_GET['c_cclass'];
	$C_ICLIENTE  = $_GET['c_cliente'];

	// Obtener el rango de fechas de la ventana de chequeo
	$xChequeo = select_sql("select_af_chequeo2", array('c_IChequeo' => $ID_CHEQUEO));
	$fInicioVent = $xChequeo[1]['f_Inicio_Vent'];
	$fFinVent    = $xChequeo[1]['f_Fin_Vent'];

	$xCDrsPl = select_PO_sql("select_CDRsDestCli", array('f_Inicio_Vent'     => $fInicioVent,
	                                                     'f_Fin_Vent'        => $fFinVent,
	                                                     'i_Env'             => $ID_ENV,
	                                                     'c_IDestino'        => $C_IDESTINO,
	                                                     'c_IReseller'       => $C_IRESELLER,
	                                                     'c_ICClass'         => $C_ICCLASS,
	                                                     'c_ICliente'        => $C_ICLIENTE));
	$cant_xCDrsPl = count($xCDrsPl);
	$i = 1;
	echo "Cantidad: " . $cant_xCDrsPl;
	echo "\r\n";
	echo 'I_CUSTOMER|CUSTOMER_NAME|ACCOUNT_ID|CLI|CLD|I_DEST|COUNTRY|DESCRIPTION|CONNECT_TIME|DISCONNECT_TIME|CHARGED_AMOUNT|CHARGED_QUANTITY|USED_QUANTITY|CALL_ID';
	echo "\r\n";
	while ($i <= $cant_xCDrsPl) {
	  echo $xCDrsPl[$i]['i_customer']           . '|' . 
	       $xCDrsPl[$i]['customer_name']        . '|' . 
	       $xCDrsPl[$i]['account_id']           . '|' . 
	       $xCDrsPl[$i]['cli']                  . '|' . 
	       $xCDrsPl[$i]['cld']                  . '|' . 
	       $xCDrsPl[$i]['i_dest']               . '|' . 
	       $xCDrsPl[$i]['country']              . '|' . 
	       $xCDrsPl[$i]['description']          . '|' . 
	       $xCDrsPl[$i]['connect_time']         . '|' . 
	       $xCDrsPl[$i]['disconnect_time']      . '|' . 
	       $xCDrsPl[$i]['charged_amount']       . '|' . 
		   $xCDrsPl[$i]['charged_quantity']     . '|' . 
		   $xCDrsPl[$i]['used_quantity']        . '|' . 
		   $xCDrsPl[$i]['call_id'];
	  echo "\r\n";
	  
	  $i++;
	}

}

if ($_GET['type'] == 'CDR_cuentas') {
	
	header('Content-disposition: attachment; filename=CDRsDestCta_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	// Parametros
	$ID_CHEQUEO = $_GET['c_chequeo'];
	$C_IDESTINO  = $_GET['c_dest'];
	$C_IRESELLER = $_GET['c_reseller'];
	$C_ICCLASS   = $_GET['c_cclass'];
	$C_ICLIENTE  = 102;
	$C_ICUENTA   = 278;

	// Obtener el rango de fechas de la ventana de chequeo
	$xChequeo = select_sql("select_af_chequeo2", array('c_IChequeo' => $ID_CHEQUEO));
	$fInicioVent = $xChequeo[1]['f_Inicio_Vent'];
	$fFinVent    = $xChequeo[1]['f_Fin_Vent'];

	$xCDrsPl = select_PO_sql("select_CDRsDestCta", array('f_Inicio_Vent'     => $fInicioVent,
	                                                     'f_Fin_Vent'        => $fFinVent,
	                                                     'i_Env'             => $ID_ENV,
	                                                     'c_IDestino'        => $C_IDESTINO,
	                                                     'c_IReseller'       => $C_IRESELLER,
	                                                     'c_ICClass'         => $C_ICCLASS,
	                                                     'c_ICliente'        => $C_ICLIENTE,
	                                                     'c_ICuenta'         => $C_ICUENTA));
	$cant_xCDrsPl = count($xCDrsPl);
	$i = 1;
	echo "Cantidad: " . $cant_xCDrsPl;
	echo "\r\n";
	echo 'I_CUSTOMER|CUSTOMER_NAME|ACCOUNT_ID|CLI|CLD|I_DEST|COUNTRY|DESCRIPTION|CONNECT_TIME|DISCONNECT_TIME|CHARGED_AMOUNT|CHARGED_QUANTITY|USED_QUANTITY|CALL_ID';
	echo "\r\n";
	while ($i <= $cant_xCDrsPl) {
	  echo $xCDrsPl[$i]['i_customer']           . '|' . 
	       $xCDrsPl[$i]['customer_name']        . '|' . 
	       $xCDrsPl[$i]['account_id']           . '|' . 
	       $xCDrsPl[$i]['cli']                  . '|' . 
	       $xCDrsPl[$i]['cld']                  . '|' . 
	       $xCDrsPl[$i]['i_dest']               . '|' . 
	       $xCDrsPl[$i]['country']              . '|' . 
	       $xCDrsPl[$i]['description']          . '|' . 
	       $xCDrsPl[$i]['connect_time']         . '|' . 
	       $xCDrsPl[$i]['disconnect_time']      . '|' . 
	       $xCDrsPl[$i]['charged_amount']       . '|' . 
		   $xCDrsPl[$i]['charged_quantity']     . '|' . 
		   $xCDrsPl[$i]['used_quantity']        . '|' . 
		   $xCDrsPl[$i]['call_id'];
		echo "\r\n";
	  
	  $i++;
	}

}

?>