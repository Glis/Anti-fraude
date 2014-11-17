<?php include_once "libreriaBD_portaone.php" ?>
<?php include_once "libreriaBD.php" ?>
<?php
session_start();

$pagina = $_POST['pag'];

switch ($pagina) {
	case 'reportes_usuario':
		$_SESSION['filtros'] = $_POST['valor'];
		if($_POST['valor'] == 'vacio')$_SESSION['filtros']="";
		break;

	case 'resellers_usuario':
		$_SESSION['filtros'] = $_POST['valor'];
		if($_POST['valor'] == 'vacio')$_SESSION['filtros']="";
		break;

	case 'config_reportes':
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'vacio')$_SESSION['filtros']="";
		break;
	
	case 'acc_cclass':
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";

		if($_POST['clase_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['clase_accion']="";
		}else{		
			$_SESSION['filtros_acc']['clase_accion'] = $_POST['clase_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['tipo_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['tipo_accion']="";
		}else{		
			$_SESSION['filtros_acc']['tipo_accion'] = $_POST['tipo_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_acc']['reseller']="";
		}else{		
			$_SESSION['filtros_acc']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['cclass'] == 'vacio'){
			$_SESSION['filtros_acc']['cclass']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_acc']['cclass'] = $_POST['cclass'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;
	
	case 'acc_clientes':
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";

		if($_POST['clase_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['clase_accion']="";
		}else{		
			$_SESSION['filtros_acc']['clase_accion'] = $_POST['clase_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['tipo_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['tipo_accion']="";
		}else{		
			$_SESSION['filtros_acc']['tipo_accion'] = $_POST['tipo_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_acc']['reseller']="";
		}else{		
			$_SESSION['filtros_acc']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['cclass'] == 'vacio'){
			$_SESSION['filtros_acc']['cclass']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_acc']['cclass'] = $_POST['cclass'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;
	
	case 'acc_cuentas':
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";

		if($_POST['clase_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['clase_accion']="";
		}else{		
			$_SESSION['filtros_acc']['clase_accion'] = $_POST['clase_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['tipo_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['tipo_accion']="";
		}else{		
			$_SESSION['filtros_acc']['tipo_accion'] = $_POST['tipo_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_acc']['reseller']="";
		}else{		
			$_SESSION['filtros_acc']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['cclass'] == 'vacio'){
			$_SESSION['filtros_acc']['cclass']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_acc']['cclass'] = $_POST['cclass'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;
	
	case 'acc_plataforma':
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
		break;
	
	case 'acc_resellers':

		
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";

		if($_POST['clase_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['clase_accion']="";
		}else{		
			$_SESSION['filtros_acc']['clase_accion'] = $_POST['clase_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['tipo_accion'] == 'vacio'){
			$_SESSION['filtros_acc']['tipo_accion']="";
		}else{		
			$_SESSION['filtros_acc']['tipo_accion'] = $_POST['tipo_accion'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_acc']['reseller']="";
		}else{		
			$_SESSION['filtros_acc']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;

	case 'umb_destinos':
		if($_POST['valor'] == 'vacio'){
			$_SESSION['filtros_umb_dest']="";
		}else{
			$res = select_sql_PO('select_i_destino_where', array($_POST['valor']));
			$_SESSION['filtros_umb_dest'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}
		
		break;

	case 'umb_resellers':
		
		if($_POST['destino'] == 'vacio'){
			$_SESSION['filtros_umb']['destino']="";
		}else{		
			$res = select_sql_PO('select_i_destino_where', array($_POST['destino']));
			$_SESSION['filtros_umb']['destino'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_umb']['reseller']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_umb']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}
		break;

	case 'customer_class_filtro':

		$res = select_sql_PO('select_customer_class_filtro', array($_POST['reseller']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='vacio'>Todo</option>";
		if($_POST['reseller'] != "vacio"){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['i_customer_class']."''>".$res[$k]['name']."</option>";
				$k++;
			}
		}
		echo($html_res);
		break;

	case 'customer_name_filtro':

		$res = select_sql_PO('select_customer_name_filtro', array($_POST['reseller']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='vacio'>Todo</option>";
		if($_POST['reseller'] != "vacio"){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['i_customer']."''>".$res[$k]['name']."</option>";
				$k++;
			}
		}
		echo($html_res);
		break;

	case 'tipo_campo_filtro':

		$res = select_sql('select_dominio_high', array('DNIO_TIPO_CAMPO', $_POST['tabla']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='vacio'>Todo</option>";
		if($_POST['tabla'] != "vacio"){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['rv_Low_Value']."''>".$res[$k]['rv_Meaning']."</option>";
				$k++;
			}
		}
		echo($html_res);
		break;

	case 'customer_class_add':

		$res = select_sql_PO('select_customer_class_filtro', array($_POST['reseller']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='' selected='selected'>Por favor Seleccione</option>";
		if($_POST['reseller'] != ""){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['i_customer_class']."''>".$res[$k]['name']."</option>";
				$k++;
			}
		}
		echo($html_res);
		break;

	case 'customer_name_add':

		$res = select_sql_PO('select_customer_name_filtro', array($_POST['reseller']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='vacio' selected='selected'>Por favor Seleccione</option>";
		if($_POST['reseller'] != "vacio"){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['i_customer']."''>".$res[$k]['name']."</option>";
				$k++;
			}
		}
		echo($html_res);
		break;

	case 'accounts_filtro':

		$res = select_sql_PO('select_accounts_all', array($_POST['cliente']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='vacio'>Todo</option>";
		if($_POST['cliente'] != "vacio"){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['i_account']."''>".$res[$k]['id']."</option>";
				$k++;
			}
		}
		echo($html_res);
		break;
	
	case 'umb_cclass':
		
		if($_POST['destino'] == 'vacio'){
			$_SESSION['filtros_umb']['destino']="";
		}else{		
			$res = select_sql_PO('select_i_destino_where', array($_POST['destino']));
			$_SESSION['filtros_umb']['destino'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_umb']['reseller']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_umb']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['cclass'] == 'vacio'){
			$_SESSION['filtros_umb']['cclass']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_umb']['cclass'] = $_POST['cclass'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;

	case 'umb_clientes':
		
		if($_POST['destino'] == 'vacio'){
			$_SESSION['filtros_umb']['destino']="";
		}else{		
			$res = select_sql_PO('select_i_destino_where', array($_POST['destino']));
			$_SESSION['filtros_umb']['destino'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_umb']['reseller']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_umb']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['cname'] == 'vacio'){
			$_SESSION['filtros_umb']['cname']="";
		}else{		
			$res = select_sql_PO('select_i_client_where', array($_POST['cname']));
			$_SESSION['filtros_umb']['cname'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;

	case 'umb_cuentas':
		
		if($_POST['destino'] == 'vacio'){
			$_SESSION['filtros_umb']['destino']="";
		}else{		
			$res = select_sql_PO('select_i_destino_where', array($_POST['destino']));
			$_SESSION['filtros_umb']['destino'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_umb']['reseller']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_umb']['reseller'] = $_POST['reseller'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['cname'] == 'vacio'){
			$_SESSION['filtros_umb']['cname']="";
		}else{		
			$res = select_sql_PO('select_i_client_where', array($_POST['cname']));
			$_SESSION['filtros_umb']['cname'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;

	case 'log_usuarios':

		if($_POST['desde'] == 'vacio'){
			$_SESSION['filtros_log']['desde']="";
		}else{		
			$_SESSION['filtros_log']['desde'] = $_POST['desde'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['hasta'] == 'vacio'){
			$_SESSION['filtros_log']['hasta']="";
		}else{		
			$_SESSION['filtros_log']['hasta'] = $_POST['hasta'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['destino'] == 'vacio'){
			$_SESSION['filtros_log']['destino']="";
		}else{		
			$res = select_sql_PO('select_i_destino_where', array($_POST['destino']));
			$_SESSION['filtros_log']['destino'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['clase'] == 'vacio'){
			$_SESSION['filtros_log']['clase']="";
		}else{		
			$_SESSION['filtros_log']['clase'] = $_POST['clase'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['nivel'] == 'vacio'){
			$_SESSION['filtros_log']['nivel']="";
		}else{		
			$_SESSION['filtros_log']['nivel'] = $_POST['nivel'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;

	case 'log_env_reportes':

		if($_POST['desde'] == 'vacio'){
			$_SESSION['filtros_log']['desde']="";
		}else{		
			$_SESSION['filtros_log']['desde'] = $_POST['desde'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['hasta'] == 'vacio'){
			$_SESSION['filtros_log']['hasta']="";
		}else{		
			$_SESSION['filtros_log']['hasta'] = $_POST['hasta'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['reporte'] == 'vacio'){
			$_SESSION['filtros_log']['reporte']="";
		}else{		
			$_SESSION['filtros_log']['reporte'] = $_POST['reporte'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['estatus'] == 'vacio'){
			$_SESSION['filtros_log']['estatus']="";
		}else{		
			$_SESSION['filtros_log']['estatus'] = $_POST['estatus'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		break;

		case 'log_acciones':

		if($_POST['desde'] == 'vacio'){
			$_SESSION['filtros_log']['desde']="";
		}else{		
			$_SESSION['filtros_log']['desde'] = $_POST['desde'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['hasta'] == 'vacio'){
			$_SESSION['filtros_log']['hasta']="";
		}else{		
			$_SESSION['filtros_log']['hasta'] = $_POST['hasta'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['clase'] == 'vacio'){
			$_SESSION['filtros_log']['clase']="";
		}else{		
			$_SESSION['filtros_log']['clase'] = $_POST['clase'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['nivel'] == 'vacio'){
			$_SESSION['filtros_log']['nivel']="";
		}else{		
			$_SESSION['filtros_log']['nivel'] = $_POST['nivel'];
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}

		if($_POST['destino'] == 'vacio'){
			$_SESSION['filtros_log']['destino']="";
		}else{		

			$res = select_sql_PO('select_i_destino_where', array($_POST['destino']));
			if(count($res)> 0){
				$_SESSION['filtros_log']['destino'] = $res;
				$_SESSION['tipofiltro'] = $_POST['filtro'];
			}
		}

		break;

	case 'dia_envio':

		$res = select_sql('select_dominio_high', array('DNIO_DIA_ENVIO', $_POST['freq']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='' selected='selected'>Por favor Seleccione</option>";
		if($_POST['freq'] != ""){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['rv_Low_Value']."''>".$res[$k]['rv_Meaning']."</option>";
				$k++;
			}
		}
		echo($html_res);
		break;

	default:
		# code...
		break;
}
//echo $_SESSION['filtros'];

?>