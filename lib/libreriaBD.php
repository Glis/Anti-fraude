<?php
function abrirConexion(){
    //session_start();
    $server="127.0.0.1:3306";
    $database="reportes";
    $dbpassword="0000";
    $dbuser="root";
    
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

function cerrarConexion (){
    global $conexion;
    mysql_close($conexion);
}


function select_sql($nombre, $x = NULL){
        switch($nombre) {
                
        case 'select_config_data':
            $sql = "Select * from netuno.af_config";
            break;

        case 'select_usuario_admin':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $x . "'" .
                   " AND i_Admin = 1";
            break;
            
        case 'select_usuario_config':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $x . "'" .
                   " AND i_Config = 1";
            break;
            
        case 'select_usuario_activo':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $x . "'" .
                   " AND i_Activo = 1";
            break;
            
        case 'select_usuario':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $x . "'";
            break;
            
        case 'select_usuarios':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " ORDER BY c_Usuario ASC ";
            break;

        case 'select_dominio':
            $sql = "Select * from netuno.af_dominios where rv_Domain ='". $x ."'";
            break; 

        case 'select_reportes':
            $sql = "SELECT x_NbReporte " .
                   " FROM netuno.af_reportes " .
                   " ORDER BY x_NbReporte ASC ";
            break;

        }
    
    abrirConexion();
    $ejecutar_sql = mysql_query($sql);
    if (!$ejecutar_sql) {
        $object[1]['error'] = 'error';
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
    cerrarConexion();
}



?>