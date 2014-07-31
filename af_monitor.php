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

<table class="ewStdTable">
  <tbody>
    <tr>
      <td>
        <ul class="breadcrumb">
          <li>
            <a href="login.php">Home</a>
          </li>
          <li class="active">
            <span id="ewPageCaption">Monitor general</span>
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<h1 style="text-align:center; ">Monitor General</h1>
<div id="treeContainer" class="col-sm-12">
  <!-- Tabla de chequeo  -->
  
  <div class="tableContainer row">
  	<div class="col-sm-8">
  		<h3>Tabla de Chequeos</h3>
		<table class="table table-striped table-condensed table-bordered">
		  <tbody id="tableBodyChequeo">
		    <tr>
	     	  <th class="col-sm-2">Código</th>
		      <th >Fecha Inicio Ventana</th>
		      <th >Fecha Fin Ventana</th>
		    </tr>
		    <tr>
		      <td><a href="">Cuenta 1</a></td>
		      <td>26/07/2014</td>
		      <td>27/07/2014</td>
		    </tr>
		    <tr>
		      <td><a href="">Cuenta 1</a></td>
		      <td>26/07/2014</td>
		      <td>27/07/2014</td>
		    </tr>
		    <tr>
		      <td><a href="">Cuenta 1</a></td>
		      <td>26/07/2014</td>
		      <td>27/07/2014</td>
		    </tr>
		    <tr>
		      <td><a href="">Cuenta 1</a></td>
		      <td>26/07/2014</td>
		      <td>27/07/2014</td>
		    </tr>
		    <tr>
		      <td><a href="">Cuenta 1</a></td>
		      <td>26/07/2014</td>
		      <td>27/07/2014</td>
		    </tr>
		  </tbody>
		</table>
  	</div>  	
  	<div class="col-sm-4">
  		<h3>Filtros</h3>
  		<div class="filtros form">
  			<form role="form">
  			  <div class="form-group">
  			    <label for="initialDateFil">Desde</label>
  			    <input type="date" class="form-control" id="initialDateFil" placeholder="01/01/2014">
  			  </div>
  			  <div class="form-group">
  			    <label for="endDateFil">Hasta</label>
  			    <input type="date" class="form-control" id="endDateFil" placeholder="02/01/2014">
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

  <!-- Tabla de 5 niveles -->
  <h3>Detalles</h3>
  <div class="tableContainer row">
    <table class="table table-striped table-condensed table-bordered">
      <tbody id="tablacuerpo">
        <tr>
          <th class="iconCol"></th>
          <th >ID Destino</th>
          <th class="col-sm-6">Nombre Destino</th>
          <th >Minutos</th>
          <th class="col-sm-1">Opc</th>
        </tr>
        <tr>
          <td><a href="#son1" data-toggle="collapse" data-parent="#tablacuerpo"><span class="glyphicon glyphicon-plus"></span></a></td>
          <td>1</td>
          <td>Destino 1</td>
          <td>300</td>
          <td>CDR</td>
        </tr>
        <tr id="son1" class="collapse">
          <td></td>
          <td colspan="4">
            <table class="table table-striped table-condensed table-bordered">
              <tbody id="tablacuerpo1">
                <tr>
                  <th class="iconCol"></th>
                  <th class="col-sm-8">Nombre Reseller</th>
                  <th >Minutos</th>
                  <th class="col-sm-1">Opc</th>
                </tr>
                <tr>
                  <td><a href="#son2" data-toggle="collapse" data-parent="#tablacuerpo1"><span class="glyphicon glyphicon-plus"></span></a></td>
                  <td>Reseller 1</td>
                  <td>300</td>
                  <td>CDR</td>
                </tr>
                <tr id="son2" class="collapse">
                  <td></td>
                  <td colspan="4">
                    <table class="table table-striped table-condensed table-bordered">
                      <tbody id="tablacuerpo2">
                        <tr>
                          <th class="iconCol"></th>
                          <th class="col-sm-8">Nombre Customer Class</th>
                          <th >Minutos</th>
                          <th class="col-sm-1">Opc</th>
                        </tr>
                        <tr>
                          <td><a href="#son3" data-toggle="collapse" data-parent="#tablacuerpo2"><span class="glyphicon glyphicon-plus"></span></a></td>
                          <td>Customer Class 1</td>
                          <td>300</td>
                          <td>CDR</td>
                        </tr>
                        <tr id="son3" class="collapse">
                          <td></td>
                          <td colspan="4">
                            <table class="table table-striped table-condensed table-bordered">
                              <tbody id="tablacuerpo3">
                                <tr>
                                  <th class="iconCol"></th>
                                  <th class="col-sm-6">Nombre Cliente</th>
                                  <th >Minutos</th>
                                  <th >Bloqueado?</th>
                                  <th >Fecha Ult Desbloqueo</th>
                                  <th class="col-sm-1">Opc</th>
                                </tr>
                                <tr>
                                  <td><a href="#son4" data-toggle="collapse" data-parent="#tablacuerpo3"><span class="glyphicon glyphicon-plus"></span></a></td>
                                  <td>Cliente 1</td>
                                  <td>300</td>
                                  <td>Si</td>
                                  <td>07/10/2011</td>
                                  <td>Opciones</td>
                                </tr>
                                <tr id="son4" class="collapse">
                                  <td></td>
                                  <td colspan="5">
                                    <table class="table table-striped table-condensed table-bordered">
                                      <tbody id="tablacuerpo4">
                                        <tr>
                                          <th class="col-sm-6">Nombre Cuenta</th>
                                          <th >Minutos</th>
                                          <th >Bloqueado?</th>
                                          <th >Fecha Ult Desbloqueo</th>
                                          <th class="col-sm-1">Opc</th>
                                        </tr>
                                        <tr>
                                          <td>Cuenta 1</td>
                                          <td>300</td>
                                          <td>Si</td>
                                          <td>07/10/2011</td>
                                          <td>Opciones</td>
                                        </tr> <!-- quinto nivel -->
                                      </tbody>
                                    </table>
                                  </td>
                                </tr><!-- cuarto nivel -->
                              </tbody>
                            </table>
                          </td>
                        </tr> <!-- tercer nivel -->
                      </tbody>
                    </table>
                  </td>
                </tr> <!-- segundo nivel -->
              </tbody>
            </table>
          </td>
        </tr> <!-- primer nivel -->
      </tbody>
    </table>
  </div><!-- tableContainer -->
</div>

<?php include_once "footer.php" ?>