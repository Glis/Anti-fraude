<!-- Begin Main Menu -->
<div id="top-menu" class="row">
  <ul class="nav navbar-nav">
    <li class="dropdown col-sm-3">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Monitor <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="af_chequeolist.php">Monitor</a></li>
        <li class="divider"></li>
        <li><a href="af_chequeo_det_clienteslist.php">Clientes Bloqueados</a></li>
        <li><a href="af_chequeo_det_cuentaslist.php">Cuentas Bloqueadas</a></li>
      </ul>
    </li>
    <li class="dropdown col-sm-3">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Reportes <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="af_bitacoralist.php">Bitácora</a></li>
        <li class="dropdown-submenu">
          <a tabindex="-1" href="#">Logs</a>
          <ul class="dropdown-menu">
            <li><a href="af_log_accioneslist.php">Acciones</a></li>
            <li><a href="af_log_envio_replist.php">Envío Reportes</a></li>
            <li><a href="af_log_usuariolist.php">Usuarios</a></li>
          </ul>
        </li>
        <li class="dropdown-submenu">
          <a tabindex="-1" href="#">Reportes</a>
          <ul class="dropdown-menu">
            <li><a href="af_reportes_calidad_destino.php">Calidad por Destino</a></li>
            <li><a href="af_reportes_minutos_destino.php">Minutos por Destino</a></li>
            <li><a href="af_reportes_clientes_bloq.php">Clientes Bloqueados</a></li>
            <li><a href="af_reportes_cuentas_bloq.php">Cuentas Bloqueadas</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <?if ($_SESSION['USUARIO_TYPE']['config'] == 1){?>
    <li class="dropdown col-sm-3">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Configuración <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li class="dropdown-submenu">
          <a tabindex="-1" href="#">Acciones</a>
          <ul class="dropdown-menu">
            <li><a href="af_acc_plataformalist.php">Plataforma</a></li>
            <li><a href="af_acc_resellerslist.php">Reseller</a></li>
            <li><a href="af_acc_cclasslist.php">Customer Class</a></li>
            <li><a href="af_acc_clienteslist.php">Clientes</a></li>
            <li><a href="af_acc_cuentaslist.php">Cuentas</a></li>
          </ul>
        </li>
        
        <li><a href="af_configlist.php">Configuración</a></li>
        <li><a href="af_config_reporteslist.php">Config Env Reportes</a></li>
        <li class="dropdown-submenu">
          <a tabindex="-1" href="#">Umbrales</a>
          <ul class="dropdown-menu">
            <li><a href="af_umb_destinoslist.php">Plataforma</a></li>
            <li><a href="af_umb_resellerslist.php">Reseller</a></li>
            <li><a href="af_umb_cclasslist.php">Customer Class</a></li>
            <li><a href="af_umb_clienteslist.php">Clientes</a></li>
            <li><a href="af_umb_cuentaslist.php">Cuentas</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <?} 
    if ($_SESSION['USUARIO_TYPE']['admin'] == 1){?>
    <li class="dropdown col-sm-3">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Seguridad <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="af_reportes_usuariolist.php">Reportes por Usuario</a></li>
        <li><a href="af_resellers_usuariolist.php">Resellers por Usuario</a></li>
        <li><a href="af_usuarioslist.php">Usuarios</a></li>
      </ul>
    </li>
    <?}?>
  </ul>
</div>

<!--<?php $RootMenu = new cMenu(EW_MENUBAR_ID);
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
?>-->
<!-- <pre><h5><?php var_dump($Language->MenuPhrase("7", "MenuText")) ?></h5></pre>  -->

<!-- <div class="ewMenu">
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
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
</div> -->
<!-- End Main Menu -->
