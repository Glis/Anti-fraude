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
	
	default:
		# code...
		break;
}
echo $_SESSION['filtros'];

?>