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

if($_SESSION['filtro_cuentas_bloq'] == ""){
  $accounts=select_custom_sql("*","af_chequeo_det_cuentas","i_Bloqueo=1","f_Bloqueo DESC", ""/*"LIMIT 10"*/);
  $accountCount = count($accounts);
}else{
  $accounts=select_custom_sql("*","af_chequeo_det_cuentas","i_Bloqueo=1 AND c_IReseller=" . $_SESSION['filtro_cuentas_bloq'],"f_Bloqueo DESC", ""/*"LIMIT 10"*/);
  $accountCount = count($accounts);
}

/*
* SELECTS DE PORTAWAN
*/
/*abrirConexion_PO();


//DESTINOS
$destinosPorta = select_sql_PO_manual('select_destinos_all');
$destinosList = array();

foreach ($destinosPorta as $key => $dest) {
  $destinosList[$dest['i_dest']] = array( "destination" => $dest["destination"], "description" => $dest["description"]);
}

//CLIENTES
$customersPorta = select_sql_PO_manual('select_clientes_all');
$customersList = array();
foreach ($customersPorta as $key => $cus) {
  $customersList[$cus['i_customer']] = array( "name" => $cus["name"]);
}

//CUENTAS 
$accountsPorta = select_sql_PO_manual('select_accounts_really_all');
$accountsList = array();
foreach ($accountsPorta as $key => $acc) {
  $accountsList[$acc['i_account']] = array( "id" => $acc["id"]);
}

cerrarConexion_PO();
*/
?>

<?php include_once "header.php" ?>

<script>
$(document).on('click','#submit_filtros',function(){

      var reseller = $('#resellerName').find("option:selected").val();


      var dataString = "pag=monitor_cuentas&filtro=x";
      if (reseller == "vacio"){
        dataString = dataString + "&reseller=vacio";
      }else{
        dataString = dataString + "&reseller=" + reseller;
      }

     
      alert(dataString);
      $.ajax({  
        type: "POST",  
        url: "lib/functions.php",  
        data: dataString,  
        success: function(html) {  
        alert(html);location.reload();
        }
      });
});

</script>

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
 
    <div class="row">
      <div class="col-sm-5 col-sm-offset-2">
        <div class="form-group">
          <label for="resellerName">Resellers</label>
          <select id= "resellerName" class= "form-control">
            <option value="vacio">Todo</option>
            <?
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
      <div class="col-sm-3">
        <button type="submit" class="btn btn-primary" id="submit_filtros">Buscar</button>
      </div>
    </div>

  
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
                
                $accName = $_SESSION['accountsList'][$acc['c_ICuenta']]['id'];            
                $cusName = $_SESSION['customersList'][$acc['c_ICliente']]['name'];
                $destName = $_SESSION['destinosList'][$acc['c_IDestino']]['destination'];
                $accColor = is_On($acc['i_Alerta']) ? 'warning' : "";
                $accColor = is_On($acc['i_Cuarentena']) ? 'danger' : $accColor;
          ?>
          <tr>
            <td class="<? echo $accColor; ?>"><?php echo $cusName; ?></td>
            <td class="<? echo $accColor; ?>"><?php echo $accName; ?></td>
            <td class="<? echo $accColor; ?>"><?php echo $destName; ?></td>
            <td class="<? echo $accColor; ?>"><?php echo $acc['c_IChequeo'];?></td>
            <td class="<? echo $accColor; ?>"><?php echo $acc['f_Bloqueo'];?></td>
            <td class="icon_cell"><?php echo "<span id='desbloqueo_cuenta' class=". $acc['c_ICuenta']. "><i title='Desbloquear' class='glyphicon icon-unlock'></i></span>"; ?></td>
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

<?php  $_SESSION['filtro_cuentas_bloq'] = "";?>
</div>
<!-- Modal para el bloqueo/desbloqueo de lientes -->
<div class="modal fade" id="unlock_modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Desbloqueando, espere por favor...</h4>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<span id="logged_user" hidden><?php echo $_SESSION["USUARIO"]; ?></span>

<script>
  $(document).on('click','#desbloqueo_cuenta',function(){
      $('#unlock_modal').find('.modal-title').text('Desbloqueando la cuenta seleccionada, espere por favor...');
      $('#unlock_modal').modal('show');                                        
      
    var element= $(this);

      //$(location).attr('href',"DesbloqueoCliente.php?i_customer=" + $(this).attr('class'));
   
    var dataString = "i_account=" + $(this).attr('class') + "&usuario=" + $("#logged_user").text();
    $.ajax({  
      type: "POST",  
      url: "DesbloqueoCuenta.php",  
      data: dataString,  
      success: function(response) {  
      element.hide(); 
      // alert ("termino: "+response);
        $('#unlock_modal').modal('hide'); 
      },
      error: function(response){
        // alert ("termino: "+response);
      $('#unlock_modal').modal('hide'); 
      }
    });

  });
</script>

<?php include_once "footer.php" ?>