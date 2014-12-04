<?php
function abrirConexion(){
    //{session_set_cookie_params(0); session_start();}
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


function select_sql($nombre, $ArrParams = NULL){
        switch($nombre) {
                
        case 'select_config_data':
            $sql = "Select * from netuno.af_config";
            break;

        case 'select_usuario_admin':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $ArrParams . "'" .
                   " AND i_Admin = 1";
            break;
            
        case 'select_usuario_config':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $ArrParams . "'" .
                   " AND i_Config = 1";
            break;
            
        case 'select_usuario_activo':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $ArrParams . "'" .
                   " AND i_Activo = 1";
            break;
            
        case 'select_usuario':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $ArrParams . "'";
            break;
            
        case 'select_usuarios':
            $sql = "SELECT c_Usuario " .
                   " FROM netuno.af_usuarios " .
                   " ORDER BY c_Usuario ASC ";
            break;

        case 'select_usuario_all':
            $sql = "SELECT * " .
                   " FROM netuno.af_usuarios " .
                   " WHERE c_Usuario = '" . $ArrParams . "'" ;
            break;

        case 'select_dominio':
            $sql = "SELECT * FROM netuno.af_dominios WHERE rv_Domain ='". $ArrParams ."'";
            break;

        case 'select_dominio_high':
            $sql = "SELECT * FROM netuno.af_dominios WHERE rv_Domain ='". $ArrParams[0] ."' AND rv_High_Value=" . $ArrParams[1];
            break; 

        case 'select_dominio_low':
            $sql = "SELECT * FROM netuno.af_dominios WHERE rv_Domain ='". $ArrParams[0] ."' AND rv_Low_Value=" . $ArrParams[1];
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
            $sql = "SELECT * FROM netuno.af_log_usuario WHERE c_Usuario LIKE '%". $ArrParams ."%'";
            break;

        case 'select_url_wsdl':
            $sql = "SELECT x_Url_Wsdl FROM netuno.af_config";   
            break;

        case 'select_cclass_config':
            $sql = "SELECT p_CClass FROM netuno.af_config_reportes WHERE c_IConfig=" .$ArrParams;   
            break;

        case 'select_fecha_umb':
            $sql = "SELECT f_Ult_Mod FROM netuno.". $ArrParams[0] ." WHERE c_IDestino=" .$ArrParams[1];   
            break;

        case 'select_c_IEjecucion':
            $sql = "SELECT c_IEjecucion, f_Creacion " .
                   "  FROM netuno.af_id_Ejecucion " .
                   " ORDER BY c_IEjecucion DESC ";
            break;

        case 'select_af_chequeo':
            $sql = "SELECT IFNULL(MAX(c_IChequeo),0)+1 c_IChequeo " .
                   "  FROM netuno.af_chequeo ";
            break;
            
        case 'select_af_chequeo2':
            $sql = "SELECT f_Inicio_Vent, f_Fin_Vent " .
                   "  FROM netuno.af_chequeo         " .
                   " WHERE c_IChequeo = " . $ArrParams['c_IChequeo'];
            break;
                    
        case 'select_af_config':
            //$sql = "SELECT DATE_ADD(UTC_TIMESTAMP(), INTERVAL -q_Min_VentChequeo MINUTE) f_Inicio_Vent, " .
            //       "       UTC_TIMESTAMP() f_Fin_Vent, , x_Usuario_Api, x_Passw_Api, x_Url_Wsdl " .
            //       "  FROM netuno.af_config ";
            $sql = "SELECT DATE_ADD(UTC_TIMESTAMP(), INTERVAL -720 MINUTE) f_Inicio_Vent,     " .
                   "       UTC_TIMESTAMP() f_Fin_Vent, x_Usuario_Api, x_Passw_Api, x_Url_Wsdl " .
                   "  FROM netuno.af_config ";
            break;
        
        case 'select_rev_af_config':
            $sql = "SELECT c_IUltChequeo, IFNULL(st_Ult_Chequeo,1) st_Ult_Chequeo " .
                   "  FROM netuno.af_config ";
            break;

        case 'select_af_umb_Destinos':
            $sql = "SELECT count(*) Cantidad      " .
                   "  FROM netuno.af_umb_Destinos " .
                   " ORDER BY c_IDestino ASC ";
            break;
            
        case 'select_af_umb_Destinos2':
            $sql = "SELECT d.c_IDestino,  d.q_MinAl_Plataf, d.q_MinCu_Plataf, d.q_MinAl_Res,  " .
                   "       d.q_MinCu_Res, d.q_MinAl_CClas,  d.q_MinCu_CClas,  d.q_MinAl_Cli,  " .
                   "       d.q_MinCu_Cli, d.q_MinAl_Cta,    d.q_MinCu_Cta, SUM(q_Min) minutos " .
                   "  FROM netuno.af_umb_Destinos d, netuno.af_chequeo_Min c " .
                   " WHERE c.c_IChequeo = " . $ArrParams['c_IChequeo']  .
                   "   AND c.c_IDestino = d.c_IDestino " .
                   " GROUP BY d.c_IDestino,  d.q_MinAl_Plataf, d.q_MinCu_Plataf, d.q_MinAl_Res,  " .
                   "          d.q_MinCu_Res, d.q_MinAl_CClas,  d.q_MinCu_CClas,  d.q_MinAl_Cli,  " .
                   "          d.q_MinCu_Cli, d.q_MinAl_Cta,    d.q_MinCu_Cta " .
                   " ORDER BY c_IDestino ASC ";
            break;
        
        case 'select_af_chequeo_Min_Plat':
            $sql = "SELECT a.c_IChequeo, a.c_IDestino, a.minutos,              " .
                   "       (CASE                                               " .
                   "             WHEN a.minutos>= " . $ArrParams['q_Min_CuPlat'] . " THEN 'Cuarentena' " .
                   "             WHEN a.minutos>= " . $ArrParams['q_Min_AlPlat'] . " THEN 'Alerta'     " .
                   "       END) x_Tipo                                         " .
                   "  FROM ( SELECT c_IChequeo, c_IDestino, SUM(q_Min) minutos " .
                   "           FROM netuno.af_chequeo_Min                      " .
                   "          WHERE c_IChequeo = " . $ArrParams['c_IChequeo']  .
                   "            AND c_IDestino = '" . $ArrParams['c_IDestino'] . "'" .
                   "          GROUP BY c_IChequeo, c_IDestino ) a              " .
                   " WHERE a.minutos >=  " . $ArrParams['q_Min_AlPlat']        .
                   "    OR a.minutos >=  " . $ArrParams['q_Min_CuPlat'] ;
            break;
            
        case 'select_af_chequeo_Min_Res':
            $sql = "SELECT a.c_IChequeo, a.c_IDestino, a.c_IReseller, a.minutos, a.q_MinAl_Res, a.q_MinCu_Res, " .
                   "       (CASE                                                                               " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinCu_Res," . $ArrParams['q_Min_CuRes'] . ") THEN 'Cuarentena' " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinAl_Res," . $ArrParams['q_Min_AlRes'] . ") THEN 'Alerta'     " .
                   "       END) x_Tipo                                                                         " .
                   "  FROM ( SELECT b.c_IChequeo, b.c_IDestino, b.c_IReseller, r.q_MinAl_Res, r.q_MinCu_Res, SUM(b.q_Min) minutos " .
                   "           FROM netuno.af_chequeo_Min b                                                    " .
                   "           LEFT JOIN netuno.af_umb_Resellers r ON (    b.c_IDestino  = r.c_IDestino            " .
                   "                                                AND b.c_IReseller = r.c_IReseller )        " .
                   "          WHERE b.c_IChequeo  = "  . $ArrParams['c_IChequeo']  .
                   "            AND b.c_IDestino  = '" . $ArrParams['c_IDestino']  . "'" .
                   "          GROUP BY b.c_IChequeo, b.c_IDestino, b.c_IReseller, r.q_MinAl_Res, r.q_MinCu_Res ) a " .
                   " WHERE a.minutos >=  IFNULL(a.q_MinAl_Res, " . $ArrParams['q_Min_AlRes'] . ")" .
                   "    OR a.minutos >=  IFNULL(a.q_MinCu_Res, " . $ArrParams['q_Min_CuRes'] . ")";
            break;
            
        case 'select_af_chequeo_Min_CC':
            $sql = "SELECT a.c_IChequeo, a.c_IDestino, a.c_IReseller, a.c_ICClass, a.minutos, a.q_MinAl_CClass, a.q_MinCu_CClass, " .
                   "       (CASE                                                                               " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinCu_CClass," . $ArrParams['q_Min_CuCC'] . ") THEN 'Cuarentena' " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinAl_CClass," . $ArrParams['q_Min_AlCC'] . ") THEN 'Alerta'     " .
                   "       END) x_Tipo                                                                         " .
                   "  FROM ( SELECT b.c_IChequeo, b.c_IDestino, b.c_IReseller, b.c_ICClass, r.q_MinAl_CClass, r.q_MinCu_CClass, SUM(b.q_Min) minutos " .
                   "           FROM netuno.af_chequeo_Min b                                           " .
                   "               LEFT JOIN netuno.af_umb_CClass r ON (    b.c_IDestino  = r.c_IDestino  " .
                   "                                                AND b.c_IReseller = r.c_IReseller " .
                   "                                                AND b.c_ICClass   = r.c_ICClass ) " .
                   "          WHERE b.c_IChequeo  = "  . $ArrParams['c_IChequeo']  .
                   "            AND b.c_IDestino  = '" . $ArrParams['c_IDestino']  . "'" .
                   "          GROUP BY b.c_IChequeo, b.c_IDestino, b.c_IReseller, b.c_ICClass, r.q_MinAl_CClass, r.q_MinCu_CClass ) a " .
                   " WHERE a.minutos >=  IFNULL(a.q_MinAl_CClass, " . $ArrParams['q_Min_AlCC'] . ")" .
                   "    OR a.minutos >=  IFNULL(a.q_MinCu_CClass, " . $ArrParams['q_Min_CuCC'] . ")";
            break;
            
        case 'select_af_chequeo_Min_Cli':
            $sql = "SELECT a.c_IChequeo, a.c_IDestino, a.c_IReseller, a.c_ICClass, a.c_ICliente, a.minutos, a.q_MinAl_Cli, a.q_MinCu_Cli,  " .
                   "       (CASE                                                                               " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinCu_Cli," . $ArrParams['q_Min_CuCli'] . ") THEN 'Cuarentena' " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinAl_Cli," . $ArrParams['q_Min_AlCli'] . ") THEN 'Alerta'     " .
                   "       END) x_Tipo                                                                         " .
                   "  FROM ( SELECT b.c_IChequeo, b.c_IDestino, b.c_IReseller, b.c_ICClass, b.c_ICliente, r.q_MinAl_Cli, r.q_MinCu_Cli, SUM(b.q_Min) minutos " .
                   "           FROM netuno.af_chequeo_Min b                                           " .
                   "               LEFT JOIN netuno.af_umb_Clientes r ON (    b.c_IDestino  = r.c_IDestino  " .
                   "                                                  AND b.c_IReseller = r.c_IReseller " .
                   "                                                  AND b.c_ICliente  = r.c_ICliente )" .
                   "          WHERE b.c_IChequeo  = "  . $ArrParams['c_IChequeo']  .
                   "            AND b.c_IDestino  = '" . $ArrParams['c_IDestino']  . "'" .
                   "          GROUP BY b.c_IChequeo, b.c_IDestino, b.c_IReseller, b.c_ICClass, b.c_ICliente, r.q_MinAl_Cli, r.q_MinCu_Cli ) a " .
                   " WHERE a.minutos >=  IFNULL(a.q_MinAl_Cli, " . $ArrParams['q_Min_AlCli'] . ")" .
                   "    OR a.minutos >=  IFNULL(a.q_MinCu_Cli, " . $ArrParams['q_Min_CuCli'] . ")";
            break;
            
        case 'select_af_chequeo_Min_Cta':
            $sql = "SELECT a.c_IChequeo, a.c_IDestino, a.c_IReseller, a.c_ICClass, a.c_ICliente, a.c_ICuenta, a.minutos, a.q_MinAl_Cta, a.q_MinCu_Cta,  " .
                   "       (CASE                                                                               " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinCu_Cta," . $ArrParams['q_Min_CuCta'] . ") THEN 'Cuarentena' " .
                   "             WHEN a.minutos>= IFNULL(a.q_MinAl_Cta," . $ArrParams['q_Min_AlCta'] . ") THEN 'Alerta'     " .
                   "       END) x_Tipo                                                                         " .
                   "  FROM ( SELECT b.c_IChequeo, b.c_IDestino, b.c_IReseller, b.c_ICClass, b.c_ICliente, b.c_ICuenta, r.q_MinAl_Cta, r.q_MinCu_Cta, SUM(b.q_Min) minutos " .
                   "           FROM netuno.af_chequeo_Min b                                             " .
                   "               LEFT JOIN netuno.af_umb_Cuentas r ON (     b.c_IDestino  = r.c_IDestino  " .
                   "                                                  AND b.c_IReseller = r.c_IReseller " .
                   "                                                  AND b.c_ICliente  = r.c_ICliente  " .
                   "                                                  AND b.c_ICuenta   = r.c_ICuenta ) " .
                   "          WHERE b.c_IChequeo  = "  . $ArrParams['c_IChequeo']  .
                   "            AND b.c_IDestino  = '" . $ArrParams['c_IDestino']  . "'" .
                   "          GROUP BY b.c_IChequeo, b.c_IDestino, b.c_IReseller, b.c_ICClass, b.c_ICliente, b.c_ICuenta, r.q_MinAl_Cta, r.q_MinCu_Cta ) a " .
                   " WHERE a.minutos >=  IFNULL(a.q_MinAl_Cta, " . $ArrParams['q_Min_AlCta'] . ")" .
                   "    OR a.minutos >=  IFNULL(a.q_MinCu_Cta, " . $ArrParams['q_Min_CuCta'] . ")";
            break;
        
        case 'select_af_acc_Plataforma';
            $sql = "SELECT t_Accion " .
                   "  FROM af_acc_Plataforma " .
                   " WHERE cl_Accion = " . $ArrParams['cl_Accion'];
            break;
            
        case 'select_af_acc_Resellers';
            $sql = "SELECT t_Accion " .
                   "  FROM af_acc_Resellers " .
                   " WHERE c_IReseller = " . $ArrParams['c_IReseller'] .
                   "   AND cl_Accion   = " . $ArrParams['cl_Accion'];
            break;
            
        case 'select_af_acc_CClass';
            $sql = "SELECT t_Accion " .
                   "  FROM af_acc_CClass " .
                   " WHERE c_IReseller = " . $ArrParams['c_IReseller'] .
                   "   AND c_ICClass   = " . $ArrParams['c_ICClass']   .
                   "   AND cl_Accion   = " . $ArrParams['cl_Accion'];
            break;
            
        case 'select_af_acc_Clientes';
            $sql = "SELECT t_Accion " .
                   "  FROM af_acc_Clientes " .
                   " WHERE c_IReseller = " . $ArrParams['c_IReseller'] .
                   "   AND c_ICClass   = " . $ArrParams['c_ICClass']   .
                   "   AND cl_Accion   = " . $ArrParams['cl_Accion'];
            break;
            
        case 'select_af_acc_Cuentas';
            $sql = "SELECT t_Accion " .
                   "  FROM af_acc_Cuentas " .
                   " WHERE c_IReseller = " . $ArrParams['c_IReseller'] .
                   "   AND c_ICClass   = " . $ArrParams['c_ICClass']   .
                   "   AND cl_Accion   = " . $ArrParams['cl_Accion'];
            break;
            
        case 'select_repClientesBloq';
            $sql = "SELECT cl.c_icliente, cl.c_idestino, cl.c_ichequeo, " .
                   "      d3.rv_meaning bloqueo, d1.rv_meaning alerta,  " .
                   "      d2.rv_meaning cuarentena, cl.f_Bloqueo        " .
                   " FROM netuno.af_chequeo_Det_Clientes cl, netuno.af_dominios d1, " .
                   "      netuno.af_dominios d2, netuno.af_dominios d3 " .
                   "WHERE cl.i_bloqueo    = 1                          " .
                   "  AND cl.c_IReseller  = IFNULL(" . $ArrParams['c_IReseller'] . ", cl.c_IReseller)  " .
                   "  AND d1.rv_domain    = 'DNIO_SI_NO'               " .
                   "  AND d1.rv_low_value = cl.i_alerta                " .
                   "  AND d2.rv_domain    = 'DNIO_SI_NO'               " .
                   "  AND d2.rv_low_value = cl.i_cuarentena            " .
                   "  AND d3.rv_domain    = 'DNIO_SI_NO'               " .
                   "  AND d3.rv_low_value = cl.i_Bloqueo               " .
                   "ORDER BY cl.c_icliente, cl.f_Bloqueo desc          ";
            break;
            
        case 'select_repCuentasBloq';
            $sql = "SELECT ct.c_icliente, ct.c_ICuenta account, ct.c_idestino, ct.c_ichequeo, " .
                   "       d3.rv_meaning bloqueo, d1.rv_meaning alerta,  " .
                   "       d2.rv_meaning cuarentena, ct.f_Bloqueo        " .
                   "  FROM netuno.af_chequeo_Det_Cuentas ct, netuno.af_dominios d1, " .
                   "       netuno.af_dominios d2, netuno.af_dominios d3 " .
                   " WHERE ct.i_bloqueo    = 1                          " .
                   "   AND ct.c_IReseller  = IFNULL(" . $ArrParams['c_IReseller'] . ", ct.c_IReseller)  " .
                   "   AND d1.rv_domain    = 'DNIO_SI_NO'               " .
                   "   AND d1.rv_low_value = ct.i_alerta                " .
                   "   AND d2.rv_domain    = 'DNIO_SI_NO'               " .
                   "   AND d2.rv_low_value = ct.i_cuarentena            " .
                   "   AND d3.rv_domain    = 'DNIO_SI_NO'               " .
                   "   AND d3.rv_low_value = ct.i_Bloqueo               " .
                   " ORDER BY ct.c_icliente, ct.f_Bloqueo desc          ";
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

