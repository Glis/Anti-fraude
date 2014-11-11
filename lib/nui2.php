<?php

set_time_limit(0);

class nui {
  var $wsdl_url_session;      //WS de sesion
  var $wsdl_url_customer;     //WS de cliente
  var $wsdl_url_account;      //WS de cuenta
  var $wsdl_url_product;      //WS de productos
  var $wsdl_url_DID;          //WS de productos
  var $auth_info;             // informacion de autenticacion de usuario en porta
  var $logged;                // Si se logeo o no
  var $logged_type;           // USER o CLIENT
  var $customer_info;         // Arreglo con informacion del cliente seleccionado
  var $customer_check;        // Arreglo con informacion del cliente seleccionado
  var $user = "";             // Usuario que se logea
  var $pass = "";             // Password Usuario que se logea

  var $xdr_list;              // Arreglo de XDRs
  var $cdrs_list_info;
  var $customer_client_info;
  var $add_update_customer;
  var $add_update_account;
     
  function nui($login, $pass, $wsdl_url) {
        $this->user = $login;
        $this->pass = $pass;

        try {
            $result = $this->acceder_porta($wsdl_url);

            if ($result) {//login correcto de un USER
                $this->logged = true;
                $this->logged_type = 'USER';
                
            } else {//verificar si el login lo hizo un cliente
                $this->user = $login;
                $this->pass = $pass;
                
                $result_client = $this->acceder_porta($wsdl_url);

                if ($result_client) {//validar cliente que se logea                  
                    $client = $this->check_customer_login(null, $user, $pass);
                    
                    if ($client) {//login correcto de cliente
                        $this->logged = true;
                        $this->logged_type = 'CLIENT';
                    
                    } else {//Cliente errado, user errado
                        $this->logged = false;
                        $this->logged_type = 'NONE1';
                    }
                } else {//Problemas con usuario 
                    $this->logged = false;
                    $this->logged_type = 'NONE2';
                }
            }
        } catch (SoapFault $exception) { }
    }

  /* Metodo para hacer login en PORTA a traves de los WS */
  function acceder_porta($wsdl_url) {
        $this->wsdl_url_session       = $wsdl_url . "SessionAdminService.wsdl";
        $this->wsdl_url_customer      = $wsdl_url . "CustomerAdminService.wsdl";
        $this->wsdl_url_account       = $wsdl_url . "AccountAdminService.wsdl";
        $this->wsdl_url_product       = $wsdl_url . "ProductAdminService.wsdl";
        $this->wsdl_url_DID           = $wsdl_url . "DIDAdminService.wsdl";
        $this->wsdl_url_UA            = $wsdl_url . "UAAdminService.wsdl";
        $this->wsdl_url_invoice       = $wsdl_url . "InvoiceAdminService.wsdl";
        $this->wsdl_url_customerclass = $wsdl_url . "CustomerClassAdminService.wsdl";
        $this->wsdl_url_service       = $wsdl_url . "ServiceAdminService.wsdl"; 
        $this->wsdl_url_discountplan  = $wsdl_url . "DiscountPlanAdminService.wsdl"; 
        $this->wsdl_url_discountplan  = $wsdl_url . "DiscountPlanAdminService.wsdl"; 
        
        try {
            $session_client = new SoapClient($this->wsdl_url_session);
            $session_id = $session_client->login($this->user, $this->pass);
            $this->auth_info = new SoapHeader(
                            "http://schemas.portaone.com/soap",
                            "auth_info",
                            new SoapVar(
                                    array('session_id' => $session_id),
                                    SOAP_ENC_OBJECT
                            )
            );
        } catch (SoapFault $exception) { }
        
        if ($this->auth_info) {
            return $resp = true;
        } else {
            return $resp = false;
        }
  }
 
  /*Metodo para realizar la validacion del cliente*/
  function check_customer_login($i_customer,$login,$pass){
        try {
             $customer_client_info  = new SoapClient($this->wsdl_url_customer);
             $customer_client_info->__setSoapHeaders($this->auth_info);

             if($i_customer){
                $GetCustomerInfoRequest_info = array('i_customer' => $i_customer);

            }elseif($login){
                $GetCustomerInfoRequest_info = array('login' => $login);
            }
            
            if($GetCustomerInfoRequest_info){
            
             $customer_response = $customer_client_info->get_customer_info($GetCustomerInfoRequest_info);
             
             if($customer_response){
                $this->customer_check = $customer_response->customer_info;
                if($this->customer_check->password == $pass){
                    return $resp = true;
                }else{
                    return $resp = false;
                }
             }else{
                return $resp = false;
             }
            }else{
                return $resp = false;
            }
      } catch (SoapFault $exception) { } 
    }

