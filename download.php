<?php
include("lib/libreriaBDPO");

header('Content-disposition: attachment; filename=gen.txt');
header('Content-type: text/plain');


if($_GET['type'] == 'calidad_destinos'){
$data = array('f_Inicio' => '2014-05-01', 'f_fin' => '2014-06-30', 'i_env' => 1, 'c_IReseller' => 9, 'c_ICClass' => 7, )
$res = select_PO_sql('select_repCalidadDestino', );

}
?>