<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
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
  return (intval($value) > 1);
}

$order="";
$orderType=" ASC";
$bitacorasCount = 0;

function toggleOrderType(){
  if($orderType == " ASC"){
    $orderType = " DESC";
  }else{
    $orderType = " ASC";
  }
}

function changeDate($date){
  $newdate = "";
  // YYYY-MM-DD
  $parts = explode("-",$date);
  $newdate = $parts[2]."/".$parts[1]."/".$parts[0];
  return $newdate;
}

if (isset($_POST['initialDateFil']) && isset($_POST['endDateFil']) && isset($_POST['procNameFil'])) {

  $where = "STR_TO_DATE(f_Inicio,'%d/%m/%Y') >= STR_TO_DATE('".changeDate($_POST['initialDateFil'])."','%d/%m/%Y') and STR_TO_DATE(f_Fin,'%d/%m/%Y') <= STR_TO_DATE('".changeDate($_POST['endDateFil'])."','%d/%m/%Y')";

  if($_POST['procNameFil'] <> '0'){
    $where .= " and t_proc = ".$_POST['procNameFil'];
  }
  if(isset($_POST['statusFilt'])){
    if($_POST['statusFilt'] <> '-1'){
      $where .= " and st_Bitacora = ".$_POST['statusFilt']; 
    }
  }
  if(isset($_POST['execIdFil'])){
    if($_POST['execIdFil'] <> ""){
      $where .= " and c_IEjecucion = ".$_POST['execIdFil'];
    }
  }
  
  /*echo "<h2>POST: initialDateFil:".$_POST['initialDateFil']." endDateFil:".$_POST['endDateFil']." procNameFil:".$_POST['procNameFil']." statusFilt:".$_POST['statusFilt']." execIdFil:".$_POST['execIdFil']."</h2>";
  echo "<h2>".print_custom_sql("*","af_bitacora",$where,"", "")."</h2>";*/

  $bitacoras=select_custom_sql("*","af_bitacora",$where,"", "");
  $bitacorasCount = count($bitacoras);
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

<div id="tableContainer" class="col-xs-12">
  <form role="form" action="" method="post">
    <div class="row">
      <div class="col-xs-3">
        <div class="form-group">
          <label for="initialDateFil">Fecha desde</label>
          <input type="date" required class="form-control" id="initialDateFil" name="initialDateFil">
        </div>
      </div>
      <div class="col-xs-3">
        <div class="form-group">
          <label for="endDateFil">Fecha hasta</label>
          <input type="date" required class="form-control" id="endDateFil"  name="endDateFil">
        </div>
      </div>
      <div class="col-xs-6">
        <div class="form-group">
          <label for="procNameFil">Tipo de reporte o proceso</label>
          <select id= "procNameFil" required class= "form-control" name="procNameFil">
            <option value='0'>Todos</option>
            <?php 
            $dom_tipProc = select_sql('select_dominio', 'DNIO_TIPO_PROCESO');
            foreach ($dom_tipProc as $tipProc) {
              echo "<option value= ".$tipProc['rv_Low_Value']. ">". $tipProc['rv_Meaning'] ."</option>";
            }
            ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-5">
        <div class="form-group">
          <label for="statusFilt">Estatus</label>
          <select id= "statusFilt" name="statusFilt" class= "form-control">
            <option value ='-1'>Todos</option>
            <?php 
            $dom_status = select_sql('select_dominio', 'DNIO_ST_BITACORA');
            foreach ($dom_status as $status) {
              echo "<option value= ".$status['rv_Low_Value']. ">". $status['rv_Meaning'] ."</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-xs-5">
        <div class="form-group">
          <label for="execIdFil">ID de ejecución</label>
          <input type="text" class="form-control" id="execIdFil" name="execIdFil">
        </div>
      </div>
      <div class="col-xs-2">
        <button type="submit" class="btn btn-primary" id="submit_filtros">Mostrar</button>
      </div>
    </div>
  </form>
  
  <?php 
    if(isset($where) && $bitacorasCount==0){
  ?>
      <div class='alert alert-info'>No se encontraron registros. Seleccione otro criterio de búsqueda</div>
  <?php
    }else{
  ?>
  <div class="row">
  	<div class="col-xs-12">
  		<table id="bit_table" class="table table-striped table-condensed table-bordered">
        <tbody>
          <tr>
            <th id="" class="iconCol"></th>
            <th id="c_IEjecucion">ID Ejecución</th>
            <th id="t_proc" class="col-xs-4">Tipo de Proceso o Reporte</th>
            <th id="st_Bitacora">Estatus</th>
            <th id="f_Inicio" class="col-xs-1">Fecha Inicio</th>
            <th id="f_Fin" class="col-xs-1">Fecha Fin</th>
            <th id="c_Usuario" class="col-xs-2">Usuario</th>
          </tr>
          <?php 
          if ($bitacorasCount > 0) {
            foreach ($bitacoras as $bit) {
              ?>
              <tr>
                <td><a href="#detalle-<? echo $bit['c_IEjecucion']; ?>" data-toggle="collapse"><span class="glyphicon glyphicon-plus"></span></a></td>
                <td><?php echo $bit['c_IEjecucion'];?></a></td>
                <td>
                  <?php 
                    $value = select_custom_sql("rv_Meaning","af_dominios","rv_Domain = 'DNIO_TIPO_PROCESO' and rv_Low_Value = ".$bit['t_proc'],"", ""); 
                    echo $value[1]['rv_Meaning'];
                  ?>
                </td>
                <td>
                  <?php
                    $value = select_custom_sql("rv_Meaning","af_dominios","rv_Domain = 'DNIO_ST_BITACORA' and rv_Low_Value = ".$bit['st_Bitacora'],"", ""); 
                    echo $value[1]['rv_Meaning'];
                  ?>
                </td>
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
                        <th>Detalles:</th>
                        <td style="width:auto;"><?php echo $bit['x_Obs'];?></td>
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
              <td colspan=7>No se encuentran registros.</td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>  	

  </div>
  <?php 
    }
  ?>
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

  /*$('#bit_table>tbody>tr>th').on('click',function(){
    $.ajax ({
        type: "POST",
        url: "af_bitacora.php",
        data: { orderby : $(this).attr("id") }, 
        success: function( result ) {
          console.log("HICE CLICK EN UN TH: "+$(this).attr("id")+"");
        }
    });
});*/
</script>
<?php 
  if(isset($_POST['initialDateFil']) && isset($_POST['endDateFil'])){
?>
  <script>
  var initDate = "<?php echo $_POST['initialDateFil'] ?>";
  var endDate = "<?php echo $_POST['endDateFil'] ?>";
  var typeProcess = "<?php echo $_POST['procNameFil'] ?>";
  var status = "<?php echo $_POST['statusFilt'] ?>";
  var execID = "<?php echo $_POST['execIdFil'] ?>";
  
  if(initDate != ""){
    $('#initialDateFil').val(initDate);
  }
  if(endDate != ""){
    $('#endDateFil').val(endDate);  
  }
  if(typeProcess != ""){
    $('#procNameFil').val(typeProcess);  
  }
  if(status != ""){
    $('#statusFilt').val(status);  
  }
  if(execID != ""){
    $('#execIdFil').val(execID);  
  }
  </script>
<?php 
  }
?>

<?php include_once "footer.php" ?>