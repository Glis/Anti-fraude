<?php
if (session_id() == "") {session_start();} // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "userfn10.php" ?>
<?php
	ew_Header(TRUE);
	$conn = ew_Connect();
	$Language = new cLanguage();
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $Language->Phrase("MobileMenu") ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo ew_jQueryFile("jquery.mobile-%v.min.css") ?>">
<link rel="stylesheet" type="text/css" href="<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>">
<link rel="stylesheet" type="text/css" href="phpcss/ewmobile.css">
<script type="text/javascript" src="<?php echo ew_jQueryFile("jquery-%v.min.js") ?>"></script>
<script type="text/javascript">

	//$(document).bind("mobileinit", function() {
	//	jQuery.mobile.ajaxEnabled = false;
	//	jQuery.mobile.ignoreContentEnabled = true;
	//});

</script>
<script type="text/javascript" src="<?php echo ew_jQueryFile("jquery.mobile-%v.min.js") ?>"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="generator" content="PHPMaker v10.0.4">
</head>
<body>
<div data-role="page">
	<div data-role="header">
		<h1><?php echo $Language->ProjectPhrase("BodyTitle") ?></h1>
	</div>
	<div data-role="content">
<?php $RootMenu = new cMenu("RootMenu", TRUE); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(22, $Language->MenuPhrase("22", "MenuText"), "", -1, "", TRUE, TRUE, TRUE);
$RootMenu->AddMenuItem(23, $Language->MenuPhrase("23", "MenuText"), "", 22, "", TRUE, TRUE, TRUE);
$RootMenu->AddMenuItem(3, $Language->MenuPhrase("3", "MenuText"), "af_acc_clienteslist.php", 23, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, $Language->MenuPhrase("4", "MenuText"), "af_acc_cuentaslist.php", 23, "", TRUE, FALSE);
$RootMenu->AddMenuItem(2, $Language->MenuPhrase("2", "MenuText"), "af_acc_cclasslist.php", 23, "", TRUE, FALSE);
$RootMenu->AddMenuItem(6, $Language->MenuPhrase("6", "MenuText"), "af_acc_resellerslist.php", 23, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, $Language->MenuPhrase("5", "MenuText"), "af_acc_plataformalist.php", 23, "", TRUE, FALSE);
$RootMenu->AddMenuItem(18, $Language->MenuPhrase("18", "MenuText"), "af_configlist.php", 22, "", TRUE, FALSE);
$RootMenu->AddMenuItem(13, $Language->MenuPhrase("13", "MenuText"), "af_umb_destinoslist.php", 22, "", TRUE, FALSE);
$RootMenu->AddMenuItem(24, $Language->MenuPhrase("24", "MenuText"), "", 22, "", TRUE, TRUE, TRUE);
$RootMenu->AddMenuItem(15, $Language->MenuPhrase("15", "MenuText"), "af_umb_clienteslist.php", 24, "", TRUE, FALSE);
$RootMenu->AddMenuItem(16, $Language->MenuPhrase("16", "MenuText"), "af_umb_cuentaslist.php", 24, "", TRUE, FALSE);
$RootMenu->AddMenuItem(10, $Language->MenuPhrase("10", "MenuText"), "af_umb_cclasslist.php", 24, "", TRUE, FALSE);
$RootMenu->AddMenuItem(14, $Language->MenuPhrase("14", "MenuText"), "af_umb_resellerslist.php", 24, "", TRUE, FALSE);
$RootMenu->AddMenuItem(17, $Language->MenuPhrase("17", "MenuText"), "af_config_reporteslist.php", 22, "", TRUE, TRUE);
$RootMenu->AddMenuItem(21, $Language->MenuPhrase("21", "MenuText"), "", -1, "", TRUE, TRUE, TRUE);
$RootMenu->AddMenuItem(1, $Language->MenuPhrase("1", "MenuText"), "af_reportes_usuariolist.php", 21, "", TRUE, FALSE);
$RootMenu->AddMenuItem(9, $Language->MenuPhrase("9", "MenuText"), "af_resellers_usuariolist.php", 21, "", TRUE, FALSE);
$RootMenu->AddMenuItem(8, $Language->MenuPhrase("8", "MenuText"), "af_usuarioslist.php", 21, "", TRUE, FALSE);
$RootMenu->AddMenuItem(7, $Language->MenuPhrase("7", "MenuText"), "af_reporteslist.php", 25, "", TRUE, FALSE);
$RootMenu->AddMenuItem(12, $Language->MenuPhrase("12", "MenuText"), "af_dominioslist.php", 25, "", TRUE, FALSE);
$RootMenu->Render();
?>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>
<?php

	 // Close connection
	$conn->Close();
?>
