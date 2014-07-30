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
			$_SESSION['filtros']="";
		}else{
			$res = select_sql_PO('select_i_destino_where', array($_POST['valor']));
			$_SESSION['filtros_umb'] = $res;
			$_SESSION['tipofiltro'] = $_POST['filtro'];
		}
		
		break;
	
	default:
		# code...
		break;
}
//echo $_SESSION['filtros'];
echo($_SESSION['filtros_umb'][1]['i_dest']);

?>