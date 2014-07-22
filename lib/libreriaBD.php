<?php
function abrirConexion(){
    //session_start();
    $server="localhost:3306";
    $database="netuno";
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

function select_sql($nombre, $x){
        switch($nombre) {
        case 'select_id_Proceso':
            $sql = "SELECT x_idProceso " .
                   "  FROM netuno.af_procesos " .
                   " WHERE x_pagina = '" .$x. "'";
            break;

        case 'select_Procesos':
            $sql = "SELECT x_idProceso, x_nbProceso, x_pagina " .
                   "  FROM netuno.af_procesos " .
                   " WHERE x_nbProceso != 'Proceso de Cobro de Suscripciones USA Prepago' " .
                   " ORDER BY x_nbProceso ASC";
            break;

        case 'select_Reportes_Procesos':
            $sql = "SELECT x_idReporte, x_nbReporte, x_pagina FROM netuno.af_reportes " .
                   "UNION " .
                   "SELECT x_idProceso x_idReporte, x_nbProceso x_nbReporte, x_Pagina FROM netuno.af_procesos " .
                   "ORDER BY x_nbReporte ASC";
            break;

        case 'select_facUsaTransacciones_E1':
            $sql = "SELECT x_ICustomer, x_ActiveSubscriptions, x_TotalSubscriptions, i_AutoPayment, i_Pay " .
                   "FROM netuno.af_facUsaTransacciones WHERE x_Status = 'ERROR1' AND x_idEjecucion =" .$x;
            break;

        case 'select_facUsaTransacciones_E2':
            $sql = "SELECT x_ICustomer FROM netuno.af_facUsaTransacciones WHERE x_Status = 'ERROR2' AND x_idEjecucion =" .$x;
            break;

        case 'select_facUsaTransacciones_E3':
            $sql = "SELECT x_ICustomer, x_ActiveSubscriptions, x_TotalSubscriptions " .
                   "FROM netuno.af_facUsaTransacciones WHERE x_Status = 'ERROR3' AND x_idEjecucion = " .$x.
                   " ORDER BY x_ICustomer ASC ";
            break;

        case 'select_facUsaTransacciones_E4':
            $sql = "SELECT x_ICustomer, x_ActiveSubscriptions, x_TotalSubscriptions, i_AutoPayment " .
                   "FROM netuno.af_facUsaTransacciones WHERE x_Status = 'ERROR4' AND x_idEjecucion = " .$x.
                   " ORDER BY x_ICustomer ASC ";
            break;

        case 'select_facUsaTransacciones_AutoPayE5':
            $sql = "SELECT x_ICustomer, x_ActiveSubscriptions, x_TotalSubscriptions, i_Pay " .
                   "FROM netuno.af_facUsaTransacciones WHERE x_Status = 'ERROR5' AND x_idEjecucion = " .$x.
                   " ORDER BY x_ICustomer ASC ";
            break;

        case 'select_facUsaTransacciones_AutoPayOK':
            $sql = "SELECT x_ICustomer, x_ActiveSubscriptions, x_TotalSubscriptions, x_ITransaction, x_Authorization, x_ResultCode, i_Pay " .
                   "FROM netuno.af_facUsaTransacciones WHERE x_Status = 'OK-WARNING1' AND x_idEjecucion = ".$x.
                   " ORDER BY x_ICustomer ASC ";
            break;

        case 'select_facUsaTransacciones_PayE6':
            $sql = "SELECT x_ICustomer, x_ActiveSubscriptions, x_TotalSubscriptions, i_Pay, i_AutoPayment " .
                   "FROM netuno.af_facUsaTransacciones WHERE x_Status = 'ERROR6' AND x_idEjecucion = " .$x.
                   " ORDER BY x_ICustomer ASC ";
            break;

        case 'select_facUsaTransacciones_PayOK':
            $sql = "SELECT x_ICustomer, x_ActiveSubscriptions, x_TotalSubscriptions, x_ITransaction, x_Authorization, x_ResultCode, i_AutoPayment, i_Pay " .
                   "FROM netuno.af_facUsaTransacciones WHERE x_Status = 'OK-WARNING2' AND x_idEjecucion = ".$x.
                   " ORDER BY x_ICustomer ASC ";
            break;

        case 'select_rep_facUsaPeriodo':
            $sql = "SELECT x_MesAnio, x_Intentos, x_Status, x_idEjecucion FROM netuno.af_facUsaPeriodo WHERE x_MesAnio = '" . $x . "'";
            break;

        case 'select_periodos':
            $sql = "SELECT x_MesAnio FROM netuno.af_facUsaPeriodo WHERE x_idPortaOne = '" .$x . "'" .
                   " ORDER BY x_MesAnio ASC ";
            break;

        case 'select_facUsaClientes':
            $sql = "SELECT x_ICustomer FROM netuno.af_facUsaClientes WHERE x_idEjecucion = " .$x;
            break;

        case 'select_facUsaCuentas':
            $sql = "SELECT x_IAccount, x_ICustomer FROM netuno.af_facUsaCuentas WHERE x_idEjecucion = " .$x;
            break;

        case 'select_facUsaCuentasTemp':
            $sql = "SELECT x_IAccount, x_ICustomer FROM netuno.af_facUsaCuentasTemp WHERE x_idEjecucion = " .$x;
            break;

        case 'select_facUsaSuscripClientesCuentas':
            $sql = "SELECT DISTINCT x_ICustomer FROM netuno.af_facUsaSuscripClientes WHERE x_idEjecucion = '" . $x . "' " .
                   "UNION " .
                   "SELECT DISTINCT x_ICustomer FROM netuno.af_facUsaSuscripCuentas WHERE x_idEjecucion = '" . $x . "' ";
            break;

        case 'select_facUsaSuscripNuevas':
            $sql = "SELECT A.x_ISubscription, A.x_NbSubscription FROM netuno.af_facUsaSuscripcionesTemp A " .
                   " WHERE A.x_idEjecucion = '" . $x . "' " .
                   "   AND A.x_ISubscription NOT IN (SELECT B.x_ISubscription FROM netuno.af_facUsaSuscripciones B " .
                   "                                  WHERE B.x_idPortaOne = A.x_idPortaOne )";
            break;

        case 'select_facUsaSuscripciones':
            $sql = "SELECT A.x_ISubscription, A.x_NbSubscription FROM netuno.af_facUsaSuscripcionesTemp A " .
                   " WHERE A.x_idEjecucion = '" . $x . "' " .
                   "   AND A.x_ISubscription IN (SELECT B.x_ISubscription FROM netuno.af_facUsaSuscripciones B " .
                   "                              WHERE B.x_idPortaOne = A.x_idPortaOne )";
            break;

        case 'select_reportes_usuario_no_asoc':
            $sql = "SELECT x_idReporte, x_nbReporte " .
                   " FROM netuno.af_reportes " .
                   " WHERE x_idReporte not in " .
                   " (SELECT x_idReporte FROM netuno.af_reportesxUsuario WHERE c_Usuario = '".$x."') " .
                   " ORDER BY x_nbReporte ASC";
            break;

        case 'select_procesos_usuario_no_asoc':
            $sql = "SELECT x_idProceso, x_nbProceso " .
                   " FROM netuno.af_procesos " .
                   " WHERE x_nbProceso != 'Proceso de Cobro de Suscripciones USA Prepago' " . 
                   " AND x_idProceso not in " .
                   " (SELECT x_idProceso FROM netuno.af_procesosxUsuario WHERE c_Usuario = '".$x."') " .
                   " ORDER BY x_nbProceso ASC";
            break;

        case 'select_Reportes':
            $sql = "SELECT x_idReporte, x_nbReporte, x_pagina " .
                   "  FROM netuno.af_reportes " .
                   " ORDER BY x_nbReporte ASC";
            break;
            
        case 'select_id_Reporte':
            $sql = "SELECT x_idReporte " .
                   "  FROM netuno.af_reportes " .
                   " WHERE x_pagina = '" .$x. "'";
            break;
            
        case 'select_id_Ejecucion':
            $sql = "SELECT x_idEjecucion, x_FechaCreacion " .
                   "  FROM netuno.af_IdEjecucion " .
                   " ORDER BY x_idEjecucion DESC ";
            break;
            
        case 'select_id_Ejecucion2':
            $sql = "SELECT x_idEjecucion, x_FechaCreacion " .
                   "  FROM netuno.af_IdEjecucion " .
                   " WHERE x_idReporte = '" .$x. "'" .
                   " ORDER BY x_idEjecucion DESC ";
            break;
            
        case 'select_obs_bitacora':
            $sql = "SELECT x_Obs FROM netuno.af_bitacora WHERE x_idEjecucion = " . $x;
            break;
            
        case 'select_Reseller':
            $sql = "SELECT x_IReseller, x_NbReseller " .
                   "  FROM netuno.af_reseller " . 
                   " ORDER BY x_NbReseller ASC";
            break;
            
        case 'select_DestinosConatel':
            $sql = "SELECT x_IdDestConatel, x_DestConatel " .
                   "  FROM netuno.af_destConatel " .
                   " ORDER BY x_DestConatel ASC";
            break;
            
        case 'select_CountryPorta':
            $sql = "SELECT x_IdCountryPorta, x_NbCountryPorta " .
                   "  FROM netuno.af_countryPorta " .
                   " ORDER BY x_NbCountryPorta ASC";
            break;
            
        case 'select_CountryDestPorta':
            $sql = "SELECT x_IdCountryPorta, x_IdCountryDestPorta, x_NbCountryDestPorta " .
                   "  FROM netuno.af_countryDestPorta " .
                   " ORDER BY x_NbCountryDestPorta ASC";
            break;            

        case 'select_resellers_usuario_no_asoc':
            $sql = "SELECT x_IReseller, " .
                   "       (CASE x_idPortaOne " .
                   "             WHEN '1' THEN CONCAT(x_NbReseller, ' (CR)') " .
                   "             WHEN '2' THEN CONCAT(x_NbReseller, ' (PA)') " .
                   "       END) x_NbReseller     " .
                   " FROM netuno.af_reseller " .
                   " WHERE x_IReseller not in " .
                   " (SELECT x_IReseller FROM netuno.af_resellersxusuario WHERE c_Usuario = '".$x."') " .
                   " ORDER BY x_NbReseller ASC";
            break;

        case 'select_resellers_usuario':
            $sql = "SELECT x_IReseller, " .
                   "       (CASE x_idPortaOne " .
                   "             WHEN '1' THEN CONCAT(x_NbReseller, ' (CR)') " .
                   "             WHEN '2' THEN CONCAT(x_NbReseller, ' (PA)') " .
                   "       END) x_NbReseller     " .
                   "  FROM netuno.af_reseller " .
                   " WHERE x_IReseller in " .
                   " (SELECT x_IReseller FROM netuno.af_resellersxusuario WHERE c_Usuario = '".$x."' AND x_idPortaOne = '" . $_SESSION["PORTAONE"] . "') " .
                   " ORDER BY x_NbReseller ASC";
            break;

        case 'select_Reportes_Usuario':
            $sql = "SELECT x_pagina, x_nbReporte " .
                   "  FROM netuno.af_reportes " .
                   " WHERE x_idReporte in " .
                   " (SELECT x_idReporte FROM netuno.af_reportesxUsuario WHERE c_Usuario = '".$x."') " .
                   " ORDER BY x_nbReporte ASC";
            break;

        case 'select_Procesos_Usuario':
            $sql = "SELECT x_pagina, x_nbProceso " .
                   " FROM netuno.af_procesos " .
                   " WHERE x_nbProceso != 'Proceso de Cobro de Suscripciones USA Prepago' AND x_idProceso in " .
                   " (SELECT x_idProceso FROM netuno.af_procesosxUsuario WHERE c_Usuario = '".$x."') " .
                   " ORDER BY x_nbProceso ASC";
            break;
            
        case 'select_Reseller_xID':
            $sql = "SELECT x_IReseller, " .
                   "       (CASE x_idPortaOne " .
                   "             WHEN '1' THEN CONCAT(x_NbReseller, ' (CR)') " .
                   "             WHEN '2' THEN CONCAT(x_NbReseller, ' (PA)') " .
                   "       END) x_NbReseller     " .
                   "  FROM netuno.af_reseller " .
                   "  WHERE x_IReseller = ". $x;
            break;

        case 'select_Reporte_xID':
            $sql = "SELECT x_idReporte, x_nbReporte " .
                   "  FROM netuno.af_reportes " .
                   "  WHERE x_idReporte = ". $x;
            break;

        case 'select_Proceso_xID':
            $sql = "SELECT x_idProceso, x_nbProceso " .
                   "  FROM netuno.af_procesos " .
                   "  WHERE x_nbProceso != 'Proceso de Cobro de Suscripciones USA Prepago' AND x_idProceso = ". $x;
            break;
            
        case 'select_nb_Reseller':
            $sql = "SELECT x_idPortaOne, " .
                   "       (CASE x_idPortaOne " .
                   "             WHEN '1' THEN CONCAT(x_NbReseller, ' (CR)') " .
                   "             WHEN '2' THEN CONCAT(x_NbReseller, ' (PA)') " .
                   "       END) x_NbReseller     " .
                   "  FROM netuno.af_reseller " .
                   " WHERE x_IReseller = ". $x;
            break;
            
        case 'select_nb_Reseller2':
            $sql = "SELECT x_idPortaOne, " .
                   "       x_NbReseller  " .
                   "  FROM netuno.af_reseller " .
                   " WHERE x_IReseller = ". $x;
            break;

        case 'select_id_Reseller':
            $sql = "SELECT x_IReseller " .
                   "  FROM netuno.af_reseller " .
                   " WHERE x_NbReseller = '". $x . "'";
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
            
        case 'select_Clientes_FollowMe':
            $sql = " select cu.x_IAccount, cu. x_IParent, cu.x_ICustomer, cu.x_follow_me_enabled  " .
                   "   from netuno.af_didCuentas cu             " .
                   "  where cu.x_idEjecucion       = " . $x        .
                   "    and cu.x_follow_me_enabled = 'Y'";
            break; 
            
        case 'select_Trafico':
            $sql = "SELECT CL.x_Name AS CUSTOMER_ID,              " .
                   "      CL.x_NombreSuscriptor AS COMPANY_NAME,  " .
                   "      CL.x_CIRifCliente AS TAXID,             " .
                   "      CL.x_Login AS LOGIN,                    " .
                   "      CC.x_NbCustomerClass AS CUSTOMER_CLASS, " .
                   "      IF(CD.x_Country='','NOT AVAILABLE',CD.x_Country) AS COUNTRY,           " .
	                 "      IF(CD.x_Description='','NOT AVAILABLE',CD.x_Description) AS DESCRIPTION, " .
                   "      IF(CD.d_Monto=0,'PLAN','NOT PLAN') AS CALL_TYPE, " .
                   "      SUM(CD.d_Monto) AS TOTAL_AMOUNT,                 " .
                   "      CL.x_Moneda  AS CURRENCY,                        " .
                   "      SUM(CD.d_Segundos) TOTAL_SEC,                    " .
                   "      SUM(CD.d_Minutos) TOTAL_MIN                      " .
                   " FROM netuno.af_trafClientes CL, netuno.af_trafCustomerClass CC, netuno.af_trafCDRS CD " .
                   "WHERE CL.x_idEjecucion    = " . $x .
                   "  AND CC.x_idEjecucion    = CL.x_idEjecucion           " .
                   "  AND CC.x_ICustomerClass = CL.x_CustomerClass         " .
                   "  AND CD.x_idEjecucion    = CL.x_idEjecucion           " .
                   "  AND CD.x_iCustomer      = CL.x_iCustomer             " .
                   "GROUP BY CL.x_Name, CL.x_NombreSuscriptor, CL.x_CIRifCliente, CL.x_Login, CC.x_NbCustomerClass, " .
                   "      IF(CD.x_Country='','NOT AVAILABLE',CD.x_Country),                                         " .
                   "      IF(CD.x_Description='','NOT AVAILABLE',CD.x_Description),                                 " .
                   "      IF(CD.d_Monto=0,'PLAN','NOT PLAN'), CL.x_Moneda                                           " .
                   "ORDER BY 1,5,6,7 ";
            break; 
            
        case 'select_TraficoDet':
            $sql = "SELECT CL.x_Name AS CUSTOMER_ID,               " .
                   "       CL.x_NombreSuscriptor AS COMPANY_NAME,  " .
                   "       CL.x_CIRifCliente AS TAXID,             " .
                   "       CL.x_Login AS LOGIN,                    " .
                   "       CC.x_NbCustomerClass AS CUSTOMER_CLASS, " .
                   "       CL.x_Phone AS PHONE,                    " .
                   "       CL.x_Email AS EMAIL,                    " .
                   "       CL.x_Bill_Status AS BILL_STATUS,        " .
                   "       CL.x_Balance AS BALANCE,                " .
                   "       CL.x_Moneda  AS CURRENCY,               " .
                   "       CD.x_IAccount AS ACCOUNT,               " .
                   "       IF(CD.x_Cli='','NOT AVAILABLE',CD.x_Cli) AS XFROM,            " .
                   "       IF(CD.x_Cld='','NOT AVAILABLE',CD.x_Cld) AS XTO,              " .
                   "       IF(CD.x_Country='','NOT AVAILABLE',CD.x_Country) AS COUNTRY,  " .
	                 "       IF(CD.x_Description='','NOT AVAILABLE',CD.x_Description) AS DESCRIPTION, " .
                   "       CD.x_FechaHora AS DATE_TIME,            " .
                   "       CD.d_Segundos  AS TOTAL_SEC,            " .
                   "       CD.d_Minutos   AS TOTAL_MIN,            " .
                   "       CD.d_Monto     AS TOTAL_AMOUNT          " .
                   "  FROM netuno.af_trafClientes CL, netuno.af_trafCustomerClass CC, netuno.af_trafCDRS CD " .
                   " WHERE CL.x_idEjecucion    = " . $x .
                   "   AND CC.x_idEjecucion    = CL.x_idEjecucion           " .
                   "   AND CC.x_ICustomerClass = CL.x_CustomerClass         " .
                   "   AND CD.x_idEjecucion    = CL.x_idEjecucion           " .
                   "   AND CD.x_iCustomer      = CL.x_iCustomer             " .
                   "ORDER BY 5, 1, 10, 15 ";
            break; 
            
        case 'select_ReporteCob':
            $sql = "select re.x_NbReseller x_NbParent,  cl.x_IParent,                       " .
                   "       IFNULL(cc.x_NbCustomerClass,'UNDEFINED') x_NbCustomerClass, cl.x_ICustomer, cl.x_Name, cl.x_Login, " .
                   "       cl.x_First_Name, cl.x_Last_Name, cl.x_CompanyName, cl.x_TaxID,   " .
                   "       cl.x_Balance, cl.x_Iso4217, cl.x_phone1, cl.x_phone2, cl.x_cont1," .
                   "       cl.x_cont2, cl.x_email, cl.x_credit_limit, cl.x_blocked,         " .
                   "       cl.x_bill_status, cl.x_Vendor, cl.x_Creation_Date                " .
                   "  from netuno.af_reseller re, netuno.af_cobClientes cl            " .
                   "  left join netuno.af_cobCustomerClass cc ON (     cc.x_idEjecucion    = cl.x_idEjecucion      " .
                   "                                                  and cc.x_IParent        = cl.x_IParent          " .
                   "                                                  and cc.x_ICustomerClass = cl.x_ICustomerClass ) " .
                   " where cl.x_idEjecucion    = " . $x . 
                   "   and re.x_IReseller      = cl.x_IParent ";
            break;
            
        case 'select_ReporteCxC':
            $sql = " select re.x_NbReseller x_NbParent, cl.x_IParent,                       " .
                   "        IFNULL(cc.x_NbCustomerClass,'UNDEFINED') x_NbCustomerClass,     " .
                   "        cl.x_ICustomer, cl.x_Name, cl.x_Login,                          " .
                   "        cl.x_First_Name, cl.x_Last_Name, cl.x_CompanyName, cl.x_TaxID,  " .
                   "        cl.x_Balance, cl.x_Moneda, cl.x_Phone, cl.x_Email,              " .
                   "        cl.x_Bill_Status,                                               " .
                   "        cl.x_Suspended_Date,                                            " .
                   " 	      cl.x_Closed_Date,                                               " .
                   "        IFNULL(cc.x_InvoiceGracePeriod, 0) x_InvoiceGracePeriod,        " .
                   "        IFNULL(cc.x_SuspensionTime, 0) x_SuspensionTime                 " .
                   "   from netuno.af_reseller re, netuno.af_ccClientes cl            " .
                   "   left join netuno.af_ccCustomerClass cc ON (     cc.x_idEjecucion    = cl.x_idEjecucion       " .
                   "                                                  and cc.x_ICustomerClass = cl.x_ICustomerClass )  " .
                   "  where cl.x_idEjecucion = " . $x . 
                   "    and re.x_IReseller   = cl.x_IParent " .
                   "    and ((cl.x_Bill_Status = 'S') or (cl.x_Bill_Status = 'O' and cl.x_Balance>0) or (cl.x_Bill_Status = 'C' and cl.x_Balance>0))";
            break;            
            
        case 'select_ReporteStCuentas':
            $sql = "select re.x_NbReseller x_NbParent, IFNULL(cc.x_NbCustomerClass, 'UNDEFINED') x_NbCustomerClass, " .
                   "       cl.x_ICustomer, cl.x_CompanyName, cl.x_Login,                  " .
                   "       ct.x_IAccount, ct.x_IdAccount,                                 " .
                   "       (CASE ct.x_StAccount                                           " .
                   "         WHEN 0 THEN 'Normal'                                         " .
                   "         WHEN 1 THEN 'Screening – allow calls only via screening app' " .
                   "         WHEN 2 THEN 'Screening – user failed to validate 1x'         " .
                   "         WHEN 3 THEN 'Screening – user failed to validate 2x'         " .
                   "         WHEN 4 THEN 'Screening – user failed to validate 3x'         " .
                   "         WHEN 5 THEN 'Quarantine – disallow any calls'                " .
                   "        END) x_XStAccount                                             " .
                   "  from netuno.af_reseller re, netuno.af_stcCuentas ct,          " .
                   "       netuno.af_stcClientes cl                                    " .
                   "  left join netuno.af_stcCustomerClass cc on (    cc.x_IParent        = cl.x_IParent         " .
                   "                                                 and cc.x_ICustomerClass = cl.x_ICustomerClass  " .
                   "                                                 and cc.x_idEjecucion    = cl.x_idEjecucion    )" .
                   " where cl.x_idEjecucion    = " . $x .
                   "   and ct.x_IParent        = cl.x_IParent     " .
                   "   and ct.x_ICustomer      = cl.x_ICustomer   " .
                   "   and ct.x_idEjecucion    = cl.x_idEjecucion " .
                   "   and re.x_IReseller      = cl.x_IParent     ";
            break;
            
        case 'select_ReporteStSipCuentas':
            $sql = "select re.x_NbReseller x_NbParent, IFNULL(cc.x_NbCustomerClass, 'UNDEFINED') x_NbCustomerClass, " .
                   "       cl.x_ICustomer, cl.x_CompanyName, cl.x_Login, cl.x_Email,      " .
                   "       ct.x_IAccount, ct.x_IdAccount,                                 " .
                   "       ct.x_IpDevice, ct.x_Currency,                                  " .
                   "       (CASE ct.x_StSipAccount                                        " .
                   "         WHEN 0 THEN 'Offline'                                        " .
                   "         WHEN 1 THEN 'Online'                                         " .
                   "        END) x_StSipAccount, ct.x_SipContact                          " .
                   "  from netuno.af_reseller re, netuno.af_stcSipCuentas ct,       " .
                   "       netuno.af_stcSipClientes cl                                 " . 
                   "  left join netuno.af_stcSipCustomerClass cc on (    cc.x_IParent        = cl.x_IParent        " .
                   "                                                    and cc.x_ICustomerClass = cl.x_ICustomerClass " .
                   "                                                    and cc.x_idEjecucion    = cl.x_idEjecucion   )" .
                   " where cl.x_idEjecucion    = " . $x .
                   "   and ct.x_IParent        = cl.x_IParent       " .
                   "   and ct.x_ICustomer      = cl.x_ICustomer     " .
                   "   and ct.x_idEjecucion    = cl.x_idEjecucion   " .
                   "   and re.x_IReseller      = cl.x_IParent       " .
                   "   and ct.x_IpDevice       is not null          ";
            break;
            
        case 'select_ReporteDID':
            $sql = " select re.x_NbReseller, cu.x_IdAccount,                       " .
                   "       (CASE                                                   " .
                   "         WHEN substr(pr.x_NbProduct,1,9 ) = 'VZLA - CC'  THEN 'VZLA - CC'                  " .
                   "         WHEN substr(pr.x_NbProduct,1,10) = 'VZLA - CDT' THEN 'VZLA - CDT'                 " .
                   "         WHEN substr(pr.x_NbProduct,1,18) = 'VZLA - CORPORATIVO' THEN 'VZLA - CORPORATIVO' " .
                   "         WHEN substr(pr.x_NbProduct,1,18) = 'VZLA - RESIDENCIAL' THEN 'VZLA - RESIDENCIAL' " .
                   "         ELSE pr.x_NbProduct                                   " .
                   "        END) x_NbProduct, cu.x_lastUsage                       " .
                   " from netuno.af_didClientes cl, netuno.af_didCuentas cu, " .
                   "       netuno.af_didProductos pr, netuno.af_reseller re  " .
                   " where cl.x_idEjecucion = " . $x .
                   "   and re.x_IReseller   = cl.x_IParent                         " .
                   "   and cu.x_IParent     = cl.x_IParent                         " .
                   "   and cu.x_ICustomer   = cl.x_ICustomer                       " .
                   "   and cu.x_idEjecucion = cl.x_idEjecucion                     " .
                   "   and pr.x_idEjecucion = cu.x_idEjecucion                     " .
                   "   and pr.x_IProduct    = cu.x_IProduct                        ";
            break; 
            
        case 'select_ReporteDIDFM':
            $sql = " select re.x_NbReseller, cu.x_IdAccount, cc.x_NbCustomerClass, fm.x_RedirectNumber                 " .
                   "   from netuno.af_didClientes cl, netuno.af_didCuentas cu, netuno.af_didCustomerClass cc, " .
                   "        netuno.af_didCuentasFM fm, netuno.af_reseller re " .
                   "  where cl.x_idEjecucion    = " . $x .
                   "    and re.x_IReseller      = cl.x_IParent        " .
                   "    and cu.x_IParent        = cl.x_IParent        " .
                   "    and cu.x_ICustomer      = cl.x_ICustomer      " .
                   "    and cu.x_idEjecucion    = cl.x_idEjecucion    " .
                   "    and cc.x_IParent        = cl.x_IParent        " .
                   "    and cc.x_ICustomerClass = cl.x_ICustomerClass " .
                   "    and cc.x_idEjecucion    = cl.x_idEjecucion    " .
                   "    and fm.x_IParent        = cu.x_IParent        " .
                   "    and fm.x_ICustomer      = cu.x_ICustomer      " .
                   "    and fm.x_idEjecucion    = cu.x_idEjecucion    " .
                   "    and fm.x_IAccount       = cu.x_IAccount       ";
            break; 
            
        case 'select_Clientes_ICustomer':
            //Se excluyen los Customer con x_bill_status = C (Closed) por falla de API al obtener las subcripciones de customers con dicho bill_status
            $sql = "SELECT DISTINCT x_IParent, x_ICustomer " .
                  "   FROM netuno.af_cobClientes " .
                  "  WHERE x_idEjecucion = " . $x .
                  "    AND x_bill_status <> 'C' " . 
                  "  ORDER BY x_IParent, x_ICustomerClass, x_ICustomer ASC ";
            break;
            
        case 'select_Clientes_CC':
            $sql = "SELECT DISTINCT x_IParent, x_ICustomer, x_Bill_Status " .
                  "   FROM netuno.af_ccClientes " .
                  "  WHERE x_idEjecucion = " . $x .
                  "    AND (x_Bill_Status = 'S' OR (x_Bill_Status = 'C' AND x_Balance >0))" . 
                  "  ORDER BY x_IParent, x_ICustomer ASC ";
            break;
            
        case 'select_Clientes_ASEPCuentas':
            //Se excluyen los Customer con x_bill_status = C (Closed) por falla de API al obtener las subcripciones de customers con dicho bill_status
            $sql = "SELECT DISTINCT CL.x_ICustomer " .
                   "   FROM netuno.af_asepClientes CL, netuno.af_asepCuentas CU " .
                   "  WHERE CL.x_idEjecucion = " . $x .
                   "    AND CL.x_bill_status <> 'C' " . 
                   "    AND CU.x_idEjecucion = CL.x_idEjecucion " .
                   "    AND CU.x_ICustomer   = CL.x_ICustomer   " .
                   "  ORDER BY CL.x_ICustomer ASC ";
            break;
            
        case 'select_ASEPCuentas':
            $sql = "SELECT DISTINCT CU.x_IAccount, CU.x_ICustomer " .
                  "   FROM netuno.af_asepCuentas CU " .
                  "  WHERE CU.x_idEjecucion = " . $x .
                  "  ORDER BY CU.x_IAccount ASC ";
            break;
            
        case 'select_Clientes_Rep_DIDClientes':
            $sql = "SELECT DISTINCT x_IParent, x_ICustomer " .
                   "  FROM netuno.af_didClientes        " .
                   "  WHERE x_idEjecucion = " . $x .
                   "  ORDER BY x_IParent, x_ICustomer ASC ";
            break;

        case 'select_Clientes_RepStCClientes':
            $sql = "SELECT DISTINCT x_IParent, x_ICustomer " .
                   "  FROM netuno.af_stcClientes        " .
                   "  WHERE x_idEjecucion = " . $x .
                   "  ORDER BY x_IParent, x_ICustomer ASC ";
            break;
            
        case 'select_Clientes_RepAsepClientes':
            $sql = "SELECT DISTINCT x_ICustomer " .
                   "  FROM netuno.af_asepClientes " .
                   "  WHERE x_idEjecucion = " . $x .
                   "  ORDER BY x_ICustomer ASC ";
            break;
            
        case 'select_Clientes_RepStCSipClientes':
            $sql = "SELECT DISTINCT x_IParent, x_ICustomer " .
                   "  FROM netuno.af_stcSipClientes     " .
                   "  WHERE x_idEjecucion = " . $x .
                   "  ORDER BY x_IParent, x_ICustomer ASC ";
            break;
            
        case 'select_Cuentas_RepStCCuentas':
            $sql = "SELECT DISTINCT x_IAccount     " .
                   "  FROM netuno.af_stcCuentas " .
                     "  WHERE x_idEjecucion = " . $x .
                   "  ORDER BY x_IAccount ASC ";
            break;
            
        case 'select_Cuentas_RepStCSipCuentas':
            $sql = "SELECT DISTINCT x_IAccount        " .
                   "  FROM netuno.af_stcSipCuentas " .
                   " WHERE x_idEjecucion = " . $x .
                   " ORDER BY x_IAccount ASC ";
            break;
            
        case 'select_Cuentas_RepStCSipCuentas2':
            $sql = "SELECT DISTINCT x_IAccount        " .
                   "  FROM netuno.af_stcSipCuentas " .
                   " WHERE x_idEjecucion = " . $x .
                   "   AND x_IpDevice is not null " .
                   " ORDER BY x_IAccount ASC ";
            break;
            
        case 'select_Dominios':
            $sql = "SELECT DISTINCT rv_domain    " .
                   "  FROM netuno.af_dominios " .
                   " ORDER BY rv_domain ASC ";
            break;
            
        case 'select_valoresDominio':
            $sql = "SELECT DISTINCT rv_low_value " .
                   "  FROM netuno.af_dominios " .
                   " WHERE rv_domain = 'DNIO_OST_RECFACT' ".
                   " ORDER BY rv_low_value ASC ";
            break;
            
        case 'select_FacturaPA':
            // En el calculo del x_Total se suman los x_PagosRecibidos dado que ellos siempre aparecen negativos
            // CustomerClass 44: Corporativo
            // CustomerClass 49: Residencial
            $sql = "SELECT B.x_iCustomer, B.x_Name, B.x_XCustomerClass,                                                     " .
                   "       B.x_CIRifCliente, B.x_NombreSuscriptor, B.x_bill_status, B.x_nroFactura,                         " .
                   "       B.x_FechaEmision, B.x_SaldoAnterior, B.x_PagosRecibidos, B.x_XCargosAdicionales,                 " .
                   "       B.x_XSuscripciones, B.x_XAjustes, B.x_XSubTotal,                                                 " .
                   "       B.x_XTax1ITBMS, B.x_XTax2Soterramiento, B.x_Tax3ASEP911,                                         " .
                   "       (B.x_XSubTotal + B.x_XTax1ITBMS + B.x_XTax2Soterramiento + B.x_Tax3ASEP911) x_TotalMesCorriente, " .
                   "       ((B.x_XSubTotal + B.x_XTax1ITBMS + B.x_XTax2Soterramiento + B.x_Tax3ASEP911) +                   " .
                   "       B.x_SaldoAnterior + B.x_PagosRecibidos) x_Total, B.x_Observaciones, B.x_Credit_Limit             " .
                   "  FROM ( SELECT A.x_iCustomer, A.x_Name, A.x_Observaciones, A.x_Credit_Limit, A.x_XCustomerClass,       " .
                   "                A.x_CIRifCliente, A.x_NombreSuscriptor, A.x_bill_status, A.x_nroFactura,                " .
                   "                A.x_FechaEmision, A.x_SaldoAnterior, A.x_PagosRecibidos, A.x_XCargosAdicionales,        " .
                   "                A.x_XSuscripciones, A.x_XAjustes, A.x_XSubTotal,                                        " .
                   "                ROUND(A.x_XSubTotal*" . TAX_ITBMS . ",3) x_XTax1ITBMS,                                  " .                      
                   "                ROUND(A.x_XSubTotal*" . TAX_SOT   . ",3) x_XTax2Soterramiento,                          " .
                   "                (CASE A.x_CustomerClass                                                                 " .
                   "                      WHEN 44 THEN ROUND(A.x_XSubTotal*" . TAX_ASEP911 . ",3)                           " .
                   "                      WHEN 49 THEN 0                                                                    " .
                   "                  END) x_Tax3ASEP911                                                                    " .
                   "           FROM ( SELECT CL.x_iCustomer, CL.x_Name, CL.x_Observaciones, CL.x_Credit_Limit,              " .
                   "                         IFNULL(CC.x_NbCustomerClass,'UNDEFINED') x_XCustomerClass, CL.x_CustomerClass,      " .
                   "                         CL.x_CIRifCliente, CL.x_NombreSuscriptor, CL.x_bill_status, FA.x_nroFactura,   " .
                   "                         FA.x_FechaEmision, FA.x_SaldoAnterior, FA.x_PagosRecibidos,                    " .
                   "                         (CASE CL.x_CustomerClass                                                       " .
                   "                             WHEN 44 THEN ROUND(FA.x_CargosAdicionales - ROUND(FA.x_CargosAdicionales - ((FA.x_CargosAdicionales*100)/(100+" . PORC_PAN_CORP . ")),3),3)   " . 
                   "                             WHEN 49 THEN ROUND(FA.x_CargosAdicionales - ROUND(FA.x_CargosAdicionales - ((FA.x_CargosAdicionales*100)/(100+" . PORC_PAN_RES . ")),3),3)    " . 
                   "                           END) x_XCargosAdicionales,                                                                                                      " . 
                   "                         (CASE CL.x_CustomerClass                                                                                                       " . 
                   "                             WHEN 44 THEN ROUND(FA.x_Suscripciones - ROUND(FA.x_Suscripciones - ((FA.x_Suscripciones*100)/(100+" . PORC_PAN_CORP . ")),3),3) " . 
                   "                             WHEN 49 THEN ROUND(FA.x_Suscripciones - ROUND(FA.x_Suscripciones - ((FA.x_Suscripciones*100)/(100+" . PORC_PAN_RES . ")),3),3)  " . 
                   "                           END) x_XSuscripciones,                                                                                                          " . 
                   "                         (CASE CL.x_CustomerClass                                                                                                       " . 
                   "                             WHEN 44 THEN ROUND(FA.x_Ajustes - ROUND(FA.x_Ajustes - ((FA.x_Ajustes*100)/(100+" . PORC_PAN_CORP . ")),3),3)              " . 
                   "                             WHEN 49 THEN ROUND(FA.x_Ajustes - ROUND(FA.x_Ajustes - ((FA.x_Ajustes*100)/(100+" . PORC_PAN_RES . ")),3),3)               " . 
                   "                           END) x_XAjustes,                                                                                                                " . 
                   "                         (CASE CL.x_CustomerClass                                                                                                       " . 
                   "                             WHEN 44 THEN ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - (((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes)*100)/(100+" . PORC_PAN_CORP . ")),3),3)  " .
                   "                             WHEN 49 THEN ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - (((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes)*100)/(100+" . PORC_PAN_RES  . ")),3),3)  " .
                   "                           END) x_XSubTotal                              " . 
                   "                    FROM netuno.af_resFactFacturas FA, netuno.af_resFactClientes CL " .
                   "                    LEFT JOIN netuno.af_resFactCustomerClass CC ON (    CC.x_idEjecucion     = CL.x_idEjecucion     " .
                   "                                                                       AND CC.x_ICustomerClass  = CL.x_CustomerClass ) " .
                   "                   WHERE CL.x_idEjecucion     = ". $x . 
                   "                     AND FA.x_idEjecucion     = CL.x_idEjecucion       " . 
                   "                     AND FA.x_iCustomer       = CL.x_iCustomer     ) A " .
                   "       ) B                   " . 
                   " ORDER BY B.x_nroFactura ASC ";
            break;
               
        case 'select_FacturaVE':
            // En el calculo del x_Total se suman los x_PagosRecibidos dado que ellos siempre aparecen negativos
            $sql = "SELECT B.x_iCustomer, B.x_Name, B.x_XCustomerClass,                                                " .
                   "       B.x_CIRifCliente, B.x_NombreSuscriptor, B.x_bill_status, B.x_nroFactura,                    " .
                   "       B.x_FechaEmision, B.x_SaldoAnterior, B.x_PagosRecibidos, B.x_XCargosAdicionales,            " .
                   "       B.x_XSuscripciones, B.x_XAjustes, B.x_XSubTotal, B.x_XTax1IVA,                              " .
                   "       (B.x_XSubTotal + B.x_XTax1IVA) x_TotalMesCorriente,                                         " .
                   "       ((B.x_XSubTotal + x_XTax1IVA) + B.x_SaldoAnterior + B.x_PagosRecibidos) x_Total, B.x_Observaciones, B.x_Credit_Limit " .
                   "  FROM ( SELECT A.x_iCustomer, A.x_Name, A.x_Observaciones, A.x_Credit_Limit, A.x_XCustomerClass,  " .
                   "                  A.x_CIRifCliente, A.x_NombreSuscriptor, A.x_bill_status, A.x_nroFactura,         " .
                   "                A.x_FechaEmision, A.x_SaldoAnterior, A.x_PagosRecibidos, A.x_XCargosAdicionales,   " .
                   "                A.x_XSuscripciones, A.x_XAjustes, A.x_XSubTotal,                                   " .
                   "                  ROUND(A.x_XSubTotal*" . TAX_IVA .",3) x_XTax1IVA                                 " .
                   "           FROM ( SELECT CL.x_iCustomer, CL.x_Name, CL.x_Observaciones, CL.x_Credit_Limit,         " .
                   "                         IFNULL(CC.x_NbCustomerClass,'UNDEFINED') x_XCustomerClass, CL.x_CustomerClass,      " .
                   "                         CL.x_CIRifCliente, CL.x_NombreSuscriptor, CL.x_bill_status, FA.x_nroFactura,   " .
                   "                         FA.x_FechaEmision, FA.x_SaldoAnterior, FA.x_PagosRecibidos,                    " .
                   "                         ROUND(FA.x_CargosAdicionales - ROUND(FA.x_CargosAdicionales - ((FA.x_CargosAdicionales*100)/(100+" . PORC_IVA . ")),3),3)  x_XCargosAdicionales,  " . 
                   "                         ROUND(FA.x_Suscripciones - ROUND(FA.x_Suscripciones - ((FA.x_Suscripciones*100)/(100+" . PORC_IVA . ")),3),3) x_XSuscripciones,                   " . 
                   "                         ROUND(FA.x_Ajustes - ROUND(FA.x_Ajustes - ((FA.x_Ajustes*100)/(100+" . PORC_IVA . ")),3),3) x_XAjustes,                                           " . 
                   "                         ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - (((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes)*100)/(100+" . PORC_IVA . ")),3),3) x_XSubTotal  " . 
                   "                    FROM netuno.af_resFactFacturas FA, netuno.af_resFactClientes CL " .
                   "                    LEFT JOIN netuno.af_resFactCustomerClass CC ON (    CC.x_idEjecucion    = CL.x_idEjecucion     " . 
                   "                                                                       AND CC.x_ICustomerClass = CL.x_CustomerClass ) " . 
                   "                   WHERE CL.x_idEjecucion    = ". $x . 
                   "                     AND FA.x_idEjecucion    = CL.x_idEjecucion              " . 
                   "                     AND FA.x_iCustomer      = CL.x_iCustomer     ) A        " . 
                   "       ) B                   " . 
                   " ORDER BY B.x_nroFactura ASC ";
            break;

        case 'select_FacturaCO':
            // En el calculo del x_Total se suman los x_PagosRecibidos dado que ellos siempre aparecen negativos
            $sql = "SELECT B.x_iCustomer, B.x_Name, B.x_XCustomerClass,                                                " .
                   "       B.x_CIRifCliente, B.x_NombreSuscriptor, B.x_bill_status, B.x_nroFactura,                    " .
                   "       B.x_FechaEmision, B.x_SaldoAnterior, B.x_PagosRecibidos, B.x_XCargosAdicionales,            " .
                   "       B.x_XSuscripciones, B.x_XAjustes, B.x_XSubTotal, B.x_XTax1IVA,                              " .
                   "       (B.x_XSubTotal + B.x_XTax1IVA) x_TotalMesCorriente,                                         " .
                   "       ((B.x_XSubTotal + x_XTax1IVA) + B.x_SaldoAnterior + B.x_PagosRecibidos) x_Total, B.x_Observaciones, B.x_Credit_Limit " .
                   "  FROM ( SELECT A.x_iCustomer, A.x_Name, A.x_Observaciones, A.x_Credit_Limit, A.x_XCustomerClass,       " .
                   "                  A.x_CIRifCliente, A.x_NombreSuscriptor, A.x_bill_status, A.x_nroFactura,              " .
                   "                A.x_FechaEmision, A.x_SaldoAnterior, A.x_PagosRecibidos, A.x_XCargosAdicionales,        " .
                   "                A.x_XSuscripciones, A.x_XAjustes, A.x_XSubTotal,                                        " .
                   "                  ROUND(A.x_XSubTotal*" . TAX_IVA_CO .",3) x_XTax1IVA                                   " .
                   "           FROM ( SELECT CL.x_iCustomer, CL.x_Name, CL.x_Observaciones, CL.x_Credit_Limit,              " .
                   "                         IFNULL(CC.x_NbCustomerClass,'UNDEFINED') x_XCustomerClass, CL.x_CustomerClass,      " .
                   "                         CL.x_CIRifCliente, CL.x_NombreSuscriptor, CL.x_bill_status, FA.x_nroFactura,   " .
                   "                         FA.x_FechaEmision, FA.x_SaldoAnterior, FA.x_PagosRecibidos,                    " .
                   "                         ROUND(FA.x_CargosAdicionales - ROUND(FA.x_CargosAdicionales - ((FA.x_CargosAdicionales*100)/(100+" . PORC_IVA_CO . ")),3),3)  x_XCargosAdicionales,  " . 
                   "                         ROUND(FA.x_Suscripciones - ROUND(FA.x_Suscripciones - ((FA.x_Suscripciones*100)/(100+" . PORC_IVA_CO . ")),3),3) x_XSuscripciones,                   " . 
                   "                         ROUND(FA.x_Ajustes - ROUND(FA.x_Ajustes - ((FA.x_Ajustes*100)/(100+" . PORC_IVA_CO . ")),3),3) x_XAjustes,                                           " . 
                   "                         ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - ROUND((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes) - (((FA.x_CargosAdicionales+FA.x_Suscripciones+FA.x_Ajustes)*100)/(100+" . PORC_IVA_CO . ")),3),3) x_XSubTotal  " . 
                   "                    FROM netuno.af_resFactFacturas FA, netuno.af_resFactClientes CL " .
                   "                    LEFT JOIN netuno.af_resFactCustomerClass CC ON (    CC.x_idEjecucion    = CL.x_idEjecucion    " . 
                   "                                                                       AND CC.x_ICustomerClass = CL.x_CustomerClass )" . 
                   "                   WHERE CL.x_idEjecucion    = ". $x . 
                   "                     AND FA.x_idEjecucion    = CL.x_idEjecucion              " . 
                   "                     AND FA.x_iCustomer      = CL.x_iCustomer     ) A        " . 
                   "       ) B                   " . 
                   " ORDER BY B.x_nroFactura ASC ";
            break;

        case 'select_Factura_Detalle2':
            $sql = "SELECT DISTINCT x_nroFactura " .
                   "  FROM netuno.af_factDetalle " .
                   " WHERE x_idEjecucion = " . $x;
            break;
               
        case 'cant_Encabezado':
            $sql = "SELECT count(*) as CANTIDAD FROM netuno.af_factEncabezado WHERE x_idEjecucion = ". $x;
            break;
               
        case 'select_Encabezado':
            $sql = "SELECT x_idEjecucion, x_iCustomer, x_nroFactura, x_idOperadora, x_nroCuenta, x_usoFuturo, x_dirFacturacion, " .
                   "       x_Urbanizacion, x_Ciudad, x_CodPostal, x_RutaCartero, x_FechaEmision, x_CIRifCliente, x_HoraEmision, " .
                   "       x_SaldoAnterior, x_PagosRecibidos, x_SubTotal, x_PagueAntesDe, x_TotalAPagar18, x_CodEncarte,        " .
                   "       x_CodMsjeSup, x_CodMsjeInf, x_Sacven, x_PorcSacven, x_Avinpro, x_PorcAvinpro, x_Iva, x_PorcIva,      " .
                   "       x_Nodo, x_Moneda, x_GeneraCD, x_NIT, x_SaldoPendiente, x_TotalAPagar33, x_NombreSuscriptor,          " .
                   "       x_CodTaqBanCaribe, x_NroSerieFactura, x_MontoExento, x_SubTotalFactura, x_EmpresaFacturadora,        " .
                   "       x_NroSerieFactAfect, x_CodFactAfect, x_CorreoElectronico, x_NroTelCelular                            " .
                   "  FROM netuno.af_factEncabezado " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY x_nroFactura ASC ";
            break;
               
        case 'select_Detalle_ICustomer':
            $sql = "SELECT DISTINCT x_iCustomer, x_nroFactura, x_idOperadora, x_nroCuenta" .
                   "  FROM netuno.af_factDetalle " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY x_nroFactura ASC ";
            break;
            
        case 'select_TrafClientes_ICustomer':
            $sql = "SELECT DISTINCT x_iCustomer " .
                   "  FROM netuno.af_trafClientes " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY x_iCustomer ASC ";
            break;
            
        case 'select_Clientes_RepFacEncabezado':
            $sql = "SELECT DISTINCT x_iCustomer " .
                   "  FROM netuno.af_factEncabezado " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY x_iCustomer ASC ";
            break;
               
        case 'cant_Detalle':
            $sql = "SELECT count(*) as CANTIDAD FROM netuno.af_factDetalle2 WHERE x_idEjecucion = ". $x;
            break;
               
        case 'select_Detalle':
            $sql = "SELECT x_idEjecucion, x_iCustomer, x_nroFactura, x_Item, x_idOperadora, x_nroCuenta, x_CodOpFechaTlf, " .
                   "       x_Punto, x_DescripcionSrv, x_Monto, x_Moneda, x_TipoDetalle, x_MontoIVA, x_MontoLinea, x_NroSerieFactura " .
                   "  FROM netuno.af_factDetalle2 " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY x_nroFactura, x_Item ASC";
            break;
               
        case 'cant_Mensaje':
            $sql = "SELECT count(*) as CANTIDAD FROM netuno.af_factMensaje WHERE x_idEjecucion = ". $x;
            break;
               
        case 'select_Mensaje':
            $sql = "SELECT x_idEjecucion, x_idOperadora, x_TipoMensaje, x_CodMensaje, x_NroLinea, x_TextoLinea " .
                   "  FROM netuno.af_factMensaje        " .
                   " WHERE x_idEjecucion = ". $x;
            break;
               
        case 'select_Resultado':
            $sql = "SELECT x_idEjecucion, x_Item, x_Linea " .
                   "  FROM netuno.af_factResultado     " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY x_Item ASC ";
            break;
            
        case 'select_repConatel1':
            $sql = "SELECT * " .
                   "  FROM netuno.af_facConatel1 " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY 1, 2 ASC ";
            break;

        case 'select_repConatel4':
            $sql = "SELECT CC.x_NbCustomerClass, TRIM(CL.x_Name) x_Name, TRIM(CL.x_NombreSuscriptor) x_NombreSuscriptor, TRIM(x_IdAccount) x_IdAccount, " .
                   "       IFNULL(IFNULL(VDPCU.x_NbVdPlan, VDPCL.x_NbVdPlan),'DESCONOCIDO') x_vdSuscription " .
                   "  FROM netuno.af_facCustomerClass CC, netuno.af_factClientes CL " .
                   "  LEFT JOIN netuno.af_facVolumeDiscountPlan VDPCL ON (     VDPCL.x_idEjecucion  = CL.x_idEjecucion " .
                   "                                                          AND VDPCL.x_VdPlan       = CL.x_VdPlan ),   " .
                   "       netuno.af_facCuentas CU " .
                   "  LEFT JOIN netuno.af_facVolumeDiscountPlan VDPCU ON (     VDPCU.x_idEjecucion  = CU.x_idEjecucion " .
                   "                                                          AND VDPCU.x_VdPlan       = CU.x_VdPlan )    " .
                   " WHERE CL.x_idEjecucion    = ". $x .
                   "   AND CL.x_idEjecucion    = CU.x_idEjecucion    " .
                   "   AND CL.x_ICustomer      = CU.x_ICustomer      " .
                   "   AND CC.x_idEjecucion    = CL.x_idEjecucion    " .
                   "   AND CC.x_ICustomerClass = CL.x_CustomerClass  " .
                   " ORDER BY CC.x_NbCustomerClass, CL.x_Name, TRIM(x_IdAccount) ASC ";
            break;

        case 'select_repConatel2':
            $sql = "SELECT * " .
                   "  FROM netuno.af_facConatel2 " .
                   " WHERE x_idEjecucion = ". $x .
                   " ORDER BY 1,2 ASC ";
            break;
            
        case 'select_repConatel3':
            $sql = "SELECT x_NbCustomerClass, x_vdSuscription, SUM(d_Cantidad) d_Cantidad" .
                   "  FROM netuno.af_facConatel3 " .
                   " WHERE x_idEjecucion = ". $x .
                   " GROUP BY x_NbCustomerClass, x_vdSuscription " .
                   " ORDER BY 1,2 ASC ";
            break;
            
        case 'select_InvConatel1':
            $sql = " SELECT CC.x_idEjecucion, DE.x_IdDestConatel, CC.x_CustomerClass       " .
                   "   FROM netuno.af_destConatel DE,                                   " .
                   "        (SELECT DISTINCT CL.x_idEjecucion, CL.x_CustomerClass          " .
	                 "   	  FROM netuno.af_factClientes CL, netuno.af_factFacturas FA  " .
	                 "   	 WHERE CL.x_idEjecucion = ". $x .
                   "            AND FA.x_idEjecucion = CL.x_idEjecucion                    " .
	                 "   	   AND FA.x_iCustomer   = CL.x_iCustomer) CC                       " ;
            break;
            
        case 'select_InvConatel2':
            $sql = " SELECT DISTINCT CL.x_idEjecucion, 'LDN' x_TipoTrafico, CL.x_CustomerClass  " .
                   "   FROM netuno.af_factClientes CL, netuno.af_factFacturas FA          " .
                   "  WHERE CL.x_idEjecucion = ". $x .
                   "    AND FA.x_idEjecucion = CL.x_idEjecucion                                 " .
                   "    AND FA.x_iCustomer   = CL.x_iCustomer                                   " .
                   " UNION                                                                      " .
                   " SELECT DISTINCT CL.x_idEjecucion, 'CEL' x_TipoTrafico, CL.x_CustomerClass  " .
                   "   FROM netuno.af_factClientes CL, netuno.af_factFacturas FA          " .
                   "  WHERE CL.x_idEjecucion = ". $x .
                   "    AND FA.x_idEjecucion = CL.x_idEjecucion                                 " .
                   "    AND FA.x_iCustomer   = CL.x_iCustomer                                   " .
                   " UNION                                                                      " .
                   " SELECT DISTINCT CL.x_idEjecucion, 'LDI' x_TipoTrafico, CL.x_CustomerClass  " .
                   "   FROM netuno.af_factClientes CL, netuno.af_factFacturas FA          " .
                   "  WHERE CL.x_idEjecucion = ". $x .
                   "    AND FA.x_idEjecucion = CL.x_idEjecucion                                 " .
                   "    AND FA.x_iCustomer   = CL.x_iCustomer                                   " .
                   "  ORDER BY 1,2,3 ASC ";
            break;
            
        case 'select_InvConatel3':
            $sql = " SELECT DISTINCT CL.x_idEjecucion, CL.x_CustomerClass                       " .
                   "   FROM netuno.af_factClientes CL, netuno.af_factFacturas FA          " .
                   "  WHERE CL.x_idEjecucion = ". $x .
                   "    AND FA.x_idEjecucion = CL.x_idEjecucion                                 " .
                   "    AND FA.x_iCustomer   = CL.x_iCustomer                                   " .
                   "  ORDER BY 1,2 ASC ";
            break;
            
        case 'select_ASEP3':         
          $sql = "SELECT CL.x_NroContrato, CU.x_IAccount, " .
                 "	   (SELECT COUNT(*)    " .
                 "          FROM netuno.af_asepClientes CL2, netuno.af_asepCuentas CU2 " .
                 "         WHERE CL2.x_idEjecucion = ". $x .
                 "           AND CL2.x_NroContrato = CL.x_NroContrato              " .
                 "           AND CL2.x_ICustomer   = CL.x_ICustomer                " .
                 "           AND CU2.x_idEjecucion = CL2.x_idEjecucion             " .
                 "           AND CU2.x_ICustomer   = CL2.x_ICustomer) Cantidad,    " .
                 "       CU.x_IdAccount, CU.x_ActivationDate, CU.x_ICustomer,      " .
                 "       CL.x_Name, CL.x_CompanyName                               " . 
                 "  FROM netuno.af_asepClientes CL, netuno.af_asepCuentas CU " .
                 " WHERE CL.x_idEjecucion = ". $x .
                 "   AND CU.x_idEjecucion = CL.x_idEjecucion                       " .
                 "   AND CU.x_ICustomer   = CL.x_ICustomer                         " .
                 " ORDER BY CL.x_NroContrato, CU.x_ICustomer, CU.x_ActivationDate ASC ";
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

function select_sql2($nombre, $i1, $i2, $i3){
    switch($nombre) {
        case 'select_facUsaSuscripciones':
            $sql = "SELECT 'CLIENTE' tipo, a.x_ICustomer AS ClienteCta, a.x_ISubscription, b.x_NbSubscription, b.x_Rate " . 
                   "  FROM netuno.af_facUsaSuscripClientes a    ".
                   "  LEFT JOIN netuno.af_facUsaSuscripciones b ".
                   "    ON a.x_ISubscription = b.x_ISubscription   ".
                   " WHERE a.x_ICustomer = '" . $i1 . "' AND a.x_idEjecucion = '" . $i2 . "' ".
                   " UNION ".
                   "SELECT 'CUENTA' tipo, a.x_IAccount AS ClienteCta, a.x_ISubscription, b.x_NbSubscription, b.x_Rate " .
                   "  FROM netuno.af_facUsaSuscripCuentas a     ".
                   "  LEFT JOIN netuno.af_facUsaSuscripciones b ".
                   "    ON a.x_ISubscription = b.x_ISubscription   ".
                   " WHERE a.x_ICustomer = '" . $i1 . "' AND a.x_idEjecucion = '" . $i2 . "' ";
            break;

        case 'select_ReporteCobSusc':
            $sql = "select su.x_NbSubscription               " .
                   "  from netuno.af_cobSuscripciones su  " .
                   " where su.x_idEjecucion = " . $i3 . 
                     "   and su.x_IParent   = " . $i2 . 
                   "   and su.x_ICustomer   = " . $i1;
            break;
            
        case 'select_Suscripciones':         
          $sql = " SELECT DISTINCT A.x_NbSubscription FROM ( " .
                 "SELECT x_NbSubscription               " .
                 "  FROM netuno.af_asepSuscripciones " .
                 " WHERE x_idEjecucion = " . $i1 . 
                 "   AND x_ICustomer   = " . $i2 . 
                 " UNION " .
                 "SELECT x_NbSubscription                   " .
                 "  FROM netuno.af_asepSuscripcionesCtas " .
                 " WHERE x_idEjecucion = " . $i1 . 
                 "   AND x_ICustomer   = " . $i2 . 
                 "   AND x_IAccount    = " . $i3 . 
                 " ) A ORDER BY A.x_NbSubscription";
          break;

        case 'select_proceso_usuario':
            $sql = "SELECT c_Usuario FROM netuno.af_procesosxUsuario WHERE x_idProceso = '" .$i1. "' ".
                   "AND c_Usuario = '" .$i2. "' ";
            break;

        case 'select_reporte_usuario':
            $sql = "SELECT c_Usuario FROM netuno.af_reportesxUsuario WHERE x_idReporte = '" .$i1. "' ".
                   "AND c_Usuario = '" .$i2. "' ";
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

function select_sql_bitacora($nombre, $ArrParams){
    $sql = "SELECT b.x_idEjecucion, b.x_FechaInicio, b.x_FechaFin, b.c_Usuario, e.x_idReporte, r.x_nbReporte, " .
           "       (CASE b.x_StBitacora " .
           "             WHEN '0' THEN 'En Ejecucion' " .
           "             WHEN '1' THEN 'OK' " .
           "             WHEN '2' THEN 'Error' " .
           "        END) x_StBitacora " .
           "  FROM netuno.af_bitacora b, netuno.af_IdEjecucion e, netuno.af_reportes r " .
           " WHERE b.x_idEjecucion = e.x_idEjecucion " .
           "   AND e.x_idReporte = r.x_idReporte " .
           "   AND STR_TO_DATE(b.x_FechaInicio,'%d-%m-%Y') BETWEEN " .
           "       STR_TO_DATE('".$ArrParams['fechaInicio']."', '%d-%m-%Y') " .
           "   AND STR_TO_DATE('".$ArrParams['fechaFin']."', '%d-%m-%Y') ";

    if ($ArrParams['usuario'] != "") {
        $sql .= "AND b.c_Usuario = '".$ArrParams['usuario']."'";
    }

    if ($ArrParams['estatus'] != "none") {
        $sql .= "AND b.x_StBitacora = '".$ArrParams['estatus']."'";
    }
    
    if ((int)$ArrParams['idEjec']) {
        $id = (int)$ArrParams['idEjec'];
        $sql .= "AND CAST(b.x_idEjecucion AS UNSIGNED INTEGER) = '".$id."'";
    }
                        
    if ($ArrParams['tipoReporte'] != "Todos") {
        $sql .= "AND e.x_idReporte = '".$ArrParams['tipoReporte']."'";
    }
	
	$sql .= "UNION " .
           "SELECT b.x_idEjecucion, b.x_FechaInicio, b.x_FechaFin, b.c_Usuario, e.x_idReporte, p.x_nbProceso x_nbReporte, " .
           "       (CASE b.x_StBitacora " .
           "             WHEN '0' THEN 'En Ejecucion' " .
           "             WHEN '1' THEN 'OK' " .
           "             WHEN '2' THEN 'Error' " .
           "        END) x_StBitacora " .
           "  FROM netuno.af_bitacora b, netuno.af_IdEjecucion e, netuno.af_procesos p " .
           " WHERE b.x_idEjecucion = e.x_idEjecucion " .
           "   AND e.x_idReporte = p.x_idProceso " .
           "   AND STR_TO_DATE(b.x_FechaInicio,'%d-%m-%Y') BETWEEN " .
           "       STR_TO_DATE('".$ArrParams['fechaInicio']."', '%d-%m-%Y') " .
           "   AND STR_TO_DATE('".$ArrParams['fechaFin']."', '%d-%m-%Y') ";

    if ($ArrParams['usuario'] != "") {
        $sql .= "AND b.c_Usuario = '".$ArrParams['usuario']."'";
    }

    if ($ArrParams['estatus'] != "none") {
        $sql .= "AND b.x_StBitacora = '".$ArrParams['estatus']."'";
    }
    
    if ((int)$ArrParams['idEjec']) {
        $id = (int)$ArrParams['idEjec'];
        $sql .= "AND CAST(b.x_idEjecucion AS UNSIGNED INTEGER) = '".$id."'";
    }
                        
    if ($ArrParams['tipoReporte'] != "Todos") {
        $sql .= "AND e.x_idReporte = '".$ArrParams['tipoReporte']."'";
    }
                    
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_usuarios($nombre, $ArrParams){
    $sql = "SELECT c_Usuario, x_Obs, (CASE i_Activo " .
           "                               WHEN '0' THEN 'No' " .
           "                               WHEN '1' THEN 'Si' " .
           "                          END) i_Activo, " .
		       "                         (CASE i_Admin " .
           "                               WHEN '0' THEN 'No' " .
           "                               WHEN '1' THEN 'Si' " .
           "                          END) i_Admin,  " .
		       "                         (CASE i_Config  " .
           "                               WHEN '0' THEN 'No' " .
           "                               WHEN '1' THEN 'Si' " .
           "                          END) i_Config " .
           " FROM netuno.af_usuarios ";
                    
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_resellers($nombre, $ArrParams){
    $sql = "SELECT x_IReseller, x_NbReseller,  " .
           "       (CASE x_idPortaOne          " .
           "             WHEN '1' THEN 'CR' " .
           "             WHEN '2' THEN 'PA' " .
           "       END) x_idPortaOne    " .
           " FROM netuno.af_reseller ";
                    
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_procesosxusuario($nombre, $ArrParams){
    $sql = "SELECT ru.x_idProceso, r.x_nbProceso  " .
           "  FROM netuno.af_procesosxUsuario ru, netuno.af_procesos r " .
		       " WHERE r.x_nbProceso != 'Proceso de Cobro de Suscripciones USA Prepago' " . 
           "   AND ru.x_idProceso = r.x_idProceso " .
           "   AND ru.c_Usuario = '".$ArrParams['usuario']."'";
               
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_resellersxusuario($nombre, $ArrParams){
    $sql = "SELECT ru.x_IReseller, " .
           "       (CASE r.x_idPortaOne               " .
           "             WHEN '1' THEN CONCAT(r.x_NbReseller, ' (CR)') " .
           "             WHEN '2' THEN CONCAT(r.x_NbReseller, ' (PA)') " .
           "       END) x_NbReseller    " .
           "  FROM netuno.af_resellersxusuario ru, netuno.af_reseller r " .
		       " WHERE ru.x_IReseller = r.x_IReseller " .
           "   AND ru.c_Usuario = '".$ArrParams['usuario']."'";
               
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_reportesxusuario($nombre, $ArrParams){
    $sql = "SELECT ru.x_idReporte, r.x_nbReporte  " .
           "  FROM netuno.af_reportesxUsuario ru, netuno.af_reportes r " .
		       " WHERE ru.x_idReporte = r.x_idReporte " .
           "   AND ru.c_Usuario = '".$ArrParams['usuario']."'";
               
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_destinosConatel($nombre, $ArrParams){
    $sql = "SELECT x_IdDestConatel, x_DestConatel " .
           " FROM netuno.af_destConatel ";
                    
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_paisesPorta($nombre, $ArrParams){
    $sql = "SELECT x_IdCountryPorta, x_NbCountryPorta " .
           " FROM netuno.af_countryPorta ";
                    
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_destinoxPaisPorta($nombre, $ArrParams){
    $sql = "SELECT r.x_IdCountryDestPorta, r.x_NbCountryDestPorta " .
           "  FROM netuno.af_countryDestPorta r " .
		       " WHERE r.x_IdCountryPorta = '".$ArrParams['x_IdCountryPorta']."'";
               
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_dominios($nombre, $ArrParams){
    $sql = "SELECT r.rv_low_value, r.rv_meaning " .
           "  FROM netuno.af_dominios r " .
		       " WHERE r.rv_domain = '".$ArrParams['rv_domain']."'";
               
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_destConatelPorta($nombre, $ArrParams){
    $sql = "SELECT r.x_IdDestConatel, r.x_IdCountryPorta, r.x_IdCountryDestPorta, c.x_NbCountryPorta, d.x_NbCountryDestPorta " .
           "  FROM netuno.af_destConatelPorta r, netuno.af_countryPorta c, netuno.af_countryDestPorta d " .
		       " WHERE r.x_IdDestConatel  = '".$ArrParams['x_IdDestConatel']."'" . 
		       "   AND r.x_IdCountryPorta     = c.x_IdCountryPorta     " .
		       "   AND d.x_IdCountryDestPorta = r.x_IdCountryDestPorta " .
           "   AND d.x_IdCountryPorta     = r.x_IdCountryPorta ";
               
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_destExcConatelPorta($nombre, $ArrParams){
    $sql = "SELECT r.x_IdDestConatel, r.x_ExcIdCountryPorta x_IdCountryPorta, r.x_ExcIdContryDescPorta x_IdCountryDestPorta, " .
           "       c.x_NbCountryPorta, d.x_NbCountryDestPorta " .
           "  FROM netuno.af_excDestConatelPorta r, netuno.af_countryPorta c, netuno.af_countryDestPorta d " .
		       " WHERE r.x_IdDestConatel  = '".$ArrParams['x_IdDestConatel']."'" . 
		       "   AND r.x_ExcIdCountryPorta  = c.x_IdCountryPorta     " .
		       "   AND d.x_IdCountryDestPorta = r.x_ExcIdContryDescPorta " .
           "   AND d.x_IdCountryPorta     = r.x_ExcIdCountryPorta ";
               
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_suscripUsaPrepago($nombre, $ArrParams){
    $sql = "SELECT x_ISubscription, x_NbSubscription, x_Rate " .
           "  FROM netuno.af_facUsaSuscripciones " .
           " WHERE x_idPortaOne = '".$ArrParams['x_idPortaOne']."'";
                    
    if ($nombre == "registros_x_paginas") {
        $sql .= "ORDER BY ".$ArrParams['sidx']." ".$ArrParams['sord']." LIMIT ".$ArrParams['start']." , ".$ArrParams['limit'];
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

function select_sql_transaccionesUsaPrepago($PERIODO, $ID_PORTAONE){
    $sql = "SELECT a.x_ICustomer, c.x_Name, a.x_ActiveSubscriptions, a.x_TotalSubscriptions,                " .
           "       a.x_Status, a.x_Date, a.x_ITransaction, a.x_Authorization, a.x_ResultCode, a.x_Attempts  " .
           "  FROM netuno.af_facUsaTransacciones a, netuno.af_facUsaPeriodo b, netuno.af_facUsaClientes c " .
           " WHERE b.x_MesAnio     = '" . $PERIODO     . "' " .
           "   AND b.x_idPortaOne  = '" . $ID_PORTAONE . "' " .
           "   AND a.x_idEjecucion = b.x_idEjecucion " .
           "   AND a.x_ICustomer   = c.x_ICustomer   " .
           "   AND c.x_idEjecucion = b.x_idEjecucion " .
           " UNION " .
           "SELECT DISTINCT A.x_ICustomer, A.x_Name, '<NO POSEE SUSCRIPCIONES>' as x_ActiveSubscriptions, 0 as x_TotalSubscriptions, " .
           "       'ERROR7' as x_Status, BT.x_FechaFin AS x_Date, '' as x_ITransaction, '' as x_Authorization, " .
           "       '' as x_ResultCode, A.x_Intentos as x_Attempts  " .
           "  FROM (SELECT DISTINCT CL.x_ICustomer, CL.x_Name, PE.x_Intentos, PE.x_idEjecucion, " .
           "               (SELECT COUNT(*) " .
           "                  FROM netuno.af_facUsaSuscripClientes SCL " .
           "                 WHERE SCL.x_iCustomer   = CL.x_iCustomer " .
           "                   AND SCL.x_idEjecucion = CL.x_idEjecucion) SuscripcionesClientes, " .
           "               CU.X_IAccount, " .
           "               (SELECT COUNT(*) " .
           "                  FROM netuno.af_facUsaSuscripCuentas SCU " .
           "                 WHERE SCU.X_IAccount    = CU.X_IAccount " .
           "                   AND SCU.x_idEjecucion = CU.x_idEjecucion) SuscripcionesCuentas " .
           "          FROM netuno.af_facUsaPeriodo PE, netuno.af_facUsaClientes CL " .
           "          LEFT JOIN netuno.af_facUsaCuentas CU ON (    CU.x_iCustomer   = CL.x_iCustomer " .
           "											                                AND CU.x_idEjecucion = CL.x_idEjecucion) " .
           "         WHERE PE.x_MesAnio     = '" . $PERIODO     . "' " .
           "           AND PE.x_idPortaOne  = '" . $ID_PORTAONE . "' " .
           "           AND PE.x_idEjecucion = CL.x_idEjecucion " .
           "       ) A, netuno.af_bitacora BT " .
           " WHERE A.x_idEjecucion = BT.x_idEjecucion " .
           "   AND SuscripcionesClientes=0 and SuscripcionesCuentas=0 " .
           "   AND A.x_ICustomer NOT IN (SELECT TR.x_ICustomer FROM netuno.af_facUsaTransacciones TR " .
           "                              WHERE TR.x_idEjecucion = A.x_idEjecucion) " .
           " ORDER BY 1 ASC";
    
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