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
  return (intval($value) < 2);
}

//INICIALIZACIÓN DEL QUERY
$chequeos=select_custom_sql("*","af_chequeo","","", "LIMIT 10");
$chequeosCount = count($chequeos);

function changeDate($date){
  $newdate = "";
  // YYYY-MM-DD
  $parts = explode("-",$date);
  $newdate = $parts[2]."/".$parts[1]."/".$parts[0];
  return $newdate;
}

if (isset($_POST['initialDateFil']) || isset($_POST['endDateFil'])) {
  $where = "";

  if(isset($_POST['initialDateFil'])){
    $where .= "STR_TO_DATE(f_Inicio,'%d/%m/%Y') >= STR_TO_DATE('".changeDate($_POST['initialDateFil'])."','%d/%m/%Y')"; 
  }
  if(isset($_POST['endDateFil'])){
    $where .= " and STR_TO_DATE(f_Fin,'%d/%m/%Y') <= STR_TO_DATE('".changeDate($_POST['endDateFil'])."','%d/%m/%Y')";
  }
  
  /*echo "<h2>POST: initialDateFil:".$_POST['initialDateFil']." endDateFil:".$_POST['endDateFil']."</h2>";
  echo "<h2>".print_custom_sql("*","af_chequeo",$where,"", "")."</h2>";*/

  $chequeos=select_custom_sql("*","af_chequeo",$where,"", "LIMIT 10");
  $chequeosCount = count($chequeos);
}

?>






<?php include_once "header.php" ?>

<!-- <pre><h4>  
<?php 
  var_dump(select_custom_sql("*","af_chequeo_det","c_IChequeo='1'","",""));
