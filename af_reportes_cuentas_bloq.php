<?php
if (session_id() == "") {session_set_cookie_params(0); session_start();} // Initialize Session data
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
} ?>
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
            <span id="ewPageCaption">Reportes de Cuentas Bloqueadas</span>
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<div id="page_title" style="text-align:center; width:100%"></div>
<!-- Tabla de chequeo  -->
<div id="tableContainer" class="col-sm-12">
  <!-- <form role="form" action="" method="post"> -->
    <div class="row">
      
      <div class="col-sm-5 col-sm-offset-2">
        <div class="form-group">
          <label for="resellerFil">Reseller</label>
          <!-- <input type="text" class="form-control" id="resellerFil" name="resellerFil" required> -->
          <select class="form-control" id="resellerFil">
            <option value="">Todos</option>
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
        <button type="submit" class="btn btn-primary submit_filtros" id="gen_rep">Generar Reporte</button>
      </div>
    </div>
 <!--  </form> -->
  
  
  </div>


<script>

$(document).on('click','#gen_rep',function(){

  $(location).attr('href','download.php?type=cuentas_bloq&desde=' + $('#initialDateFil').val() 
                                              + '&hasta=' + $('#endDateFil').val() 
                                              + '&destino=' + $('#destinoFil').val() 
                                              + '&reseller=' + $('#resellerFil').find("option:selected").val()
                                              + '&cclass=' + $('#cclassFil').find("option:selected").val());
                                              
                                              

});

</script>

<?php include_once "footer.php" ?>