<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "userfn10.php" ?>
<?php include_once "lib/libreriaBD.php" ?>
<?php include_once "lib/libreriaBD_portaone.php" ?>
<?php

if(!isset($_SESSION['USUARIO']))
{
    header("Location: login.php");
    exit;
}

function is_On($value){
  return (intval($value) < 2);
} 

$accounts=select_custom_sql("*","af_chequeo_det_cuentas","i_Bloqueo=1","f_Bloqueo DESC", "LIMIT 10");
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
  <!-- Filtros -->
  <form role="form">
    <div class="row">
      <div class="col-sm-5">
        <div class="form-group">
          <label for="resellerName">Resellers</label>
          <select id= "resellerName" class= "form-control">
            <option value="vacio">Todo</option>
            <?
              $_SESSION['filtros_acc']['tipo_accion'] = ""; $_SESSION['filtros_acc']['clase_accion'] = "";
              $_SESSION['filtros_acc']['reseller'] = ""; $_SESSION['filtros_acc']['cclass'] = "";
              $res = select_sql_PO('select_porta_customers');
              $cant = count($res);
              $k = 1;

              while ($k <= $cant) {
                echo ('<option value='.$res[$k]['i_customer'].'>'. $res[$k]['name'] . '</option>');
                $k++;
              }

            ?>
          </select>
        </div>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary" id="submit_filtros">Buscar</button>
      </div>
    </div>
  </form>
  
  <!-- Tabla de cuentas  -->
  
  <div class="row">
  	<div class="col-sm-12">
      <table class="table table-striped table-condensed table-bordered">
        <tbody id="tableBody">
          <tr>
            <th class="col-sm-3">Nombre del cliente</th>
            <th>ID Cuenta</th>
            <th>Destino</th>
            <th>Código chequeo</th>
            <th >Fecha Bloqueo</th>
            <th class="col-sm-1">Opciones</th>
          </tr>
          <?php 
            if ($accountCount > 0) {
              foreach ($accounts as $acc) {
                $cus_porta = select_sql_PO('select_porta_customers_where_class', array($acc['c_ICliente']));
                $acc_porta = select_sql_PO('select_porta_accounts_where', array($acc['c_ICuenta'],$acc['c_ICliente']));
                $dest_porta = select_sql_PO('select_destino_where', array($acc['c_IDestino']));
                $accName = $acc_porta[1]['id'];
                $cusName = $cus_porta[1]['name'];
                $destName = $dest_porta[1]['destination'];                
                $accColor = is_On($acc['i_Alerta']) ? 'warning' : "";
                $accColor = is_On($acc['i_Cuarentena']) ? 'danger' : $accColor;
          ?>
          <tr>
            <td class="<? echo $accColor; ?>"><?php echo $cusName; ?></td>
            <td class="<? echo $accColor; ?>"><?php echo $accName; ?></td>
            <td class="<? echo $accColor; ?>"><?php echo $destName; ?></td>
            <td class="<? echo $accColor; ?>"><?php echo $acc['c_IChequeo'];?></td>
            <td class="<? echo $accColor; ?>"><?php echo $acc['f_Bloqueo'];?></td>
            <td class="icon-cell"><?php echo "<span title='Desbloquear' class='glyphicon glyphicon-lock'></span>"; ?></td>
          </tr>
          <?php  
              }
            } else {
          ?>
              <tr>
                <td colspan=6>No se encontraron cuentas.</td>
              </tr>
          <?php
            }
          ?> 
        </tbody>
      </table>
  	</div>  	
  	
  </div>

</div>

<?php include_once "footer.php" ?>