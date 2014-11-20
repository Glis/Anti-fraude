<?php
function abrirConexion_PO(){
    $server="192.168.10.13:3306";
    $database="`porta-billing`";
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

function select_PO_sql($nombre, $ArrParams){ 
    switch($nombre) {
    case 'select_minPlat':
      // Se descartan CDR entrantes y cualquier otro tipo que NO sean llamadas
      $sql = " SELECT a.i_dest, c.i_parent, c.i_customer_class, a.i_customer, a.i_account, ceil(sum(a.used_quantity)/60) minutos " .
             "   FROM `porta-billing`.CDR_Accounts a,  " .
             "        `porta-billing`.Customers c       " .
             "  WHERE a.bill_time between STR_TO_DATE('" . $ArrParams['f_Inicio_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND STR_TO_DATE('" . $ArrParams['f_Fin_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND a.i_env           = " . $ArrParams['i_Env'] .
             "    AND a.i_customer      = c.i_customer  " .
             "    AND c.i_customer_type = 1             " .
             "    AND c.i_env           = " . $ArrParams['i_Env'] .
             "    AND a.bit_flags NOT IN (8,12)         " . 
             "  GROUP BY a.i_dest, c.i_parent, c.i_customer_class, a.i_customer, a.i_account ";
      break;
      
    case 'select_CDRsDestPlat':
      $sql = " SELECT a.i_customer, c.name customer_name, a.account_id, a.cli, a.cld, co.name country, d.i_dest, " .
             "        d.description, a.connect_time, a.disconnect_time, a.charged_amount,  " .
             "        a.charged_quantity, a.used_quantity, a.call_id " .
             "   FROM `porta-billing`.CDR_Accounts a,  " .
             "        `porta-billing`.Customers c,     " .
             "        `porta-billing`.Destinations d,  " . 
             "        `porta-billing`.Countries co     " . 
             "  WHERE a.bill_time between STR_TO_DATE('" . $ArrParams['f_Inicio_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND STR_TO_DATE('" . $ArrParams['f_Fin_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND a.i_env           = " . $ArrParams['i_Env'] .
             "    AND a.i_customer      = c.i_customer  " .
             "    AND c.i_customer_type = 1             " .
             "    AND c.i_env           = " . $ArrParams['i_Env'] .
             "    AND a.i_dest          = " . $ArrParams['c_IDestino'] .
             "    AND a.bit_flags NOT IN (8,12)            " . 
             "    AND a.i_dest          = d.i_dest         " .
             "    AND d.iso_3166_1_a2   = co.iso_3166_1_a2 " .
             "    AND d.i_env           = a.i_env          ";
      break;
             
    case 'select_CDRsDestRes':
      $sql = " SELECT a.i_customer, c.name customer_name, a.account_id, a.cli, a.cld, co.name country, d.i_dest, " .
             "        d.description, a.connect_time, a.disconnect_time, a.charged_amount,  " .
             "        a.charged_quantity, a.used_quantity, a.call_id " .
             "   FROM `porta-billing`.CDR_Accounts a,  " .
             "        `porta-billing`.Customers c,     " .
             "        `porta-billing`.Destinations d,  " . 
             "        `porta-billing`.Countries co     " . 
             "  WHERE a.bill_time between STR_TO_DATE('" . $ArrParams['f_Inicio_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND STR_TO_DATE('" . $ArrParams['f_Fin_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND a.i_env           = " . $ArrParams['i_Env'] .
             "    AND a.i_customer      = c.i_customer  " .
             "    AND c.i_customer_type = 1             " .
             "    AND c.i_env           = " . $ArrParams['i_Env'] .
             "    AND c.i_parent        = " . $ArrParams['c_IReseller'] .
             "    AND a.i_dest          = " . $ArrParams['c_IDestino'] .
             "    AND a.bit_flags NOT IN (8,12)            " . 
             "    AND a.i_dest          = d.i_dest         " .
             "    AND d.iso_3166_1_a2   = co.iso_3166_1_a2 " .
             "    AND d.i_env           = a.i_env          ";
      break;
      
    case 'select_CDRsDestCClass':
      $sql = " SELECT a.i_customer, c.name customer_name, a.account_id, a.cli, a.cld, co.name country, d.i_dest, " .
             "        d.description, a.connect_time, a.disconnect_time, a.charged_amount,  " .
             "        a.charged_quantity, a.used_quantity, a.call_id " .
             "   FROM `porta-billing`.CDR_Accounts a,  " .
             "        `porta-billing`.Customers c,     " .
             "        `porta-billing`.Destinations d,  " . 
             "        `porta-billing`.Countries co     " . 
             "  WHERE a.bill_time between STR_TO_DATE('" . $ArrParams['f_Inicio_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND STR_TO_DATE('" . $ArrParams['f_Fin_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND a.i_env            = " . $ArrParams['i_Env'] .
             "    AND a.i_customer       = c.i_customer  " .
             "    AND c.i_customer_type  = 1             " .
             "    AND c.i_env            = " . $ArrParams['i_Env'] .
             "    AND c.i_parent         = " . $ArrParams['c_IReseller'] .
             "    AND c.i_customer_class = " . $ArrParams['c_ICClass'] .
             "    AND a.i_dest           = " . $ArrParams['c_IDestino'] .
             "    AND a.bit_flags NOT IN (8,12)            " . 
             "    AND a.i_dest          = d.i_dest         " .
             "    AND d.iso_3166_1_a2   = co.iso_3166_1_a2 " .
             "    AND d.i_env           = a.i_env          ";
      break;
      
    case 'select_CDRsDestCli':
      $sql = " SELECT a.i_customer, c.name customer_name, a.account_id, a.cli, a.cld, co.name country, d.i_dest, " .
             "        d.description, a.connect_time, a.disconnect_time, a.charged_amount,  " .
             "        a.charged_quantity, a.used_quantity, a.call_id " .
             "   FROM `porta-billing`.CDR_Accounts a,  " .
             "        `porta-billing`.Customers c,     " .
             "        `porta-billing`.Destinations d,  " . 
             "        `porta-billing`.Countries co     " . 
             "  WHERE a.bill_time between STR_TO_DATE('" . $ArrParams['f_Inicio_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND STR_TO_DATE('" . $ArrParams['f_Fin_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND a.i_env            = " . $ArrParams['i_Env'] .
             "    AND a.i_customer       = c.i_customer  " .
             "    AND c.i_customer_type  = 1             " .
             "    AND c.i_env            = " . $ArrParams['i_Env'] .
             "    AND c.i_parent         = " . $ArrParams['c_IReseller'] .
             "    AND c.i_customer_class = " . $ArrParams['c_ICClass'] .
             "    AND c.i_customer       = " . $ArrParams['c_ICliente'] .
             "    AND a.i_dest           = " . $ArrParams['c_IDestino'] .
             "    AND a.bit_flags NOT IN (8,12)            " . 
             "    AND a.i_dest          = d.i_dest         " .
             "    AND d.iso_3166_1_a2   = co.iso_3166_1_a2 " .
             "    AND d.i_env           = a.i_env          ";
      break;
      
    case 'select_CDRsDestCta':
      $sql = " SELECT a.i_customer, c.name customer_name, a.account_id, a.cli, a.cld, co.name country, d.i_dest, " .
             "        d.description, a.connect_time, a.disconnect_time, a.charged_amount,  " .
             "        a.charged_quantity, a.used_quantity, a.call_id " .
             "   FROM `porta-billing`.CDR_Accounts a,  " .
             "        `porta-billing`.Customers c,     " .
             "        `porta-billing`.Destinations d,  " . 
             "        `porta-billing`.Countries co     " . 
             "  WHERE a.bill_time between STR_TO_DATE('" . $ArrParams['f_Inicio_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND STR_TO_DATE('" . $ArrParams['f_Fin_Vent'] . "', '%Y-%m-%d %H:%i:%s')  " .
             "    AND a.i_env            = " . $ArrParams['i_Env'] .
             "    AND a.i_customer       = c.i_customer  " .
             "    AND c.i_customer_type  = 1             " .
             "    AND c.i_env            = " . $ArrParams['i_Env'] .
             "    AND c.i_parent         = " . $ArrParams['c_IReseller'] .
             "    AND c.i_customer_class = " . $ArrParams['c_ICClass'] .
             "    AND c.i_customer       = " . $ArrParams['c_ICliente'] .
             "    AND a.i_account        = " . $ArrParams['c_ICuenta'] .
             "    AND a.i_dest           = " . $ArrParams['c_IDestino'] .
             "    AND a.bit_flags NOT IN (8,12)            " . 
             "    AND a.i_dest          = d.i_dest         " .
             "    AND d.iso_3166_1_a2   = co.iso_3166_1_a2 " .
             "    AND d.i_env           = a.i_env          ";
      break;
      
    case 'select_repCalidadDestino':
      $sql = " SELECT r.i_customer c_reseller, r.name reseller,                        " . 
					   "        cc.i_customer c_customerclass, cc.name customerclass,            " . 
             "        a.i_customer, c.name customer, a.account_id account,             " . 
             "        co.name country, d.i_dest, d.description destination,            " . 
             "        a.disconnect_cause, COUNT(*) llamadas, ROUND(SUM(a.used_quantity)/60,2) minutos " . 
             "   FROM `porta-billing`.CDR_Accounts a,                                  " . 
             "        `porta-billing`.Customers c,                                     " . 
             "        `porta-billing`.Customers r,                                     " . 
             "        `porta-billing`.Customers cc,                                    " . 
             "        `porta-billing`.Destinations d,                                  " . 
             "        `porta-billing`.Countries co                                     " . 
             "  WHERE date(a.bill_time) BETWEEN " . $ArrParams['f_Inicio'] . " AND " . $ArrParams['f_Fin'] . 
             "    AND a.i_env              = " . $ArrParams['i_Env']                   .
             "    AND a.i_customer         = c.i_customer                              " .
             "    AND c.i_customer_type    = 1                                         " .
             "    AND c.i_env              = a.i_env                                   " .
             "    AND a.bit_flags NOT IN (8,12)                                        " .
             "    AND a.i_dest             = d.i_dest                                  " .
             "    AND d.iso_3166_1_a2      = co.iso_3166_1_a2                          " .
             "    AND d.i_env              = a.i_env                                   " .
             "    AND r.i_customer         = c.i_parent                                " .
             "    AND r.i_env              = c.i_env                                   " .
             "    AND cc.i_customer        = c.i_customer_class                        " .
             "    AND cc.i_env             = c.i_env                                   " .
             "    AND c.i_parent           = IFNULL(" . $ArrParams['c_IReseller'] . ",c.i_parent)       " .
             "    AND c.i_customer_class   = IFNULL(" . $ArrParams['c_ICClass'] . ",c.i_customer_class) " .
             "    AND UPPER(d.description) LIKE UPPER('%" . $ArrParams['destination'] . "%')            " .
             "  GROUP BY                                             " .
             "        r.i_customer, r.name, cc.i_customer, cc.name,  " .
             "        a.i_customer, c.name, a.account_id, co.name,   " .
             "        d.i_dest, d.description, a.disconnect_cause    ";
      break;
      
    case 'select_repMinDestino':
      $sql = " SELECT r.i_customer c_reseller, r.name reseller,                        " . 
					   "        cc.i_customer c_customerclass, cc.name customerclass,            " . 
             "        co.name country, d.i_dest, d.description destination,            " . 
             "        COUNT(*) llamadas, ROUND(SUM(a.used_quantity)/60,2) minutos      " . 
             "   FROM `porta-billing`.CDR_Accounts a,                                  " . 
             "        `porta-billing`.Customers c,                                     " . 
             "        `porta-billing`.Customers r,                                     " . 
             "        `porta-billing`.Customers cc,                                    " . 
             "        `porta-billing`.Destinations d,                                  " . 
             "        `porta-billing`.Countries co                                     " . 
             "  WHERE date(a.bill_time) BETWEEN " . $ArrParams['f_Inicio'] . " AND " . $ArrParams['f_Fin'] . 
             "    AND a.i_env              = " . $ArrParams['i_Env']                   .
             "    AND a.i_customer         = c.i_customer                              " .
             "    AND c.i_customer_type    = 1                                         " .
             "    AND c.i_env              = a.i_env                                   " .
             "    AND a.bit_flags NOT IN (8,12)                                        " .
             "    AND a.i_dest             = d.i_dest                                  " .
             "    AND d.iso_3166_1_a2      = co.iso_3166_1_a2                          " .
             "    AND d.i_env              = a.i_env                                   " .
             "    AND r.i_customer         = c.i_parent                                " .
             "    AND r.i_env              = c.i_env                                   " .
             "    AND cc.i_customer        = c.i_customer_class                        " .
             "    AND cc.i_env             = c.i_env                                   " .
             "    AND c.i_parent           = IFNULL(" . $ArrParams['c_IReseller'] . ",c.i_parent)       " .
             "    AND c.i_customer_class   = IFNULL(" . $ArrParams['c_ICClass'] . ",c.i_customer_class) " .
             "    AND UPPER(d.description) LIKE UPPER('%" . $ArrParams['destination'] . "%')            " .
             "  GROUP BY                                             " .
             "        r.i_customer, r.name, cc.i_customer, cc.name,  " .
             "        co.name, d.i_dest, d.description               ";
      break;
    }
    
    abrirConexion_PO();
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
    cerrarConexion_PO();
}

?>
