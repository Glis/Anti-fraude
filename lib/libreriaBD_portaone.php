<?php
include("libreria.php");

$ID_ENV2 = $ID_ENV;

function abrirConexion_PO(){
    //{session_set_cookie_params(0); session_start();}
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

function abrirConexion_PO_2(&$conexion){
    //{session_set_cookie_params(0); session_start();}
    $server="192.168.10.13:3306";
    $database="porta-billing";
    $dbpassword="panama_178$";
    $dbuser="dbread";
    
   
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

function cerrarConexion_PO_2 (&$conexion){
   
    mysql_close($conexion);
}

function select_sql_PO($nombre, $ArrParams = NULL){

        global $ID_ENV2;
        
        switch($nombre) {

            case 'select_porta_customers' :
                //Select Resellers
                $sql = "SELECT * FROM Customers WHERE i_customer_type=2 AND i_env=" . $ID_ENV2 . " ORDER BY name";
                break;

            case 'select_porta_customers_where' :
                $sql = "SELECT name FROM Customers WHERE i_customer_type=2 AND i_env=" . $ID_ENV2 . " AND i_customer=".$ArrParams[0];
                break;
             
            case 'select_destinos_all':
                $sql = "SELECT * FROM Destinations WHERE i_env=" . $ID_ENV2 . " ORDER BY destination";
                break;            

            case 'select_clientes_all':
                //Select Clientes
                $sql = "SELECT * FROM Customers WHERE i_customer_type=1 AND i_env=" . $ID_ENV2 . " ORDER BY name";
                break;

            case 'select_accounts_all':
                //Select Clientes
                $sql = "SELECT * FROM Accounts WHERE i_env=" . $ID_ENV2 . " AND i_customer=".$ArrParams[0]." ORDER BY id";
                break;

            case 'select_cclass_all':
                //Populate select Umb_CClass
                $sql = "SELECT name, i_customer_class FROM Customer_Classes WHERE i_env=" . $ID_ENV2;
                break;

            case 'select_destino_where' :
                $sql = "SELECT description, destination, i_dest FROM Destinations WHERE i_env=" . $ID_ENV2 . " AND i_dest=".$ArrParams[0];
                break;

            case 'select_i_destino_where' :
                $sql = 'SELECT i_dest FROM Destinations WHERE i_env=' . $ID_ENV2 . ' AND description LIKE "%' .$ArrParams[0].'%"';
                break;

            case 'select_porta_customers_class_where' :
                //Customer Class
                $sql = "SELECT name, i_customer_class FROM Customer_Classes WHERE i_env=" . $ID_ENV2 . " AND i_customer_class =" .$ArrParams[0];
                break; 

            case 'select_porta_customers_where_class' :
                //Clientes
                $sql = "SELECT name, i_customer_class FROM Customers WHERE i_customer_type=1 AND i_env=" . $ID_ENV2 . " AND i_customer=".$ArrParams[0];
                break;

            case 'select_porta_accounts_where' :
                //Cuentas
                $sql = "SELECT id FROM Accounts WHERE i_env=" . $ID_ENV2 . " AND i_account=" . $ArrParams[0] . " AND i_customer=" . $ArrParams[1];
                break; 

            case 'select_customer_class_filtro':
                //Populate select Umb_CClass
                $sql = "SELECT name, i_customer_class FROM Customer_Classes WHERE i_env=" . $ID_ENV2 . " AND i_customer=" .$ArrParams[0];
                break;

            case 'select_customer_name_filtro':
                //Populate select Umb_CName
                $sql = "SELECT name, i_customer FROM Customers WHERE i_customer_type=1 AND i_env=" . $ID_ENV2 . " AND i_parent=" .$ArrParams[0];
                break;

            case 'select_i_client_where' :
                //Filtro Cliente
                $sql = 'SELECT name, i_customer FROM Customers WHERE i_env=' . $ID_ENV2 . ' AND i_customer_type=1 AND name LIKE "%'.$ArrParams[0].'%"';
                break;
            default:
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

function select_sql_PO_manual($nombre, $ArrParams = NULL){
        global $ID_ENV2;
        switch($nombre) {
            case 'select_porta_customers' :
                //Select Resellers
                $sql = "SELECT * FROM Customers WHERE i_customer_type=2 AND i_env=" . $ID_ENV2 . "  ORDER BY name";
                break;

            case 'select_porta_customers_where' :
                $sql = "SELECT name FROM Customers WHERE i_customer_type=2 AND i_env=" . $ID_ENV2 . "  AND i_customer=".$ArrParams[0];
                break;
             
            case 'select_destinos_all':
                $sql = "SELECT * FROM Destinations WHERE i_env=" . $ID_ENV2 . "  ORDER BY destination";
                break;            

            case 'select_clientes_all':
                //Select Clientes
                $sql = "SELECT * FROM Customers WHERE i_customer_type=1 AND i_env=" . $ID_ENV2 . "  ORDER BY name";
                break;

            case 'select_accounts_all':
                //Select Clientes
                $sql = "SELECT * FROM Accounts WHERE i_env=" . $ID_ENV2 . "  AND i_customer=".$ArrParams[0]." ORDER BY id";
                break;

            case 'select_accounts_really_all':
                //Select Clientes
                $sql = "SELECT i_account, id FROM Accounts WHERE i_env=" . $ID_ENV2 . " ORDER BY id";
                break;

            case 'select_customer_class_all':
                //Select Clientes
                $sql = "SELECT * FROM Customer_Classes WHERE i_env=" . $ID_ENV2 . " ORDER BY name";
                break;

            case 'select_destino_where' :
                $sql = "SELECT description, destination, i_dest FROM Destinations WHERE i_env=" . $ID_ENV2 . "  AND i_dest=".$ArrParams[0];
                break;

            case 'select_i_destino_where' :
                $sql = 'SELECT i_dest FROM Destinations WHERE i_env=" . $ID_ENV2 . "  AND description LIKE "%'.$ArrParams[0].'%"';
                break;

            case 'select_porta_customers_class_where' :
                //Customer Class
                $sql = "SELECT name, i_customer_class FROM Customer_Classes WHERE i_env=" . $ID_ENV2 . "  AND i_customer_class =" .$ArrParams[0];
                break; 

            case 'select_porta_customers_where_class' :
                //Clientes
                $sql = "SELECT name, i_customer_class FROM Customers WHERE i_customer_type=1 AND i_env=" . $ID_ENV2 . "  AND i_customer=".$ArrParams[0];
                break;

            case 'select_porta_accounts_where' :
                //Cuentas
                $sql = "SELECT id FROM Accounts WHERE i_env=" . $ID_ENV2 . "  AND i_account=" . $ArrParams[0] . " AND i_customer=" . $ArrParams[1];
                break; 

            case 'select_customer_class_filtro':
                //Populate select Umb_CClass
                $sql = "SELECT name, i_customer_class FROM Customer_Classes WHERE i_env=" . $ID_ENV2 . "  AND i_customer=" .$ArrParams[0];
                break;

            case 'select_customer_name_filtro':
                //Populate select Umb_CName
                $sql = "SELECT name, i_customer FROM Customers WHERE i_customer_type=1 AND i_env=" . $ID_ENV2 . "  AND i_parent=" .$ArrParams[0];
                break;

            case 'select_i_client_where' :
                //Filtro Cliente
                $sql = 'SELECT name, i_customer FROM Customers WHERE i_env=" . $ID_ENV2 . "  AND i_customer_type=1 AND name LIKE "%'.$ArrParams[0].'%"';
                break;

            case 'select_all_countries':
                $sql = 'SELECT * FROM Countries';
            default:
                break;
        }

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


}


?>
