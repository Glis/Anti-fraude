<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "lib/libreriaBD.php" ?>
<?php

if(!isset($_SESSION['USUARIO']))
{
    header("Location: login.php");
    exit;
} 

$accounts=select_custom_sql("*","af_chequeo_det_cuentas","i_Bloqueo=1","", "LIMIT 10");
$accountCount = count($accounts);

?>

<?php include_once "header.php" ?>

<table class="ewStdTable">
  <tbody>
    <tr>
      <td>
        <ul class="breadcrumb">
          <li>
            <a href="login.php">Home</a>
          </li>
          <li class="active">
            <span id="ewPageCaption">Monitor (Cuentas Bloqueadas)</span>
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<div id="page_title" style="text-align:center; width:100%"></div>
<div id="treeContainer" class="col-sm-12">
  <!-- Tabla de cuentas  -->
  
  <div class="row">
  	<div class="col-sm-8">
  		<h3>Cuentas Bloqueadas</h3>
      <table class="table table-striped table-condensed table-bordered">
        <tbody id="tableBody">
          <tr>
            <th class="col-sm-6">ID Cuenta</th>
            <th >Fecha Bloqueo</th>
            <th class="col-sm-1">Opciones</th>
          </tr>
          <?php 
            if ($accountCount > 0) {
              foreach ($accounts as $acc) {
          ?>
          <tr>
            <td>Cuenta <?php echo $acc['c_ICuenta'];?></td>
            <td><?php echo $acc['f_Bloqueo'];?></td>
            <td><?php echo "<span title='Desbloquear' class='glyphicon glyphicon-off'></span>"; ?></td>
          </tr>
          <?php  
              }
            } else {
          ?>
              <tr>
                <td colspan=3>No se encontraron cuentas.</td>
              </tr>
          <?php
            }
          ?> 
        </tbody>
      </table>
  	</div>  	
  	<div class="col-sm-4">
  		<h3>Filtros</h3>
  		<div class="filtros form">
  			<form role="form">
  			  <div class="form-group">
  			    <label for="resellerName">Resellers</label>
  			    <select id= "resellerName" class= "form-control">
              <option value = 100>Seleccione un Reseller</option>
              <option value = 'All'>Todos</option>
            <!-- 
            <? $dom_accion = select_sql('select_dominio', 'DNIO_CLASE_ACCION');
              $count = count($dom_accion);
              $k = 1;
              while ($k <= $count){
                echo "<option value= ".$dom_accion[$k]['rv_Low_Value']. ">". $dom_accion[$k]['rv_Meaning'] ."</option>";
                $k++;
              }
            ?> -->
            </select>
  			  </div>
  			  <div class="form-group">
  			    <label for="cusName">Nombre del cliente</label>
  			    <input type="text" class="form-control" id="cusName" placeholder="Nombre de Cliente">
  			  </div>
  			  <button type="submit" class="btn btn-primary">Filtrar</button>
  			</form>
  		</div>
  	</div>
  </div>

</div>

<?php include_once "footer.php" ?>