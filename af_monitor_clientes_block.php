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

$customers=select_custom_sql("*","af_chequeo_det_clientes","i_Bloqueo=1","", "LIMIT 10");
$customerCount = count($customers);

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
            <span id="ewPageCaption">Monitor (Clientes Bloqueados)</span>
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<div id="page_title" style="text-align:center; width:100%"></div>
<div id="treeContainer" class="col-sm-12">
  <!-- Filtros -->
  <form role="form">
    <div class="row">
      <div class="col-sm-5">
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
          ?>
           -->
          </select>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="form-group">
          <label for="cusName">Nombre del cliente</label>
          <input type="text" class="form-control" id="cusName" placeholder="Nombre de Cliente">
        </div>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary" id="submit_filtros">Filtrar</button>
      </div>
    </div>
  </form>

  <!-- Tabla de chequeo  -->
  
  <div class="row">
  	<div class="col-sm-12">
      <table class="table table-striped table-condensed table-bordered">
        <tbody id="tableBody">
          <tr>
            <th class="col-sm-6">Nombre Cliente</th>
            <th >Fecha Bloqueo</th>
            <th class="col-sm-1">Opciones</th>
          </tr>
          <?php 
            if ($customerCount > 0) {
              foreach ($customers as $cus) {
          ?>
          <tr>
            <td>Cliente <?php echo $cus['c_ICliente'];?></td>
            <td><?php echo $cus['f_Bloqueo'];?></td>
            <td><?php echo "<span title='Desbloquear' class='glyphicon glyphicon-off'></span>"; ?></td>
          </tr>
          <?php  
              }
            } else {
          ?>
              <tr>
                <td colspan=3>No se encontraron clientes.</td>
              </tr>
          <?php
            }
          ?> 
        </tbody>
      </table>
  	</div>  	
  	
  </div>

<!--   <pre><h4> -->  
  <?php 
  	/*$users = select_sql('select_usuarios');
  	$count = count($users);
  	$k = 1;
  	while ($k <= $count){
  		echo "<option value= ".$users[$k]['c_Usuario']. ">". $users[$k]['c_Usuario'] ."</option>";
  		$k++;
  	}
  	var_dump(select_custom_sql("*","af_chequeo_det","",""))*/
  ?>
  <!-- </h3></pre> -->
</div>

<?php include_once "footer.php" ?>