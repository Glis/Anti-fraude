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
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
		break;
	
	case 'acc_cliente':
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
		break;
	
	case 'acc_cuentas':
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
		break;
	
	case 'acc_plataforma':
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
		break;
	
	case 'acc_resellers':
		$_SESSION['filtros'] = $_POST['valor'];
		$_SESSION['tipofiltro'] = $_POST['filtro'];
		if($_POST['valor'] == 'All')$_SESSION['filtros']="";
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
		while ($k <= $cant) {
			$html_res .= "<option value='".$res[$k]['i_customer_class']."''>".$res[$k]['name']."</option>";
			$k++;
		}
		echo $html_res;
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

		if($_POST['reseller'] == 'vacio'){
			$_SESSION['filtros_umb']['cclass']="";
		}else{		
			//$res = select_sql_PO('select_i_porta_customers_where', array($_POST['valor']));
			$_SESSION['filtros_umb']['cclass'] = $_POST['cclass'];
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