  /* Metodo para realizar la busqueda del cliente */
  function get_customer_info3($i_customer, $iteracion) {
        try {
            if ($iteracion==1) {
              $customer_client_info = new SoapClient($this->wsdl_url_customer);
              $customer_client_info->__setSoapHeaders($this->auth_info);
              $this->customer_client_info = $customer_client_info;
            }

            if ($i_customer) {
                $GetCustomerInfoRequest_info = array('i_customer' => $i_customer);
            } elseif ($login) {
                $GetCustomerInfoRequest_info = array('login' => $login);
            }

            if ($GetCustomerInfoRequest_info) {
                if ($iteracion==1) { 
                  $customer_response = $customer_client_info->get_customer_info($GetCustomerInfoRequest_info);
                } else {
                  $customer_response = $this->customer_client_info->get_customer_info($GetCustomerInfoRequest_info);
                }

                if ($customer_response->customer_info) {
                    $this->customer_info = $customer_response->customer_info;
                    return $resp = true;
                } else {
                	  $this->customer_info = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
    }
    
  /* Metodo para realizar la busqueda de los XDRs de CUSTOMERs pertenecientes a un rango de fechas en particular */
  function get_cdrs_retail_customer($icustomer, $from_date, $to_date, $iteracion, $cantidad) {
        try {            
            if ($iteracion==1) {
              $cdrs_list_info = new SoapClient($this->wsdl_url_customer);
              $cdrs_list_info->__setSoapHeaders($this->auth_info);
              $this->cdrs_list_info = $cdrs_list_info;
            }
            
            // Se extraen como maximo los primeros 3000 CDRS por factura (para un cliente y un rango de fechas), 
            // dado que al intentar sacar mas se obtiene error del SOAP
            $GetCustomerXDRsRequest_info = array('offset'     => ($cantidad==0 ? 0 : (3000*$cantidad)), 
                                                 'limit'      => 3000, 
                                                 'from_date'  => $from_date . ' 00:00:00', 'to_date' => $to_date . ' 23:59:59',
                                                 'i_customer' => $icustomer);
                        
            if ($GetCustomerXDRsRequest_info) {
                
                if ($iteracion==1) {
                  $cdrs_list_response = $cdrs_list_info->get_customer_xdrs($GetCustomerXDRsRequest_info);
                } else {
                    $cdrs_list_response = $this->cdrs_list_info->get_customer_xdrs($GetCustomerXDRsRequest_info);
                }

                if($cdrs_list_response){
                  $this->xdr_list = $cdrs_list_response->xdr_list;
                  return $resp = true;        
                }else{
                	$this->xdr_list = "";
                  return $resp = false;
                }
            }else{
              return $resp = false;
            }
        } catch (SoapFault $exception) { } 
    }    

  /* Metodo para actualizar info del cliente (usado para habilitar/deshabilitar el cliente -> campo blocked) */
  function update_customer($i_customer, $blocked, $iteracion) {
     try {
     	       if ($iteracion==1) {
               $add_update_customer = new SoapClient($this->wsdl_url_customer);
               $add_update_customer->__setSoapHeaders($this->auth_info);
               $this->add_update_customer = $add_update_customer;
             }
             
             $customerInfo = array('i_customer' => $i_customer,
                                   'blocked'    => $blocked);
                                                                   
             if ($customerInfo) {
             	   if ($iteracion==1) { 
                   $UpdateCustomer_response = $add_update_customer->update_customer(array('customer_info' => $customerInfo));
                 } else {
                   $UpdateCustomer_response = $this->add_update_customer->update_customer(array('customer_info' => $customerInfo));
                 }

                 if ($UpdateCustomer_response) {
                     $this->i_customer = $UpdateCustomer_response->i_customer;
                     return $resp = true;
                 } else {
                     $this->i_customer = "";
                     return $resp = false;
                 }
             } else {
                 return $resp = false;
             }
     } catch (SoapFault $exception) { }
  }
   
  /* Metodo para actualizar info de la cuenta (usado para habilitar/deshabilitar la cuenta -> campo blocked) */
  function update_account($i_account, $blocked, $iteracion) {
     try {
     	       if ($iteracion==1) {
               $add_update_account = new SoapClient($this->wsdl_url_account);
               $add_update_account->__setSoapHeaders($this->auth_info);
               $this->add_update_account = $add_update_account;
             }
             
             $accountInfo = array('i_account'   => $i_account,
                                   'blocked'    => $blocked);
                                                                   
             if ($accountInfo) {
             	   if ($iteracion==1) { 
                   $UpdateAccount_response = $add_update_account->update_account(array('account_info' => $accountInfo));
                 } else {
                   $UpdateAccount_response = $this->add_update_account->update_account(array('account_info' => $accountInfo));
                 }

                 if ($UpdateAccount_response) {
                     $this->i_account = $UpdateAccount_response->i_account;
                     return $resp = true;
                 } else {
                     $this->i_account = "";
                     return $resp = false;
                 }
             } else {
                 return $resp = false;
             }
     } catch (SoapFault $exception) { }
  }

}

?>