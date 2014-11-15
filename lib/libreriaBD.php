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

        case 'select_usuario_all':
            $sql = "SELECT * " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $x . "'" ;
            break;

        case 'select_dominio':
            $sql = "SELECT * FROM netuno.af_dominios WHERE rv_Domain ='". $x ."'";
            break;

        case 'select_dominio_high':
            $sql = "SELECT * FROM netuno.af_dominios WHERE rv_Domain ='". $x[0] ."' AND rv_High_Value=" . $x[1];
            break; 

        case 'select_dominio_low':
            $sql = "SELECT * FROM netuno.af_dominios WHERE rv_Domain ='". $x[0] ."' AND rv_Low_Value=" . $x[1];
            break; 

        case 'select_reportes':
            $sql = "SELECT c_IReporte, x_NbReporte " .
                   " FROM netuno.af_reportes " .
                   " ORDER BY x_NbReporte ASC ";
            break;

        case 'select_monitor_first_level':
            $sql = "SELECT c_IReporte, x_NbReporte " .
                   " FROM netuno.af_reportes " .
                   " ORDER BY x_NbReporte ASC ";
            break;

        case 'select_log_usuarios_filtro':
            $sql = "SELECT * FROM netuno.af_log_usuario WHERE c_Usuario LIKE '%". $x ."%'";
            break;

        case 'select_url_wsdl':
            $sql = "SELECT x_Url_Wsdl FROM netuno.af_config";   
            break;

        case 'select_cclass_config':
            $sql = "SELECT p_CClass FROM netuno.af_config_reportes WHERE c_IConfig=" .$x;   
            break;

        case 'select_fecha_umb':
            $sql = "SELECT f_Ult_Mod FROM netuno.". $x[0] ." WHERE c_IDestino=" .$x[1];   
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

function select_custom_sql($queryFields, $queryTable, $queryCondition, $queryOrderBy, $queryExtras){
    $sql = "SELECT ".$queryFields.
           " FROM netuno.".$queryTable;
    if($queryCondition <> "") $sql.=" WHERE ".$queryCondition;
    if($queryOrderBy <> "") $sql.= " ORDER BY ".$queryOrderBy;
    if($queryExtras <> "") $sql.= " ".$queryExtras; 
                
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

function print_custom_sql($queryFields, $queryTable, $queryCondition, $queryOrderBy, $queryExtras){
    $sql = "SELECT ".$queryFields.
           " FROM netuno.".$queryTable;
    if($queryCondition <> "") $sql.=" WHERE ".$queryCondition;
    if($queryOrderBy <> "") $sql.= " ORDER BY ".$queryOrderBy;
    if($queryExtras <> "") $sql.= " ".$queryExtras; 
                
    return $sql;
}

function update_sql ($nombre, $Params){

    switch ($nombre) {
        case 'update_config':
            $sql = "UPDATE netuno.af_config set q_Min_Chequeo=".$Params[0]. ", q_Min_VentChequeo=" .$Params[1] .
            ", f_Ult_Chequeo='". $Params[2] . "' , x_Usuario_Api ='" .$Params[3]. "' , x_Passw_Api='" .$Params[4]. 
            "', x_Url_Wsdl='" .$Params[5]. "' , f_Ult_Mod='" .$Params[6]. "' , c_Usuario_Ult_Mod='".$Params[7]."'";
            break;
        
        case 'update_fecha': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_usuarios set f_Ult_Mod= '".gmdate('Y-m-d h:m:s')."' where c_Usuario=".$Params[3];
            $sql = "UPDATE netuno." . $Params[0] . " set f_Ult_Mod='" . $Params[1] . "' WHERE " . $Params[2] . "=" . $Params[3];
            break;

        case 'update_username': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_usuarios set f_Ult_Mod= '".gmdate('Y-m-d h:m:s')."' where c_Usuario=".$Params[3];
            $sql = "UPDATE netuno." . $Params[0] . " set c_Usuario_Ult_Mod='" . $Params[1] . "' WHERE " . $Params[2] . "=" . $Params[3];
            break;

        case 'update_uf_acc_clientes': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_clientes set f_Ult_Mod='" . $Params[0] . "', c_Usuario_Ult_Mod='". $Params[1]."' WHERE c_IReseller=" . $Params[2] . " AND c_ICClass=" . $Params[3]. " AND cl_Accion=" . $Params[4] . " AND t_Accion=" . $Params[5];
            break;

        case 'update_uf_acc_cclass': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_cclass set f_Ult_Mod='" . $Params[0] . "', c_Usuario_Ult_Mod='". $Params[1]."' WHERE c_IReseller=" . $Params[2] . " AND c_ICClass=" . $Params[3]. " AND cl_Accion=" . $Params[4] . " AND t_Accion=" . $Params[5];
            break;

        case 'update_uf_acc_cuentas': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_cclass set f_Ult_Mod='" . $Params[0] . "', c_Usuario_Ult_Mod='". $Params[1]."' WHERE c_IReseller=" . $Params[2] . " AND c_ICClass=" . $Params[3]. " AND cl_Accion=" . $Params[4] . " AND t_Accion=" . $Params[5];
            break;

         case 'update_uf_acc_plataforma': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_plataforma set f_Ult_Mod='" . $Params[0] . "', c_Usuario_Ult_Mod='". $Params[1]."' WHERE cl_Accion=" . $Params[2] . " AND t_Accion=" . $Params[3];
            break;

        case 'update_uf_acc_reseller': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_resellers set f_Ult_Mod='" . $Params[0] . "', c_Usuario_Ult_Mod='". $Params[1]."' WHERE c_IReseller=" .$Params[2]. " AND cl_Accion=" . $Params[3] . " AND t_Accion=" . $Params[4];
            break;

        default:
            break;
    }
     abrirConexion();
    $ejecutar_sql = mysql_query($sql);
    if (!$ejecutar_sql) {
        return 'update_sql:false:' . $nombre . '. Error:' . mysql_error();
    } else {
        return 'update_sql:true';
    }
    
    cerrarConexion();
}



?>