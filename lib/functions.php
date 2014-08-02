<?php include_once "libreriaBD_portaone.php" ?>
<?php
session_start();

$pagina = $_POST['pag'];

switch ($pagina) {
	case 'reportes_usuario':
		$_SESSION['filtros'] = $_POST['valor'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
		break;

	case 'resellers_usuario':
		$_SESSION['filtros'] = $_POST['valor'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
		break;

	case 'config_reportes':
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
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

	case 'customer_class_add':

		$res = select_sql_PO('select_customer_class_filtro', array($_POST['reseller']));
		$cant = count($res);
		$k = 1;
		$html_res = "<option value='' selected='selected'>Por favor Seleccione</option>";
		if($_POST['reseller'] != "vacio"){
			while ($k <= $cant) {
				$html_res .= "<option value='".$res[$k]['i_customer_class']."''>".$res[$k]['name']."</option>";
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


	default:
		# code...
		break;
}
//echo $_SESSION['filtros'];
//echo($_SESSION['filtros_umb'][1]['i_dest']);

?>