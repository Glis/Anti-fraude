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

function changeDate($date){
  $newdate = "";
  // YYYY-MM-DD
  $parts = explode("-",$date);
  $newdate = $parts[2]."/".$parts[1]."/".$parts[0];
  return $newdate;
}

//COLOCA UN BULLET ROJO O AMARILLO DEPENDIENDO EL CASO
function bulletCellContents($type, $ch, $d){
  if($type == "R"){
    $rCuarent=select_custom_sql("c_IReseller","af_chequeo_det_resellers","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_IReseller","af_chequeo_det_resellers","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else if($type == "CC"){
    $rCuarent=select_custom_sql("c_ICClass","af_chequeo_Det_CClass","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_ICClass","af_chequeo_Det_CClass","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else if($type == "C"){
    $rCuarent=select_custom_sql("c_ICliente","af_chequeo_Det_Clientes","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_ICliente","af_chequeo_Det_Clientes","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else if($type == "A"){
    $rCuarent=select_custom_sql("c_ICuenta","af_chequeo_Det_Cuentas","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Cuarentena=1","","");
    if(count($rCuarent) > 0){
      return '<span class="glyphicon glyphicon-asterisk bullet-rojo"></span>';
    }else{
      $rAlerta=select_custom_sql("c_ICuenta","af_chequeo_Det_Cuentas","c_IChequeo='".$ch."' AND c_IDestino='".$d."' AND i_Alerta=1","","");
      if(count($rAlerta) > 0){
        return '<span class="glyphicon glyphicon-asterisk bullet-amarillo"></span>';
      }else{
        return "";
      }
    }
  }else {
    return "ERROR";
  }

}

//INICIALIZACIÓN DEL QUERY
$where = "";
if (isset($_POST['initialDateFil']) || isset($_POST['endDateFil'])) {
  

  if(isset($_POST['initialDateFil'])){
    $where .= "STR_TO_DATE(f_Inicio,'%d/%m/%Y') >= STR_TO_DATE('".changeDate($_POST['initialDateFil'])."','%d/%m/%Y')"; 
  }
  if(isset($_POST['endDateFil'])){
    $where .= " and STR_TO_DATE(f_Fin,'%d/%m/%Y') <= STR_TO_DATE('".changeDate($_POST['endDateFil'])."','%d/%m/%Y')";
  }
  
  /*echo "<h2>POST: initialDateFil:".$_POST['initialDateFil']." endDateFil:".$_POST['endDateFil']."</h2>";
  echo "<h2>".print_custom_sql("*","af_chequeo",$where,"", "")."</h2>";*/
}

$chequeos=select_custom_sql("*","af_chequeo",$where,"", "LIMIT 10");
$chequeosCount = count($chequeos);

/*
* SELECTS DE PORTAWAN
*/
abrirConexion_PO();

//DESTINOS
$destinosPorta = select_sql_PO_manual('select_destinos_all');
$destinosList = array();

foreach ($destinosPorta as $key => $dest) {
  $destinosList[$dest['i_dest']] = array( "destination" => $dest["destination"], "description" => $dest["description"]);
}

//RESELLERS
$resellersPorta = select_sql_PO_manual('select_porta_customers');
$resellersList = array();
foreach ($resellersPorta as $key => $res) {
  $resellersList[$res['i_customer']] = array( "name" => $res["name"]);
}

//CUSTOMER CLASS
$ccPorta = select_sql_PO_manual('select_customer_class_all');
$ccList = array();
foreach ($ccPorta as $key => $cclass) {
  $ccList[$cclass['i_customer_class']] = array( "name" => $cclass["name"]);
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
            <span id="ewPageCaption">Monitor general: Chequeos</span>
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<div id="page_title" style="text-align:center; width:100%"></div>
<!-- Tabla de chequeo  -->

<!-- <div class="debug">
<code>
  <pre><?php var_dump($destinosPorta); ?></pre>
</code>
</div> -->

<div id="tableContainer" class="col-sm-12">
  <form role="form" action="" method="post">
    <div class="row">
      <div class="col-sm-5">
        <div class="form-group">
          <label for="initialDateFil">Desde</label>
          <input type="date" class="form-control" id="initialDateFil" name="initialDateFil" required>
        </div>
      </div>
      <div class="col-sm-5">
        <div class="form-group">
          <label for="endDateFil">Hasta</label>
          <input type="date" class="form-control" id="endDateFil" name="endDateFil" required>
        </div>
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary" id="submit_filtros">Buscar</button>
      </div>
    </div>
  </form>
  
  <div class="row">
  	<div class="col-sm-12">
  		<table class="table table-striped table-condensed table-bordered">
  		  <tbody id="tableBodyChequeo">
  		    <tr>
  	     	  <th class="col-sm-2">Código Chequeo</th>
  		      <th class="col-sm-1">Fecha Inicio Ventana</th>
  		      <th class="col-sm-1">Fecha Fin Ventana</th>
  		    </tr>
          <?php 
            if ($chequeosCount > 0) {
              foreach ($chequeos as $check) {
          ?>
              <tr>
                <td><a class="chequeo_link" href="#dTree<?php echo $check['c_IChequeo'];?>" data-toggle="collapse" data-parent="#treeContainer"><?php echo $check['c_IChequeo'];?></a></td>
                <td><?php echo $check['f_Inicio'];?></td>
                <td><?php echo $check['f_Fin'];?></td>
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

<!-- Tabla de 5 niveles -->
<div id="treeContainer" class="col-sm-12">
  
  <div class="row">
  <?php 


    if ($chequeosCount > 0) {
    foreach ($chequeos as $check) {
      $destinos=select_custom_sql("*","af_chequeo_det","c_IChequeo='".$check['c_IChequeo']."'","","");
      $destinosCount = count($destinos);
  ?>
      <div id="dTree<? echo $check['c_IChequeo'];?>" class="col-sm-12 collapse">
        <h3>Detalles del chequeo <? echo $check['c_IChequeo'];?></h3>
        <table class="table table-striped table-condensed table-bordered">
          <tbody id="tbDestinos">
            <tr>
              <th class="iconCol"></th>
              <th >ID Destino</th>
              <th class="col-sm-6">Nombre Destino</th>
              <th >Minutos</th>
              <th class="iconCol">R</th>
              <th class="iconCol">CC</th>
              <th class="iconCol">C</th>
              <th class="iconCol">A</th>
              <th class="col-sm-1">Opciones</th>
            </tr>
            <?php 
              if ($destinosCount > 0) {
                foreach ($destinos as $dest) {
                  $resellers=select_custom_sql("*","af_chequeo_det_resellers","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."'","","");
                  $resellersCount = count($resellers);

                  $destinoName = $destinosList[$dest['c_IDestino'].""]['destination'];
                  $destinoDescription = $destinosList[$dest['c_IDestino'].""]['description'];
                  $destinoColor = is_On($dest['i_Alerta']) ? 'warning' : "";
                  $destinoColor = is_On($dest['i_Cuarentena']) ? 'danger' : $destinoColor;
            ?>
            <tr>
              <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>" data-toggle="collapse" data-parent="#tbDestinos"><span class="glyphicon glyphicon-plus"></span></a></td>
              <td class="<? echo $destinoColor; ?>"><?php echo $destinoName; ?></td>
              <td class="<? echo $destinoColor; ?>"><?php echo $destinoDescription; ?></td> <!-- Traer de PortaOne -->
              <td class="<? echo $destinoColor; ?>"><?php echo $dest['q_Min_Plataf']; ?></td>
              <td class="icon_cell white-back"><?php echo bulletCellContents("R",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon_cell white-back"><?php echo bulletCellContents("CC",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon_cell white-back"><?php echo bulletCellContents("C",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon_cell white-back"><?php echo bulletCellContents("A",$check['c_IChequeo'],$dest['c_IDestino']); ?></td>
              <td class="icon_cell white-back"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></td>
            </tr>
            <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>" class="collapse">
              <td></td>
              <td colspan="8">
                <table class="table table-striped table-condensed table-bordered">
                  <tbody id="tbResellers">
                    <tr>
                      <th class="iconCol"></th>
                      <th class="col-sm-8">Nombre Reseller</th>
                      <th >Minutos</th>
                      <th class="col-sm-1">Opciones</th>
                    </tr>
                    <?php 
                      if ($resellersCount > 0) {
                        foreach ($resellers as $res) {
                          $cClass=select_custom_sql("*","af_chequeo_det_cclass","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."' AND c_IReseller='".$res['c_IReseller']."'","","");
                          $cClassCount = count($cClass);

                          $resName = $resellersList[$res['c_IReseller']]['name'];
                          $resColor = is_On($res['i_Alerta']) ? 'warning' : "";
                          $resColor = is_On($res['i_Cuarentena']) ? 'danger' : $resColor;
                    ?>
                    <tr>
                      <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>" data-toggle="collapse" data-parent="#tbResellers"><span class="glyphicon glyphicon-plus"></span></a></td>
                      <td class="<? echo $resColor; ?>"><?php echo $resName; ?></td> <!-- Traer de PortaOne -->
                      <td class="<? echo $resColor; ?>"><? echo $res['q_Min_Reseller']; ?></td>
                      <td class="icon_cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></td>
                    </tr>
                    <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>" class="collapse">
                      <td></td>
                      <td colspan="4">
                        <table class="table table-striped table-condensed table-bordered">
                          <tbody id="tbCClass">
                            <tr>
                              <th class="iconCol"></th>
                              <th class="col-sm-8">Nombre Customer Class</th>
                              <th >Minutos</th>
                              <th class="col-sm-1">Opciones</th>
                            </tr>
                            <?php 
                              if ($cClassCount > 0) {
                                foreach ($cClass as $cc) {
                                  $customers=select_custom_sql("*","af_chequeo_det_clientes","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."' AND c_IReseller='".$res['c_IReseller']."' AND c_ICClass='".$cc['c_ICClass']."' AND (i_Alerta=1 OR i_Cuarentena=1 OR i_Bloqueo=1)","","");
                                  $customersCount = count($customers);

                                  $ccName = $ccList[$cc['c_ICClass']]['name'];
                                  $ccColor = is_On($cc['i_Alerta']) ? 'warning' : "";
                                  $ccColor = is_On($cc['i_Cuarentena']) ? 'danger' : $ccColor;
                            ?>
                            <tr>
                              <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>" data-toggle="collapse" data-parent="#tbCClass"><span class="glyphicon glyphicon-plus"></span></a></td>
                              <td class="<? echo $ccColor; ?>"><?php echo $ccName; ?></td> <!-- Traer de PortaOne -->
                              <td class="<? echo $ccColor; ?>"><? echo $cc['q_Min_CClass']; ?></td>
                              <td class="icon_cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></td>
                            </tr>
                            <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>" class="collapse">
                              <td></td>
                              <td colspan="4">
                                <table class="table table-striped table-condensed table-bordered">
                                  <tbody id="tbCustomer">
                                    <tr>
                                      <th class="iconCol"></th>
                                      <th class="col-sm-4">Nombre Cliente</th>
                                      <th >Minutos</th>
                                      <th >Bloqueado?</th>
                                      <th >F. Bloqueo</th>
                                      <th >F. Desbloqueo</th>
                                      <th >Usuario Desblq.</th>
                                      <th class="col-sm-1">Opciones</th>
                                    </tr>
                                    <?php 
                                      if ($customersCount > 0) {
                                        foreach ($customers as $cus) {
                                          $accounts=select_custom_sql("*","af_chequeo_det_cuentas","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."' AND c_IReseller='".$res['c_IReseller']."' AND c_ICClass='".$cc['c_ICClass']."' AND c_ICliente='".$cus['c_ICliente']."' AND (i_Alerta=1 OR i_Cuarentena=1 OR i_Bloqueo=1)","","");
                                          $accountsCount = count($accounts);

                                          $cusName = $customersList[$cus['c_ICliente']]['name'];
                                          $cusColor = is_On($cus['i_Alerta']) ? 'warning' : "";
                                          $cusColor = is_On($cus['i_Cuarentena']) ? 'danger' : $cusColor;
                                    ?>
                                    <tr>
                                      <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>-cus<? echo $cus['c_ICliente']; ?>" data-toggle="collapse" data-parent="#tbCustomer"><span class="glyphicon glyphicon-plus"></span></a></td>
                                      <td class="<? echo $cusColor; ?>"><?php echo $cusName; ?></td> <!-- Traer de PortaOne -->
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['q_Min_Cliente']; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? if(is_On($cus['i_Bloqueo'])) echo "Si"; else echo "No"; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['f_Bloqueo']; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['f_Desbloqueo']; ?></td>
                                      <td class="<? echo $cusColor; ?>"><? echo $cus['c_Usuario_Desbloqueo']; ?></td>
                                      <td class="icon_cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?><? if(is_On($cus['i_Bloqueo'])) echo "<span title='Desbloquear' class='glyphicon glyphicon-lock'></span>"; ?></td>
                                    </tr>
                                    <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>-cus<? echo $cus['c_ICliente']; ?>" class="collapse">
                                      <td></td>
                                      <td colspan="7">
                                        <table class="table table-striped table-condensed table-bordered">
                                          <tbody id="tbAccount">
                                            <tr>
                                              <th class="col-sm-4">Nombre Cuenta</th>
                                              <th >Minutos</th>
                                              <th >Bloqueado?</th>
                                              <th >F. Bloqueo</th>
                                              <th >F. Desbloqueo</th>
                                              <th >Usuario Desblq.</th>
                                              <th class="col-sm-1">Opciones</th>
                                            </tr>
                                            <?php 
                                              if ($accountsCount > 0) {
                                                foreach ($accounts as $acc) {

                                                  $accName = $accountsList[$acc['c_ICuenta']]['id'];
                                                  $accColor = is_On($acc['i_Alerta']) ? 'warning' : "";
                                                  $accColor = is_On($acc['i_Cuarentena']) ? 'danger' : $accColor;
                                            ?>
                                            <tr>
                                              <td class="<? echo $accColor; ?>"><?php echo $accName; ?></td> <!-- Traer de PortaOne -->
                                              <td class="<? echo $accColor; ?>"><? echo $acc['q_Min_Cuenta']; ?></td>
                                              <td class="<? echo $accColor; ?>"><? if(is_On($acc['i_Bloqueo'])) echo "Si"; else echo "No"; ?></td>
                                              <td class="<? echo $accColor; ?>"><? echo $acc['f_Bloqueo']; ?></td>
                                              <td class="<? echo $accColor; ?>"><? echo $acc['f_Desbloqueo']; ?></td>
                                              <td class="<? echo $accColor; ?>"><? echo $acc['c_Usuario_Desbloqueo']; ?></td>
                                              <td class="icon_cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?><? if(is_On($acc['i_Bloqueo'])) echo "<span title='Desbloquear' class='glyphicon glyphicon-lock'></span>"; ?></td>
                                            </tr> <!-- quinto nivel -->
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
                                      </td>
                                    </tr><!-- cuarto nivel -->
                                    <?php 
                                        }
                                      } else {
                                    ?>
                                    <tr>
                                      <td colspan=8>No se encuentran registros.</td>
                                    </tr>
                                    <?php
                                      }
                                    ?>
                                  </tbody>
                                </table>
                              </td>
                            </tr> <!-- tercer nivel -->
                            <?php 
                                }
                              } else {
                            ?>
                            <tr>
                              <td colspan=4>No se encuentran registros.</td>
                            </tr>
                            <?php
                              }
                            ?>
                          </tbody>
                        </table>
                      </td>
                    </tr> <!-- segundo nivel -->
                    <?php 
                        }
                      } else {
                    ?>
                    <tr>
                      <td colspan=4>No se encuentran registros.</td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </td>
            </tr> <!-- primer nivel -->
            <?php 
                }
              } else {
            ?>
            <tr>
              <td colspan=5>No se encuentran registros.</td>
            </tr>
            <?php
              }
            ?>
            
          </tbody>
        </table>
      </div>

  <?php
    }
  }
  ?>
    
  </div>
</div><!-- treeContainer -->

<script>
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
  $('#initialDateFil').val(today);
  $('#endDateFil').val(today);
  $('#initialDateFil').attr("max",today);
  $('#endDateFil').attr("max",today);

  //plus icon toggle
  $("a>span.glyphicon").on('click', function(){
    console.log("hice click en un mas "+$(this).html());
    var icon = $(this); 
    if(icon.hasClass("glyphicon-plus")){
      icon.removeClass( "glyphicon-plus" ).addClass( "glyphicon-minus" );
    }else if (icon.hasClass("glyphicon-minus")){
      setTimeout(function(){
        icon.removeClass( "glyphicon-minus" ).addClass( "glyphicon-plus" );
      }, 400);
    }
  });

  $(".chequeo_link").on("click",function(){
    $(".collapsible_open").collapse("hide").removeClass("collapsible_open");
    
    var collapsible_id = $(this).attr('href');
    console.log("collapsible_id:"+collapsible_id);
    $(collapsible_id).addClass("collapsible_open");
  });

</script>

<?php 
  if(isset($_POST['initialDateFil']) && isset($_POST['endDateFil'])){
?>
  <script>
  var initDate = "<?php echo $_POST['initialDateFil'] ?>";
  var endDate = "<?php echo $_POST['endDateFil'] ?>";
  
  if(initDate != ""){
    $('#initialDateFil').val(initDate);
  }
  if(endDate != ""){
    $('#endDateFil').val(endDate);  
  }
  </script>
<?php 
  }
?>

<?php include_once "footer.php" ?>