?>
</h3></pre>  -->

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
              <th class="col-sm-1">Opciones</th>
            </tr>
            <?php 
              if ($destinosCount > 0) {
                foreach ($destinos as $dest) {
                  $resellers=select_custom_sql("*","af_chequeo_det_resellers","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."'","","");
                  $resellersCount = count($resellers);
            ?>
            <tr class="<? if(is_On($dest['i_Alerta'])) echo('warning'); echo ' '; if(is_On($dest['i_Cuarentena'])) echo('danger'); ?>">
              <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>" data-toggle="collapse" data-parent="#tbDestinos"><span class="glyphicon glyphicon-plus"></span></a></td>
              <td><?php echo $dest['c_IDestino']; ?></td>
              <td>Destino <?php echo $dest['c_IDestino']; ?></td> <!-- Traer de PortaOne -->
              <td><?php echo $dest['q_Min_Plataf']; ?></td>
              <td class="icon-cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></td>
            </tr>
            <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>" class="collapse">
              <td></td>
              <td colspan="4">
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
                    ?>
                    <tr class="<? if(is_On($res['i_Alerta'])) echo('warning'); echo ' '; if(is_On($res['i_Cuarentena'])) echo('danger'); ?>">
                      <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>" data-toggle="collapse" data-parent="#tbResellers"><span class="glyphicon glyphicon-plus"></span></a></td>
                      <td>Reseller <? echo $res['c_IReseller']; ?></td> <!-- Traer de PortaOne -->
                      <td><? echo $res['q_Min_Reseller']; ?></td>
                      <td class="icon-cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></td>
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
                            ?>
                            <tr class="<? if(is_On($cc['i_Alerta'])) echo('warning'); echo ' '; if(is_On($cc['i_Cuarentena'])) echo('danger'); ?>">
                              <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>" data-toggle="collapse" data-parent="#tbCClass"><span class="glyphicon glyphicon-plus"></span></a></td>
                              <td>CClass <? echo $cc['c_ICClass']; ?></td> <!-- Traer de PortaOne -->
                              <td><? echo $cc['q_Min_CClass']; ?></td>
                              <td class="icon-cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?></td>
                            </tr>
                            <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>" class="collapse">
                              <td></td>
                              <td colspan="4">
                                <table class="table table-striped table-condensed table-bordered">
                                  <tbody id="tbCustomer">
                                    <tr>
                                      <th class="iconCol"></th>
                                      <th class="col-sm-6">Nombre Cliente</th>
                                      <th >Minutos</th>
                                      <th >Bloqueado?</th>
                                      <th >Fecha Ult Desbloqueo</th>
                                      <th class="col-sm-1">Opciones</th>
                                    </tr>
                                    <?php 
                                      if ($customersCount > 0) {
                                        foreach ($customers as $cus) {
                                          $accounts=select_custom_sql("*","af_chequeo_det_cuentas","c_IChequeo='".$check['c_IChequeo']."' AND c_IDestino='".$dest['c_IDestino']."' AND c_IReseller='".$res['c_IReseller']."' AND c_ICClass='".$cc['c_ICClass']."' AND c_ICliente='".$cus['c_ICliente']."' AND (i_Alerta=1 OR i_Cuarentena=1 OR i_Bloqueo=1)","","");
                                          $accountsCount = count($accounts);
                                    ?>
                                    <tr class="<? if(is_On($cus['i_Alerta'])) echo('warning'); echo ' '; if(is_On($cus['i_Cuarentena'])) echo('danger'); ?>">
                                      <td><a href="#ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>-cus<? echo $cus['c_ICliente']; ?>" data-toggle="collapse" data-parent="#tbCustomer"><span class="glyphicon glyphicon-plus"></span></a></td>
                                      <td>Cliente <? echo $cus['c_ICliente']; ?></td> <!-- Traer de PortaOne -->
                                      <td><? echo $cus['q_Min_Cliente']; ?></td>
                                      <td><? if(is_On($cus['i_Bloqueo'])) echo "Si"; else echo "No"; ?></td>
                                      <td><? echo $cus['f_Desbloqueo']; ?></td>
                                      <td class="icon-cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?><? if(is_On($cus['i_Bloqueo'])) echo "<span title='Desbloquear' class='glyphicon glyphicon-lock'></span>"; ?></td>
                                    </tr>
                                    <tr id="ch<? echo $check['c_IChequeo']; ?>-det<? echo $dest['c_IDestino']; ?>-res<? echo $res['c_IReseller']; ?>-cc<? echo $cc['c_ICClass']; ?>-cus<? echo $cus['c_ICliente']; ?>" class="collapse">
                                      <td></td>
                                      <td colspan="5">
                                        <table class="table table-striped table-condensed table-bordered">
                                          <tbody id="tbAccount">
                                            <tr>
                                              <th class="col-sm-6">Nombre Cuenta</th>
                                              <th >Minutos</th>
                                              <th >Bloqueado?</th>
                                              <th >Fecha Ult Desbloqueo</th>
                                              <th class="col-sm-1">Opciones</th>
                                            </tr>
                                            <?php 
                                              if ($accountsCount > 0) {
                                                foreach ($accounts as $acc) {
                                            ?>
                                            <tr class="<? if(is_On($acc['i_Alerta'])) echo('warning'); echo ' '; if(is_On($acc['i_Cuarentena'])) echo('danger'); ?>">
                                              <td>Cuenta <? echo $acc['c_ICuenta']; ?></td> <!-- Traer de PortaOne -->
                                              <td><? echo $acc['q_Min_Cuenta']; ?></td>
                                              <td><? if(is_On($acc['i_Bloqueo'])) echo "Si"; else echo "No"; ?></td>
                                              <td><? echo $acc['f_Desbloqueo']; ?></td>
                                              <td class="icon-cell"><?php echo "<span title='Descargar CDR' class='glyphicon glyphicon-floppy-save'></span>" ?><? if(is_On($acc['i_Bloqueo'])) echo "<span title='Desbloquear' class='glyphicon glyphicon-lock'></span>"; ?></td>
                                            </tr> <!-- quinto nivel -->
                                            <?php 
                                                }
                                              } else {
                                            ?>
                                            <tr>
                                              <td colspan=6>No se encuentran registros.</td>
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
                                      <td colspan=6>No se encuentran registros.</td>
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