function update_sql ($nombre, $ArrParams){

    switch ($nombre) {
        case 'update_config':
            $sql = "UPDATE netuno.af_config set q_Min_Chequeo=".$ArrParams[0]. ", q_Min_VentChequeo=" .$ArrParams[1] .
            ", f_Ult_Chequeo='". $ArrParams[2] . "' , x_Usuario_Api ='" .$ArrParams[3]. "' , x_Passw_Api='" .$ArrParams[4]. 
            "', x_Url_Wsdl='" .$ArrParams[5]. "' , f_Ult_Mod='" .$ArrParams[6]. "' , c_Usuario_Ult_Mod='".$ArrParams[7]."'";
            break;
        
        case 'update_uf_usuarios': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_usuarios set f_Ult_Mod= '".gmdate('Y-m-d h:m:s')."' where c_Usuario=".$ArrParams[3];
            $sql = "UPDATE netuno.af_usuarios set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_Usuario='" . $ArrParams[2]. "'";
            break;

        case 'update_uf_acc_clientes': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_clientes set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IReseller=" . $ArrParams[2] . " AND c_ICClass=" . $ArrParams[3]. " AND cl_Accion=" . $ArrParams[4] . " AND t_Accion=" . $ArrParams[5];
            break;

        case 'update_uf_acc_cclass': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_cclass set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IReseller=" . $ArrParams[2] . " AND c_ICClass=" . $ArrParams[3]. " AND cl_Accion=" . $ArrParams[4] . " AND t_Accion=" . $ArrParams[5];
            break;

        case 'update_uf_acc_cuentas': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_cuentas set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IReseller=" . $ArrParams[2] . " AND c_ICClass=" . $ArrParams[3]. " AND cl_Accion=" . $ArrParams[4] . " AND t_Accion=" . $ArrParams[5];
            break;

         case 'update_uf_acc_plataforma': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_plataforma set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE cl_Accion=" . $ArrParams[2] . " AND t_Accion=" . $ArrParams[3];
            break;

        case 'update_uf_acc_reseller': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_acc_resellers set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IReseller=" .$ArrParams[2]. " AND cl_Accion=" . $ArrParams[3] . " AND t_Accion=" . $ArrParams[4];
            break;

        case 'update_uf_config_reportes': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_config_reportes set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IConfig=" .$ArrParams[2];
            break;

        case 'update_uf_reportes_usuario': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_reportes_usuario set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_Usuario=" .$ArrParams[2] . " AND c_IReporte=" . $ArrParams[3];
            break;

        case 'update_uf_resellers_usuario': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_resellers_usuario set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_Usuario=" .$ArrParams[2] . " AND c_IReseller=" . $ArrParams[3];
            break;

        case 'update_uf_umb_cclass': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_umb_cclass set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IDestino=" . $ArrParams[2] . " AND c_IReseller=" . $ArrParams[3]. " AND c_ICClass=" . $ArrParams[4];
            break;

        case 'update_uf_umb_clientes': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_umb_clientes set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IDestino=" . $ArrParams[2] . " AND c_IReseller=" . $ArrParams[3]. " AND c_ICliente=" . $ArrParams[4];
            break;

         case 'update_uf_umb_cuentas': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_umb_cuentas set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IDestino=" . $ArrParams[2] . " AND c_IReseller=" . $ArrParams[3]. " AND c_ICliente=" . $ArrParams[4]. " AND c_ICuenta=" . $ArrParams[5];
            break;

        case 'update_uf_umb_destinos': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_umb_destinos set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IDestino=" . $ArrParams[2];
            break;

        case 'update_uf_umb_resellers': //tabla - fecha - columna - primary key
            //$sql = "UPDATE netuno.af_acc_clientes SET f_Ult_Mod='2013-12-12 12:12:12' WHERE c_IReseller=9 AND c_ICClass= 5";
            $sql = "UPDATE netuno.af_umb_resellers set f_Ult_Mod='" . $ArrParams[0] . "', c_Usuario_Ult_Mod='". $ArrParams[1]."' WHERE c_IDestino=" . $ArrParams[2] . " AND c_IReseller=" . $ArrParams[3];
            break;

        case 'update_af_chequeo':
            $sql = "UPDATE netuno.af_chequeo " .
                   "   SET f_Fin      = UTC_TIMESTAMP() " .
                   " WHERE c_IChequeo =" . $ArrParams['c_IChequeo'];
            break;
            
        case 'update_af_bitacora':
            $sql = "UPDATE netuno.af_bitacora " .
                   "   SET f_Fin        = UTC_TIMESTAMP(), " .
                   "       st_Bitacora  =  " . $ArrParams['st_Bitacora']  . "," .
                   "       x_Obs        = '" . $ArrParams['x_Obs']        . "'" .
                   " WHERE c_IEjecucion = '" . $ArrParams['c_IEjecucion'] . "'";
            break;
        
        case 'update_af_config':
            $sql = "UPDATE netuno.af_config  " .
                   "   SET c_IUltChequeo  = " . $ArrParams['c_IUltChequeo'] . "," .
                   "       f_Ult_Chequeo  = UTC_TIMESTAMP(),  " .
                   "       st_Ult_Chequeo = " . $ArrParams['st_Ult_Chequeo'];
            break;

        case 'update_af_config2':
            $sql = "UPDATE netuno.af_config  " .
                   "   SET st_Ult_Chequeo =  " . $ArrParams['st_Ult_Chequeo'];
            break;
            
        case 'update_af_chequeo_Det_Clientes';
            $sql = "UPDATE netuno.af_chequeo_Det_Clientes  " .
                   "   SET i_Bloqueo            =  2,      " .
                   "       f_Desbloqueo         =  UTC_TIMESTAMP(), " .
                   "       c_Usuario_Desbloqueo =  '" . $ArrParams['c_Usuario_Desbloqueo'] . "'" .
                   " WHERE c_ICliente = " . $ArrParams['c_ICliente'] . 
                   "   AND i_Bloqueo  = 1";
            break;
            
        case 'update_af_chequeo_Det_Cuentas';
            $sql = "UPDATE netuno.af_chequeo_Det_Cuentas  " .
                   "   SET i_Bloqueo            =  2,     " .
                   "       f_Desbloqueo         =  UTC_TIMESTAMP(), " .
                   "       c_Usuario_Desbloqueo =  '" . $ArrParams['c_Usuario_Desbloqueo'] . "'" .
                   " WHERE c_ICuenta = " . $ArrParams['c_ICuenta'] . 
                   "   AND i_Bloqueo = 1";
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

function delete_sql($nombre, $ArrParams){
    switch($nombre) {
        case 'rep_facUsaSuscripcionesTemp':
            $sql = "DELETE FROM netuno.rep_facUsaSuscripcionesTemp WHERE x_idEjecucion ='" . $ArrParams['x_idEjecucion'] . "'";
            break;
    }
        
    abrirConexion();
    $ejecutar_sql = mysql_query($sql);
    if (!$ejecutar_sql) {
        return 'delete_sql:false:' . $nombre . '. Error:' . mysql_error();
    } else {
        return 'delete_sql:true';
    }
    cerrarConexion();
}

function insert_sql($nombre, $ArrParams){
    switch($nombre) {
        case 'insert_af_id_Ejecucion':
            $sql = "INSERT INTO netuno.af_id_Ejecucion ( c_IEjecucion, f_Creacion) VALUES ('" .
                   $ArrParams['c_IEjecucion'] . "', UTC_TIMESTAMP()) ";
            break;
        
        case 'insert_af_chequeo':
            $sql = "INSERT INTO netuno.af_chequeo ( c_IChequeo, f_Inicio, f_Fin, f_Inicio_Vent, f_Fin_Vent) VALUES (" .
                   $ArrParams['c_IChequeo'] . ", UTC_TIMESTAMP(), NULL, " .
                   "STR_TO_DATE('" . $ArrParams['f_Inicio_Vent'] . "', '%Y-%m-%d %H:%i:%s'), " . 
                   "STR_TO_DATE('" . $ArrParams['f_Fin_Vent'] . "', '%Y-%m-%d %H:%i:%s'))";
            break;

        case 'insert_af_chequeo_Min':
            $sql = "INSERT INTO netuno.af_chequeo_Min ( c_IChequeo, c_IDestino, c_IReseller, c_ICClass, c_ICliente, c_ICuenta, q_Min ) VALUES (" .
                   $ArrParams['c_IChequeo'] . ",'" . $ArrParams['c_IDestino'] . "','" . $ArrParams['c_IReseller'] . "','" . $ArrParams['c_ICClass'] . "','" .
                   $ArrParams['c_ICliente'] . "','" . $ArrParams['c_ICuenta'] . "', " . $ArrParams['q_Min'] . ")";
            break;
        
        case 'insert_af_chequeo_Det':
            $sql = "INSERT INTO netuno.af_chequeo_Det ( c_IChequeo, c_IDestino, q_Min_Plataf, i_Alerta, i_Cuarentena ) VALUES (" .
                   $ArrParams['c_IChequeo']   . ",'" . $ArrParams['c_IDestino'] . "'," . $ArrParams['q_Min_Plataf'] . "," . 
                   $ArrParams['i_Alerta']     . "," .
                   $ArrParams['i_Cuarentena'] . ")";
            break;
            
        case 'insert_af_chequeo_Det_Resellers':
            $sql = "INSERT INTO netuno.af_chequeo_Det_Resellers ( c_IChequeo, c_IDestino, c_IReseller, q_Min_Reseller, i_Alerta, i_Cuarentena ) VALUES (" .
                   $ArrParams['c_IChequeo']   . ",'" . $ArrParams['c_IDestino'] . "','" . $ArrParams['c_IReseller'] . "'," . $ArrParams['q_Min_Reseller'] . "," . 
                   $ArrParams['i_Alerta']     . "," .
                   $ArrParams['i_Cuarentena'] . ")";
            break;        
        
        case 'insert_af_chequeo_Det_CClass':
            $sql = "INSERT INTO netuno.af_chequeo_Det_CClass ( c_IChequeo, c_IDestino, c_IReseller, c_ICClass, q_Min_CClass, i_Alerta, i_Cuarentena ) VALUES (" .
                   $ArrParams['c_IChequeo']   . ",'" . $ArrParams['c_IDestino'] . "','" . $ArrParams['c_IReseller'] . "','" . 
                   $ArrParams['c_ICClass']    . "'," . $ArrParams['q_Min_CClass'] . "," . 
                   $ArrParams['i_Alerta']     . "," .
                   $ArrParams['i_Cuarentena'] . ")";
            break;
            
        case 'insert_af_chequeo_Det_Clientes':
            $sql = "INSERT INTO netuno.af_chequeo_Det_Clientes ( c_IChequeo, c_IDestino, c_IReseller, c_ICClass, c_ICliente, q_Min_Cliente, " .
                   "                                             i_Alerta, i_Cuarentena, i_Bloqueo ) VALUES (" .
                   $ArrParams['c_IChequeo']   . ",'"  . $ArrParams['c_IDestino'] . "','" . $ArrParams['c_IReseller'] . "','" . 
                   $ArrParams['c_ICClass']    . "','" . $ArrParams['c_ICliente'] . "', " . $ArrParams['q_Min_Cliente'] . "," . 
                   $ArrParams['i_Alerta']     . "," .
                   $ArrParams['i_Cuarentena'] . ",2)";
            break;
            
        case 'insert_af_chequeo_Det_Cuentas':
            $sql = "INSERT INTO netuno.af_chequeo_Det_Cuentas ( c_IChequeo, c_IDestino, c_IReseller, c_ICClass, c_ICliente, c_ICuenta, " .
                   "                                            q_Min_Cuenta, i_Alerta, i_Cuarentena, i_Bloqueo, f_Bloqueo, f_Desbloqueo ) VALUES (" .
                   $ArrParams['c_IChequeo']   . ",'"  . $ArrParams['c_IDestino'] . "','" . $ArrParams['c_IReseller'] . "','" . 
                   $ArrParams['c_ICClass']    . "','" . $ArrParams['c_ICliente'] . "','" . $ArrParams['c_ICuenta']   . "', " . 
                   $ArrParams['q_Min_Cuenta'] . "," . 
                   $ArrParams['i_Alerta']     . "," .
                   $ArrParams['i_Cuarentena'] . ",2,NULL,NULL)";
            break;
        
        case 'insert_af_bitacora':     
            $sql = "INSERT INTO netuno.af_bitacora ( c_IEjecucion, f_Inicio, f_Fin, t_proc, st_Bitacora, c_Usuario, x_Obs ) VALUES ('" .
                   $ArrParams['c_IEjecucion'] . "', UTC_TIMESTAMP(), NULL, " . $ArrParams['t_proc'] . ", 0, '" . 
                   $ArrParams['c_Usuario']    . "','" .
                   $ArrParams['x_Obs'] . "')";
            break;

        case 'insert_af_log_Acciones';
            $sql = "INSERT INTO netuno.af_log_Acciones ( c_ITransaccion, f_Transaccion, c_IChequeo, c_IDestino, cl_Accion, t_Accion, " .
                   "                                     nv_Accion, q_Min_Destino, c_IReseller, c_ICClass, c_ICliente, c_ICuenta,    " .
                   "                                     st_Accion, x_Obs ) VALUES (NULL," .
                   "UTC_TIMESTAMP(), " . $ArrParams['c_IChequeo'] . "," . $ArrParams['c_IDestino'] . "," . $ArrParams['cl_Accion'] . "," .
                   $ArrParams['t_Accion'] . ",'" . $ArrParams['nv_Accion'] . "'," . $ArrParams['q_Min_Destino'] . ",'" .
                   $ArrParams['c_IReseller'] . "','" . $ArrParams['c_ICClass'] . "','" . $ArrParams['c_ICliente'] . "','" .
                   $ArrParams['c_ICuenta'] . "', '0', NULL)";
            break;

        case 'execute_Detalle2':
            $sql= "CALL netuno.rep_factInsTitDetalle('" . $ArrParams['x_idEjecucion'] . "','" . $ArrParams['x_nroFactura'] . "')";
            break;
        }

    abrirConexion();
    $ejecutar_sql = mysql_query($sql);
    if (!$ejecutar_sql) {
        return 'insert_sql:false:' . $nombre . '. Error:' . mysql_error();
    } else {
        return 'insert_sql:true';
    }
    cerrarConexion();
}

?>