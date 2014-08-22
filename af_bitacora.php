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

function is_On($value){
  return (intval($value) > 0);
}

if (isset($_POST['initialDateFil']) && isset($_POST['endDateFil']) && isset($_POST['procNameFil'])) {
  $where = "f_Inicio >= '".$_POST['initialDateFil']."' and f_Fin <= '".$_POST['endDateFil']."' and t_proc = '".$_POST['procNameFil']."'";
  
  $bitacoras=select_custom_sql("*","af_bitacora",$where,"", "LIMIT 10");
  $bitacorasCount = count($bitacoras);

  /*echo "<h2>".print_custom_sql("*","af_bitacora",$where,"", "LIMIT 10")."</h2>";*/
}

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
            <span id="ewPageCaption">Bitácora</span>
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<div id="page_title" style="text-align:center; width:100%"></div>
<!-- Tabla de bitacora  -->

<!-- <pre><h4>  
<?php 
  var_dump(select_custom_sql("*","af_bitacora",$where,"", "LIMIT 10"));
?>
</h3></pre> -->

<div id="tableContainer" class="col-sm-12">
  <?php 
    if(!isset($where)){
  ?>
  <div class='alert alert-info'>Seleccione un criterio de búsqueda</div>
  <?php 
    }else if($bitacorasCount==0){
  ?>
  <div class='alert alert-info'>No se encontraron registros. Seleccione otro criterio de búsqueda</div>
  <?php
    }
  ?>

  <form role="form" action="" method="post">
    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
          <label for="initialDateFil">Fecha desde</label>
          <input type="date" required class="form-control" id="initialDateFil" name="initialDateFil">
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="endDateFil">Fecha hasta</label>
          <input type="date" required class="form-control" id="endDateFil"  name="endDateFil">
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label for="procNameFil">Tipo de reporte o proceso</label>
          <select id= "procNameFil" required class= "form-control" name="procNameFil">
            <option value ='0'>Seleccione un tipo de proceso</option>
            <option value ='1'>Todos</option>
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
    </div>
    <div class="row">
      <div class="col-sm-5">
        <div class="form-group">
          <label for="statusFilt">Estatus</label>
          <select id= "statusFilt" name="statusFilt" class= "form-control">
            <option value ='0'> </option>
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
          <label for="execIdFil">ID de ejecución</label>
          <input type="text" class="form-control" id="execIdFil" name="execIdFil">
        </div>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary" id="submit_filtros">Mostrar</button>
      </div>
    </div>
  </form>

  <div class="row">
  	<div class="col-sm-12">
  		<table id="bit_table" class="table table-striped table-condensed table-bordered">
  		  <tbody>
  		    <tr>
            <th class="iconCol"></th>
  	     	  <th>ID Ejecución</th>
  		      <th class="col-sm-4">Tipo de Proceso o Reporte</th>
            <th>Estatus</th>
            <th class="col-sm-1">Fecha Inicio</th>
            <th class="col-sm-1">Fecha Fin</th>
  		      <th class="col-sm-2">Usuario</th>
  		    </tr>
          <?php 
            if ($bitacorasCount > 0) {
              foreach ($bitacoras as $bit) {
          ?>
              <tr>
                <td><a href="#detalle-<? echo $bit['c_IEjecucion']; ?>" data-toggle="collapse"><span class="glyphicon glyphicon-plus"></span></a></td>
                <td><?php echo $bit['c_IEjecucion'];?></a></td>
                <td><?php echo $bit['t_proc'];?></td>
                <td><?php echo $bit['st_Bitacora'];?></td>
                <td><?php echo $bit['f_Inicio'];?></td>
                <td><?php echo $bit['f_Fin'];?></td>
                <td><?php echo $bit['c_Usuario'];?></td>
              </tr>
              <tr id="detalle-<? echo $bit['c_IEjecucion']; ?>" class="collapse">
                <td></td>
                <td class="tablecell" colspan="6">
                  <table class="table table-striped table-condensed table-bordered">
                    <tbody>
                      <tr>
                        <th>Detalles:</td>
                        <td><?php echo $bit['x_Obs'];?></td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
          <?php  
              }
            } else {
          ?>
              <tr>
                <td colspan=3>No se encuentran registros.</td>
              </tr>
          <?php
            }
          ?>
  		  </tbody>
  		</table>
  	</div>  	
  	
  </div>
</div>

<script>
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
  $('#initialDateFil').val(today);
  $('#endDateFil').val(today);
  $('#initialDateFil').attr("max",today);
  $('#endDateFil').attr("max",today);
</script>

<?php include_once "footer.php" ?>