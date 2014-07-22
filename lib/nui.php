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

  var $customer_list;         // Arreglo de clientes
  var $customer_class_list;   // Arreglo de customer class
  var $subscriptions;         // Arreglo de suscripciones
  var $account_subscriptions; // Arreglo de suscripciones de cuentas
  var $account_list;          // Arreglo de cuentas
  var $product_list;          // Arreglo de productos
  var $discount_plan_list;    // Arreglo de discount plan
  
  var $invoice_list_info;
  var $invoice_info;     
  var $invoice_list;          // Arreglo de facturas
  var $xdr_list;              // Arreglo de XDRs
  
  var $customerclass_list;
  var $customerclass_listA;
    
  var $cdrs_list_info;
  var $get_numberL_list;
  var $get_vendor_batchL_list;
  var $account_followme_info;
  var $status_history_info;
  
  var $customer_client_info;
  var $customer_list_info;
  var $customerAccount_list_info;
  var $custSuscription_list_info;
  var $get_periodical_payment_list;
  var $custom_fields_schema_info;
  var $upd_periodical_payment;
  var $add_update_customer;
  var $add_make_transaction;
  
  var $account_value;
  var $accountState_info;
  var $accountSuscription_list_info;
  
  var $service_list;
  var $custom_fields;
  
  var $sip_status;
  var $sip_contact;
  var $accountSipState_info;
  
  var $ua_info;
  var $GetUA_info;
  
  var $payment_method_info;
  
  var $MTbalance;
  var $MTtransaction_id;
  var $MTauthorization;
  var $MTresult_code;
  var $MTi_xdr;
  
  var $number_list;
  var $followme_numbers;
  var $vendor_batch_list;
  var $i_periodical_payment;
  var $periodical_payment_list;
  var $status_history_changes;
    
  function nui($login, $pass, $portaone) {
        $this->user = $login;
        $this->pass = $pass;

        try {
            $result = $this->acceder_porta($portaone);

            if ($result) {//login correcto de un USER
                $this->logged = true;
                $this->logged_type = 'USER';
                
            } else {//verificar si el login lo hizo un cliente
                $this->user = $login;
                $this->pass = $pass;
                
                $result_client = $this->acceder_porta($portaone);

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
  function acceder_porta($portaone) {
        if ($portaone==1) {
          $this->wsdl_url_session = "https://clientes.rhitcr.com/wsdl/SessionAdminService.wsdl";
          $this->wsdl_url_customer = "https://clientes.rhitcr.com/wsdl/CustomerAdminService.wsdl";
          $this->wsdl_url_account = "https://clientes.rhitcr.com/wsdl/AccountAdminService.wsdl";
          $this->wsdl_url_product = "https://clientes.rhitcr.com/wsdl/ProductAdminService.wsdl";
          $this->wsdl_url_DID = "https://clientes.rhitcr.com/wsdl/DIDAdminService.wsdl";
          $this->wsdl_url_UA = "https://clientes.rhitcr.com/wsdl/UAAdminService.wsdl";
          $this->wsdl_url_invoice = "https://clientes.rhitcr.com/wsdl/InvoiceAdminService.wsdl";
          $this->wsdl_url_customerclass = "https://clientes.rhitcr.com/wsdl/CustomerClassAdminService.wsdl";
          $this->wsdl_url_service = "https://clientes.rhitcr.com/wsdl/ServiceAdminService.wsdl"; 
          $this->wsdl_url_discountplan = "https://clientes.rhitcr.com/wsdl/DiscountPlanAdminService.wsdl"; 
          $this->wsdl_url_discountplan = "https://clientes.rhitcr.com/wsdl/DiscountPlanAdminService.wsdl"; 
        } else {
          $this->wsdl_url_session = "https://clientes1.net-uno.net/wsdl/SessionAdminService.wsdl";
          $this->wsdl_url_customer = "https://clientes1.net-uno.net/wsdl/CustomerAdminService.wsdl";
          $this->wsdl_url_account = "https://clientes1.net-uno.net/wsdl/AccountAdminService.wsdl";
          $this->wsdl_url_product = "https://clientes1.net-uno.net/wsdl/ProductAdminService.wsdl";
          $this->wsdl_url_DID = "https://clientes1.net-uno.net/wsdl/DIDAdminService.wsdl";
          $this->wsdl_url_UA = "https://clientes1.net-uno.net/wsdl/UAAdminService.wsdl";
          $this->wsdl_url_invoice = "https://clientes1.net-uno.net/wsdl/InvoiceAdminService.wsdl";
          $this->wsdl_url_customerclass = "https://clientes1.net-uno.net/wsdl/CustomerClassAdminService.wsdl";
          $this->wsdl_url_service = "https://clientes1.net-uno.net/wsdl/ServiceAdminService.wsdl"; 
          $this->wsdl_url_discountplan = "https://clientes1.net-uno.net/wsdl/DiscountPlanAdminService.wsdl"; 
          $this->wsdl_url_discountplan = "https://clientes1.net-uno.net/wsdl/DiscountPlanAdminService.wsdl"; 
        }
        
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
  function get_customer_info($i_customer, $login) {
        try {

            $customer_client_info = new SoapClient($this->wsdl_url_customer);
            $customer_client_info->__setSoapHeaders($this->auth_info);

            if ($i_customer) {
                $GetCustomerInfoRequest_info = array('i_customer' => $i_customer);
            } elseif ($login) {
                $GetCustomerInfoRequest_info = array('login' => $login);
            }

            if ($GetCustomerInfoRequest_info) {

                $customer_response = $customer_client_info->get_customer_info($GetCustomerInfoRequest_info);

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

  /* Metodo para realizar la busqueda del cliente */
  function get_customer_info2($name) {
        try {
            $customer_client_info = new SoapClient($this->wsdl_url_customer);
            $customer_client_info->__setSoapHeaders($this->auth_info);
            
            $GetCustomerInfoRequest_info = array('name' => $name);
            
            if ($GetCustomerInfoRequest_info) {
                $customer_response = $customer_client_info->get_customer_info($GetCustomerInfoRequest_info);
                
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

  /* Metodo para realizar la busqueda de los clientes pertenecientes a un RESELLER*/
  function get_customer_list($i_parent) {
        try {
            $customer_list_info = new SoapClient($this->wsdl_url_customer);
            $customer_list_info->__setSoapHeaders($this->auth_info);
            
            $this->customer_list_info = $customer_list_info;
            
            $GetCustomerListRequest_info = array('offset' => 0, 'limit' => 0, 'i_parent' => $i_parent);
                        
            if ($GetCustomerListRequest_info) {
                $customer_list_response = $customer_list_info->get_customer_list($GetCustomerListRequest_info);
                
                if($customer_list_response){
                  $this->customer_list = $customer_list_response->customer_list;
                  return $resp = true;        
                }else{
                	$this->customer_list = "";
                  return $resp = false;
                }
                
            }else{
              return $resp = false;
            }
        } catch (SoapFault $exception) { } 
    }
    
  /* Metodo para realizar la busqueda de los Customer Class pertenecientes a un RESELLER*/
  function get_customer_class_list($i_parent) {
        try {
            $customerclass_list_info = new SoapClient($this->wsdl_url_customerclass);
            $customerclass_list_info->__setSoapHeaders($this->auth_info);
            
            $GetCustomerClassListRequest_info = array('i_customer' => $i_parent);
                        
            if ($GetCustomerClassListRequest_info) {
                $customerclass_list_response = $customerclass_list_info->get_customer_class_list($GetCustomerClassListRequest_info);
                
                if($customerclass_list_response){
                  $this->customerclass_list = $customerclass_list_response->customer_class_list;
                  return $resp = true;        
                }else{
                	$this->customerclass_list = "";
                  return $resp = false;
                }
                
            }else{
              return $resp = false;
            }
        } catch (SoapFault $exception) { } 
    }
    
  /* Metodo para realizar la busqueda de las suscripciones de un cliente */
  function get_subscriptions($i_customer, $iteracion) {
        try {
            if ($iteracion==1) {
              $custSuscription_list_info = new SoapClient($this->wsdl_url_customer);
              $custSuscription_list_info->__setSoapHeaders($this->auth_info);
              $this->custSuscription_list_info = $custSuscription_list_info;
            }
            
            $GetCustomerSubscriptionRequest_info = array('i_customer' => $i_customer);
            
            if ($GetCustomerSubscriptionRequest_info) { 
               if ($iteracion==1) {
               	 $customer_suscription_response = $custSuscription_list_info->get_subscriptions($GetCustomerSubscriptionRequest_info);
               } else {
            	   $customer_suscription_response = $this->custSuscription_list_info->get_subscriptions($GetCustomerSubscriptionRequest_info);
               }
                                
               if ($customer_suscription_response->subscriptions) {
                    $this->subscriptions = $customer_suscription_response->subscriptions;
                    return $resp = true;
                } else {
                	  $this->subscriptions = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
  }
  
  /* Metodo para realizar la busqueda de las cuentas de un cliente */
  function get_accounts($i_customer, $iteracion) {
        try {
            if ($iteracion==1) {
              $customerAccount_list_info = new SoapClient($this->wsdl_url_account);
              $customerAccount_list_info->__setSoapHeaders($this->auth_info);
              $this->customerAccount_list_info = $customerAccount_list_info;
            }
            
           $GetCustomerAccountListRequest_info = array('offset' => 0, 'limit' => 0, 'i_customer' => $i_customer, 'i_batch' => 0);
                        
            if ($GetCustomerAccountListRequest_info) {
                if ($iteracion==1) {
                  $customerAccount_list_response = $customerAccount_list_info->get_account_list($GetCustomerAccountListRequest_info);
                } else {
                    $customerAccount_list_response = $this->customerAccount_list_info->get_account_list($GetCustomerAccountListRequest_info);
                }
                
                if($customerAccount_list_response){
                  $this->account_list = $customerAccount_list_response->account_list;
                  return $resp = true;        
                }else{
                	$this->account_list = "";
                  return $resp = false;
                }
                
                }else{
                  return $resp = false;
                }
        } catch (SoapFault $exception) { } 
    }
    
  /* Metodo para realizar la busqueda de las suscripciones de una cuenta */
  function get_account_subscriptions($i_account, $iteracion) {
        try {
            if ($iteracion==1) {
              $accountSuscription_list_info = new SoapClient($this->wsdl_url_account);
              $accountSuscription_list_info->__setSoapHeaders($this->auth_info);
              $this->accountSuscription_list_info = $accountSuscription_list_info;
            }
            
            $GetAccountSubscriptionRequest_info = array('i_account' => $i_account);
            
            if ($GetAccountSubscriptionRequest_info) {                
               if ($iteracion==1) {
               	 $account_suscription_response = $accountSuscription_list_info->get_subscriptions($GetAccountSubscriptionRequest_info);
               } else {
            	   $account_suscription_response = $this->accountSuscription_list_info->get_subscriptions($GetAccountSubscriptionRequest_info);
               }

               if ($account_suscription_response->subscriptions) {
                    $this->account_subscriptions = $account_suscription_response->subscriptions;
                    return $resp = true;
                } else {
                	  $this->account_subscriptions = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
  }

  /* Metodo para realizar la busqueda del status de una cuenta */
  function get_account_state($i_account, $iteracion) {
        try {
            if ($iteracion==1) {
              $accountState_info = new SoapClient($this->wsdl_url_account);
              $accountState_info->__setSoapHeaders($this->auth_info);
              $this->accountState_info = $accountState_info;
            }
                       
            /* Por defecto se coloca el i_acc_state_type en 1, no acepta el valor 0 */
            $acc_state_type=1;
            
            $GetAccountStateRequest_info = array('i_account' => $i_account, 'i_acc_state_type' => $acc_state_type);
                        
            if ($GetAccountStateRequest_info) {
                if ($iteracion==1) {
                  $AccountState_response = $accountState_info->get_account_state($GetAccountStateRequest_info);
                } else {
                    $AccountState_response = $this->accountState_info->get_account_state($GetAccountStateRequest_info);
                }
                
                if($AccountState_response){
                  //$this->account_value = $AccountState_response->value;
                  $this->account_value = (isset($AccountState_response->value) ? $AccountState_response->value : 0);
                  return $resp = true;
                } else{
                	$this->account_value = "";
                  return $resp = false;
                }
                
            } else{
              return $resp = false;
            }
        } catch (SoapFault $exception) { } 
    }
    
  /* Metodo para realizar la busqueda del status SIP de una cuenta */
  function get_sip_status ($i_account, $iteracion) {
        try {
            if ($iteracion==1) {
              $accountSipState_info = new SoapClient($this->wsdl_url_account);
              $accountSipState_info->__setSoapHeaders($this->auth_info);
              $this->accountSipState_info = $accountSipState_info;
            }
                                   
            $GetAccountSipStateRequest_info = array('i_account' => $i_account);
                        
            if ($GetAccountSipStateRequest_info) {
                if ($iteracion==1) {
                  $AccountSipState_response = $accountSipState_info->get_sip_status($GetAccountSipStateRequest_info);
                } else {
                  $AccountSipState_response = $this->accountSipState_info->get_sip_status($GetAccountSipStateRequest_info);
                }
                
                if($AccountSipState_response){
                  $this->sip_status = (isset($AccountSipState_response->sip_status) ? $AccountSipState_response->sip_status : 0);
                  $this->sip_contact = (isset($AccountSipState_response->sip_info->contact) ? $AccountSipState_response->sip_info->contact : "");
                  return $resp = true;        
                } else {
                	$this->sip_status = "";
                	$this->sip_contact = "";
                  return $resp = false;
                }
                
            } else{
              return $resp = false;
            }
        
        } catch (SoapFault $exception) { } 
    }
    
  /* Metodo para realizar la busqueda del IPDevice de una cuenta */
  function get_ua_info ($i_account, $iteracion) {
        try {
            if ($iteracion==1) {
              $GetUA_info = new SoapClient($this->wsdl_url_account);
              $GetUA_info->__setSoapHeaders($this->auth_info);
              $this->GetUA_info = $GetUA_info;
            }
                                   
            $GetUARequest_info = array('i_account' => $i_account);
                        
            if ($GetUARequest_info) {
                if ($iteracion==1) {
                  $UA_response = $GetUA_info->get_ua_info($GetUARequest_info);
                } else {
                  $UA_response = $this->GetUA_info->get_ua_info($GetUARequest_info);
                }
                
                if($UA_response){
                  $this->ua_info = $UA_response->ua_info;
                  return $resp = true;        
                } else {
                	$this->ua_info = "";
                  return $resp = false;
                }
                
            } else{
              return $resp = false;
            }
        
        } catch (SoapFault $exception) { } 
  }
    
  /* Metodo para realizar la busqueda del status de una cuenta */
  function get_service_list() {
        try {
            $service_list_info = new SoapClient($this->wsdl_url_service);
            $service_list_info->__setSoapHeaders($this->auth_info);
            
            $GetServiceListRequest_info = array('offset' => 0, 'limit' => 0);
                        
            if ($GetServiceListRequest_info) {
                $ServiceList_response = $service_list_info->get_service_list($GetServiceListRequest_info);
                                
                if($ServiceList_response){
                  $this->service_list = $ServiceList_response->service_list;
                  return $resp = true;        
                }else{
                	$this->service_list = "";
                  return $resp = false;
                }
                
            }else{
              return $resp = false;
            }
      } catch (SoapFault $exception) { } 
    }

  /* Metodo para realizar la busqueda de los facturas pertenecientes a un RESELLER*/
  function get_invoice_list($i_parent, $iteracion, $cantidad) {
        try {
            if ($iteracion==1) {
              $invoice_list_info = new SoapClient($this->wsdl_url_invoice);
              $invoice_list_info->__setSoapHeaders($this->auth_info);
              $this->invoice_list_info = $invoice_list_info;
            }
            
            // Se extraen como maximo las primeras 3000 facturas, 
            // dado que al intentar sacar mas se obtiene error del SOAP
            $GetInvoiceListRequest_info = array('offset' => ($cantidad==0 ? 0 : (3000*$cantidad)),
                                                'limit'  => 3000, 'i_parent' => $i_parent);
            
            if ($GetInvoiceListRequest_info) {
               if ($iteracion==1) {
                    $invoice_list_response = $invoice_list_info->get_invoice_list($GetInvoiceListRequest_info);
                } else {
                    $invoice_list_response = $this->invoice_list_info->get_invoice_list($GetInvoiceListRequest_info);
                }
                
                if($invoice_list_response){
                  $this->invoice_list = $invoice_list_response->invoice_list;
                  return $resp = true;        
                }else{
                 $this->invoice_list = "";
                  return $resp = false;
                }
            
            }else{
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

/* Metodo para realizar la busqueda de los custom field de un cliente */
  function get_custom_fields_schema($i_customer, $iteracion) {
        try {
            if ($iteracion==1) {
              $custom_fields_schema_info = new SoapClient($this->wsdl_url_customer);
              $custom_fields_schema_info->__setSoapHeaders($this->auth_info);
              $this->custom_fields_schema_info = $custom_fields_schema_info;
            }
        	
            $GetCustomFieldsRequest_info = array('i_customer' => $i_customer);
            
            if ($GetCustomFieldsRequest_info) {
            	if ($iteracion==1) {
                $custom_fields_response = $custom_fields_schema_info->get_custom_fields_schema($GetCustomFieldsRequest_info);
              } else { 
              	$custom_fields_response = $this->custom_fields_schema_info->get_custom_fields_schema($GetCustomFieldsRequest_info);
              }
                                
              if ($custom_fields_response->custom_fields) {
                $this->custom_fields = $custom_fields_response->custom_fields;
                return $resp = true;
              } else {
                $this->custom_fields = "";
                return $resp = false;
              }
            } else {
              return $resp = false;
            }
        } catch (SoapFault $exception) { }
  }
  
  /* Metodo para realizar la busqueda de los productos de un Reseller */
  function get_product_list($i_reseller) {
        try {
            $product_list_info = new SoapClient($this->wsdl_url_product);
            $product_list_info->__setSoapHeaders($this->auth_info);
            $this->product_list_info = $product_list_info;
                        
            $GetProductListRequest_info = array('i_customer' => $i_reseller, 'offset' =>0, 'limit' => 0);
                        
            if ($GetProductListRequest_info) {
                $Product_list_response = $product_list_info->get_product_list($GetProductListRequest_info);
                                
                if($Product_list_response){
                  $this->product_list = $Product_list_response->product_list;
                  return $resp = true;        
                }else{
                	$this->product_list = "";
                  return $resp = false;
                }
                
                }else{
                  return $resp = false;
                }
        } catch (SoapFault $exception) { } 
    }
    
  /* Metodo para realizar la busqueda de la tabla de Volume Discount Plan */
  function get_discount_plan_list($iso_4217) {
        try {

            $discountplan_list_info = new SoapClient($this->wsdl_url_discountplan);
            $discountplan_list_info->__setSoapHeaders($this->auth_info);

            // Se especifica un nro alto para el limit pues al poner 0/vacio/null solo se obtienen los primeros 50 registros
            $GetDiscountPlanListRequest_info = array('name' => null, 'offset' =>0, 'limit' => 3000, 'iso_4217' => $iso_4217);

            if ($GetDiscountPlanListRequest_info) {

                $discountplan_response = $discountplan_list_info->get_discount_plan_list($GetDiscountPlanListRequest_info);

                if ($discountplan_response->discount_plan_list) {
                    $this->discount_plan_list = $discountplan_response->discount_plan_list;
                    return $resp = true;
                } else {
                	  $this->discount_plan_list = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
    } 
    
  /* Metodo para realizar la busqueda de PaymentInfo */
  function get_payment_method_info($i_customer) {
        try {
            $payment_method_infor = new SoapClient($this->wsdl_url_customer);
            $payment_method_infor->__setSoapHeaders($this->auth_info);

            $GetPaymentInfoRequest_info = array('i_customer' => $i_customer);

            if ($GetPaymentInfoRequest_info) {

                $payment_response = $payment_method_infor->get_payment_method_info($GetPaymentInfoRequest_info);

                if ($payment_response->payment_method_info) {
                    $this->payment_method_info = $payment_response->payment_method_info;
                    return $resp = true;
                } else {
                	  $this->payment_method_info = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
    }    

  /* Metodo para realizar un Balance Adjustment */
  function make_transaction($i_customer, $action, $amount, $visible_comment, $iteracion) {
        try {
            if ($iteracion==1) {
              $add_make_transaction = new SoapClient($this->wsdl_url_customer);
              $add_make_transaction->__setSoapHeaders($this->auth_info);
              $this->add_make_transaction = $add_make_transaction;
            }

            $MakeTransactionRequest_info = array('i_customer'      => $i_customer, 
                                                 'action'          => $action, 
                                                 'amount'          => $amount,
                                                 'visible_comment' => $visible_comment);

            if ($MakeTransactionRequest_info) {
                if ($iteracion==1) { 
                  $MakeTransaction_response = $add_make_transaction->make_transaction($MakeTransactionRequest_info);
                } else {
                  $MakeTransaction_response = $this->add_make_transaction->make_transaction($MakeTransactionRequest_info);
                }

                if ($MakeTransaction_response) {
                    $this->MTbalance = $MakeTransaction_response->balance;
                    $this->MTtransaction_id = $MakeTransaction_response->transaction_id;
                    $this->MTauthorization = $MakeTransaction_response->authorization;
                    $this->MTresult_code = $MakeTransaction_response->result_code;
                    $this->MTi_xdr = $MakeTransaction_response->i_xdr;
                    return $resp = true;
                } else {
                    $this->MTbalance = "";
                    $this->MTtransaction_id = "";
                    $this->MTauthorization = "";
                    $this->MTresult_code = "";
                    $this->MTi_xdr = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
    } 

  /* Metodo para actualizar info del cliente (usado para habilitar/deshabilitar "Auto-Payments Management Enabled" -> campo ppm_enabled */
  function update_customer($i_customer, $ppm_enabled, $iteracion) {
     try {
     	       if ($iteracion==1) {
               $add_update_customer = new SoapClient($this->wsdl_url_customer);
               $add_update_customer->__setSoapHeaders($this->auth_info);
               $this->add_update_customer = $add_update_customer;
             }
             
             $customerInfo = array('i_customer'   => $i_customer,
                                    'ppm_enabled' => $ppm_enabled);
                                                                   
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
   
   /* Metodo para obtener la lista de "Periodical Payments" asociados a un customer*/
  function get_periodical_payment_list($i_customer, $iteracion) {
        try {
        	  if ($iteracion==1) {
              $get_periodical_payment_list = new SoapClient($this->wsdl_url_customer);
              $get_periodical_payment_list->__setSoapHeaders($this->auth_info);
              $this->get_periodical_payment_list = $get_periodical_payment_list;
            }

            $GetPeriodicalPaymentList_info = array('i_object' => $i_customer);

            if ($GetPeriodicalPaymentList_info) {
                if ($iteracion==1) {
                  $GetPeriodicalPaymentList_response = $get_periodical_payment_list->get_periodical_payment_list($GetPeriodicalPaymentList_info);
                } else {
                  $GetPeriodicalPaymentList_response = $this->get_periodical_payment_list->get_periodical_payment_list($GetPeriodicalPaymentList_info);
                }
                
                if ($GetPeriodicalPaymentList_response->periodical_payment_list) {
                    $this->periodical_payment_list = $GetPeriodicalPaymentList_response->periodical_payment_list;
                    return $resp = true;
                } else {
                	  $this->periodical_payment_list = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
   } 

  /* Metodo para actualizar (habilitar/deshabilitar) "Periodical Payments" (Pay) -> "Pestania Auto-Payments" */
  function update_periodical_payment($i_periodical_payment, $i_customer, $bFrozen, $iteracion) {
     try {
             if ($iteracion==1) {
               $upd_periodical_payment = new SoapClient($this->wsdl_url_customer);
               $upd_periodical_payment->__setSoapHeaders($this->auth_info);
               $this->upd_periodical_payment = $upd_periodical_payment;
             }

             $periodicalPaymentInfo = array('i_periodical_payment' => $i_periodical_payment,
                                            'i_object'             => $i_customer,
                                            'frozen'               => $bFrozen);
                                                                   
             if ($periodicalPaymentInfo) {
                 if ($iteracion==1) { 
                   $UpdPeriodicalPayment_response = $upd_periodical_payment->update_periodical_payment(array('periodical_payment_info' => $periodicalPaymentInfo));
                 } else {
                   $UpdPeriodicalPayment_response = $this->upd_periodical_payment->update_periodical_payment(array('periodical_payment_info' => $periodicalPaymentInfo));
                 }

                 if ($UpdPeriodicalPayment_response) {
                     $this->i_periodical_payment = $UpdPeriodicalPayment_response->i_periodical_payment;
                     return $resp = true;
                 } else {
                     $this->i_periodical_payment = "";
                     return $resp = false;
                 }
             } else {
                 return $resp = false;
             }
     } catch (SoapFault $exception) { }
   }
   
  /* Metodo para obtener la lista de numeros del DID Inventory*/
  function get_number_list($iteracion, $cantidad) {
        try {
        	  if ($iteracion==1) {
        	    $get_numberL_list = new SoapClient($this->wsdl_url_DID);
              $get_numberL_list->__setSoapHeaders($this->auth_info);
              $this->get_numberL_list = $get_numberL_list;
            }
            
            // Se extraen como maximo los primeros 100 Nros
            // dado que al intentar sacar mas se obtiene error del SOAP
            $GetNumberLList_info = array('offset' => ($cantidad==0 ? 0 : (100*$cantidad)), 
                                         'limit'  => 100);
            
            if ($GetNumberLList_info) {
                if ($iteracion==1) {
                  $GetNumberLList_response = $get_numberL_list->get_number_list($GetNumberLList_info);
                } else {
                  $GetNumberLList_response = $this->get_numberL_list->get_number_list($GetNumberLList_info);
                }
                
                if ($GetNumberLList_response->number_list) {
                    $this->number_list = $GetNumberLList_response->number_list;
                    return $resp = true;
                } else {
                	  $this->number_list = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
   } 
   
  /* Metodo para obtener la lista de los Vendor Batch*/
  function get_vendor_batch_list($iteracion, $cantidad) {
        try {
        	  if ($iteracion==1) {
        	    $get_vendor_batchL_list = new SoapClient($this->wsdl_url_DID);
              $get_vendor_batchL_list->__setSoapHeaders($this->auth_info);
              $this->get_vendor_batchL_list = $get_vendor_batchL_list;
            }
            
            // Se extraen como maximo los primeros 100 Vendor Batch
            // dado que al intentar sacar mas se obtiene error del SOAP
            $GetVendorBatchLList_info = array('offset' => ($cantidad==0 ? 0 : (100*$cantidad)), 
                                              'limit'  => 100);
            
            if ($GetVendorBatchLList_info) {
                if ($iteracion==1) {
                  $GetVendorBatchLList_response = $get_vendor_batchL_list->get_vendor_batch_list($GetVendorBatchLList_info);
                } else {
                  $GetVendorBatchLList_response = $this->get_vendor_batchL_list->get_vendor_batch_list($GetVendorBatchLList_info);
                }
                
                if ($GetVendorBatchLList_response->vendor_batch_list) {
                    $this->vendor_batch_list = $GetVendorBatchLList_response->vendor_batch_list;
                    return $resp = true;
                } else {
                	  $this->vendor_batch_list = "";
                    return $resp = false;
                }
            } else {
                return $resp = false;
            }
        } catch (SoapFault $exception) { }
   } 
   
  /* Metodo para realizar la busqueda de TODOS los Customer Class */
  function get_customer_class_list_all() {
        try {
            $customerclass_list_info = new SoapClient($this->wsdl_url_customerclass);
            $customerclass_list_info->__setSoapHeaders($this->auth_info);
                        
            $customerclass_list_response = $customerclass_list_info->get_customer_class_list();
                
            if($customerclass_list_response){
                  $this->customerclass_listA = $customerclass_list_response->customer_class_list;
                  return $resp = true;        
            }else{
                	$this->customerclass_listA = "";
                  return $resp = false;
            }

        } catch (SoapFault $exception) { } 
    }
   
  /* Metodo para realizar la busqueda de los numeros FollowMe asociados a la cuenta pasada por parametro*/
  function get_account_followme($idCuenta, $iteracion) {
        try {
            if ($iteracion==1) {
              $account_followme_info = new SoapClient($this->wsdl_url_account);
              $account_followme_info->__setSoapHeaders($this->auth_info);
              $this->account_followme_info = $account_followme_info;
            }
                                   
            $account_followme_Request_info = array('i_account' => $idCuenta);
                        
            if ($account_followme_Request_info) {
                if ($iteracion==1) {
                  $account_followme_Response = $account_followme_info->get_account_followme($account_followme_Request_info);
                } else {
                  $account_followme_Response = $this->account_followme_info->get_account_followme($account_followme_Request_info);
                }
                
                if($account_followme_Response){
                  $this->followme_numbers = $account_followme_Response->followme_numbers;
                  return $resp = true;        
                } else {
                	$this->followme_numbers = "";
                  return $resp = false;
                }
                
            } else{
              return $resp = false;
            }
        
        } catch (SoapFault $exception) { } 
    }
    
  /* Metodo para obtener la lista de cambios de status del cliente */
  function get_status_history($i_customer, $iteracion) {
        try {
            if ($iteracion==1) {
              $status_history_info = new SoapClient($this->wsdl_url_customer);
              $status_history_info->__setSoapHeaders($this->auth_info);
              $this->status_history_info = $status_history_info;
            }
                                   
            $status_history_Request_info = array('i_customer' => $i_customer, 'limit' => 1000, 'offset' => 0);
                        
            if ($status_history_Request_info) {
                if ($iteracion==1) {
                  $status_history_Response = $status_history_info->get_status_history($status_history_Request_info);
                } else {
                  $status_history_Response = $this->status_history_info->get_status_history($status_history_Request_info);
                }
                
                if($status_history_Response){
                  $this->status_history_changes = $status_history_Response->status_history_changes;
                  return $resp = true;        
                } else {
                	$this->status_history_changes = "";
                  return $resp = false;
                }
                
            } else{
              return $resp = false;
            }
        
        } catch (SoapFault $exception) { } 
    }

}

?>