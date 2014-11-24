<?php
include_once "lib/libreriaBDPO.php";
include_once "lib/libreria.php";




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


	echo "RESELLER|CUSTOMERCLASS|CUSTOMER|ACCOUNT|COUNTRY|DESTINATION|DISCONNECT_CAUSE|LLAMADAS|MINUTOS
";
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
			$res[$k]['minutos']."
";
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


	echo "RESELLER|CUSTOMERCLASS|COUNTRY|DESTINATION|LLAMADAS|MINUTOS
";
	$k = 1;
	$cant = count($res);
	while ($k <= $cant) { 
		echo $res[$k]['reseller']."|".
			$res[$k]['customerclass']."|".
			$res[$k]['country']."|".
			$res[$k]['destination']."|".
			$res[$k]['llamadas']."|".
			$res[$k]['minutos']."
";
		$k++;

	}
}

if($_GET['type'] == 'clientes_bloq'){

	header('Content-disposition: attachment; filename=rep_ClientesBloqueados_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$reseller = $_GET['reseller'] == '' ? 'NULL' : $_GET['reseller'];
	$cclass = $_GET['cclass'] == '' ? 'NULL' : $_GET['cclass'];
	$destino = $_GET['destino'];

	$data = array('f_Inicio' => $desde, 'f_Fin' => $hasta, 'i_Env' => $ID_ENV, 'c_IReseller' => $reseller, 
		'c_ICClass' => $cclass, 'destination' => $destino );


	$res = select_PO_sql('select_repClientesBloq', $data);


	echo "CUSTOMER|COUNTRY|DESTINATION|COD_CHEQUEO|ALERTA?|CUARENTENA?|FECHA_BLOQUEO
";
	$k = 1;
	$cant = count($res);
	while ($k <= $cant) { 
		echo $res[$k]['reseller']."|".
			$res[$k]['customerclass']."|".
			$res[$k]['country']."|".
			$res[$k]['destination']."|".
			$res[$k]['llamadas']."|".
			$res[$k]['minutos']."
";
		$k++;

	}
}

if($_GET['type'] == 'cuentas_bloq'){

	header('Content-disposition: attachment; filename=rep_CuentasBloqueadas_'.gmdate('YmdHis'));
	header('Content-type: text/plain');

	$desde = $_GET['desde'];
	$hasta = $_GET['hasta'];
	$reseller = $_GET['reseller'] == '' ? 'NULL' : $_GET['reseller'];
	$cclass = $_GET['cclass'] == '' ? 'NULL' : $_GET['cclass'];
	$destino = $_GET['destino'];

	$data = array('f_Inicio' => $desde, 'f_Fin' => $hasta, 'i_Env' => $ID_ENV, 'c_IReseller' => $reseller, 
		'c_ICClass' => $cclass, 'destination' => $destino );


	$res = select_PO_sql('select_repCuentasBloq', $data);


	echo "CUSTOMER|ACCOUNT|DESTINATION|COD_CHEQUEO|ALERTA?|CUARENTENA?|FECHA_BLOQUEO
";
	$k = 1;
	$cant = count($res);
	while ($k <= $cant) { 
		echo $res[$k]['reseller']."|".
			$res[$k]['customerclass']."|".
			$res[$k]['country']."|".
			$res[$k]['destination']."|".
			$res[$k]['llamadas']."|".
			$res[$k]['minutos']."
";
		$k++;

	}
}

?>