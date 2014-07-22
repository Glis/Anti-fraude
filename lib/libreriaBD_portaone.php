<?php
function abrirConexion_PO(){
    //session_start();
    $server="192.168.10.13:3306";
    $database="porta-billing";
    $dbpassword="panama_178$";
    $dbuser="dbread";
    
    global $conexion;
    $conexion = mysql_connect($server,$dbuser,$dbpassword);
    mysql_query("SET NAMES 'utf8'");
    if(mysql_errno()){
        die("Disculpe! Un error ha ocurrido. Intente mas tarde.1." . mysql_error());
    }else{
        if(!$conexion){
            die("Disculpe! Un error ha ocurrido. Intente mas tarde.2." . mysql_error());
        }else{
            mysql_select_db($database);                
        }
    }
}

function cerrarConexion_PO (){
    global $conexion;
    mysql_close($conexion);
}

function select_sql_PO($nombre, $ArrParams = NULL){
        switch($nombre) {

            case 'select_porta_customers' :
                $sql = "Select * from Customers";
                //$sql = "Select name from porta-billing.Customers where i_customer_type=2 and i_env=1";
                break; 

            case 'select_porta_customers_where' :
                $sql = "Select name from Customers where i_customer_type=2 and i_env=1 and i_Customer=".$ArrParams[0];
                break;
        }
    
    abrirConexion_PO();
    $ejecutar_sql = mysql_query($sql);
    if (!$ejecutar_sql) {
        $object[1]['error'] = 'error'.mysql_error();
        return $object;
    } else {
        $num_rows = @mysql_num_fields($ejecutar_sql);
        $j=0;
        $x=1;
        while($row=@mysql_fetch_array($ejecutar_sql)){
            for($j=0;$j<$num_rows;$j++){
                $name = @mysql_field_name($ejecutar_sql,$j);
                $object[$x][$name]=$row[$name];
            }
            $x++;
        }
            
        if ($x>1 && $num_rows>0) {
            return $object;
        }
            
        @mysql_free_result($ejecutar_sql);
    }
    cerrarConexion_PO();
}


?>
