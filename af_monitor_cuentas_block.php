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

?>

<?php include_once "header.php" ?>

<h1 style="text-align:center; ">Monitor (Clientes Bloqueados)</h1>
<div id="treeContainer" class="col-sm-12">
  <!-- Tabla de chequeo  -->
  
  <div class="tableContainer row">
  	<div class="col-sm-8">
  		<h3>Clientes Bloqueados</h3>
      <table class="table table-striped table-condensed table-bordered">
        <tbody id="tableBody">
          <tr>
            <th class="col-sm-6">Nombre Cliente</th>
            <th >Fecha Bloqueo</th>
            <th class="col-sm-1">Opc</th>
          </tr>
          <tr>
            <td>Cliente 1</td>
            <td>07/10/2011</td>
            <td>Opciones</td>
          </tr>
          <tr>
            <td>Cliente 2</td>
            <td>07/10/2011</td>
            <td>Opciones</td>
          </tr>
          <tr>
            <td>Cliente 3</td>
            <td>07/10/2011</td>
            <td>Opciones</td>
          </tr>
          <tr>
            <td>Cliente 4</td>
            <td>07/10/2011</td>
            <td>Opciones</td>
          </tr> <!-- quinto nivel -->
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
            ?>
             -->
            </select>
  			  </div>
  			  <div class="form-group">
  			    <label for="cusName">Customer Name</label>
  			    <input type="text" class="form-control" id="cusName" placeholder="Nombre de Cliente">
  			  </div>
  			  <button type="submit" class="btn btn-primary">Filtrar</button>
  			</form>
  		</div>
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