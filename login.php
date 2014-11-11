<?php
include_once ("lib/nui2.php");
include ("lib/libreriaBD.php");
include ("lib/libreriaBD_portaone.php");
session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

date_default_timezone_set('America/Caracas'); 
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Control de Tráfico de Telefonía</title>


        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="css/styles.css" rel="stylesheet">

        <script type="text/javascript">
            function validar(f) { //Validar que todos los campos tengan valores asignados
                if (f.usuario.value == null || f.usuario.value.trim()=="") { 
                    alert ('Debe ingresar su login o nombre de usuario');  
                    f.usuario.focus(); 
                    return false; 
                }
                if (f.clave.value == null || f.clave.value.trim()=="") { 
                    alert ('Debe ingresar su password o contrase\u00f1a');  
                    f.clave.focus(); 
                    return false; 
                }
                return true; 
            } 
        </script>
    </head>

    <body>
        <div class="container">
            <div id="logo"><a href="/Anti-fraude"><img src="img/logo-login.png" alt="" class="center-block"></a></div>
            <div id="cuerpo">
                <h1 id="login-titulo">Control de Tráfico de Telefonía</h1>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div id="login-box" class="jumbotron">
                            <form class="form-horizontal" role="form" action="" method="POST" onsubmit="return validar(this)">
                                <div id="campo1_Fact" class="form-group">
                                  <label for="usuario" id="label_usuario" class="col-sm-2 col-sm-offset-1 control-label labellogin">Login</label>
                                  <div class="col-sm-6">
                                    <input type="text" name="usuario" id="usuario" class="form-control inputlogin" value="" placeholder="Usuario" autofocus> </input>
                                  </div>
                                </div><br>
                                <div id="campo2" class="form-group">
                                  <label for="clave" id="label_clave" class="col-sm-2 col-sm-offset-1 control-label labellogin">Password</label>
                                  <div class="col-sm-6">
                                    <input type="password" name="clave" id="clave" class="form-control inputlogin" placeholder="Password">
                                  </div>
                                </div><br>
                                <div id="campo3" class="form-group" style="display:none;">
                                  <label for="portaone" id="label_select" class="col-sm-2 col-sm-offset-1 control-label labellogin">PortaOne</label>
                                  <div class="col-sm-6">
                                    <select name="portaone" id="portaone" class="form-control inputlogin">
                                        <option value="1">Costa Rica (CR)</option>
                                        <option value="2">Panama (PA)</option>
                                    </select>
                                  </div>
                                </div></br>
                                <div id="boton" class="form-group">
                                  <div class="col-sm-offset-2 col-sm-8">
                                    <input type="submit" value="Login" id="loginBut" class="btn btn-primary" name="login"/>
                                  </div>
                                </div>
                            </form>
                            <?php
                            if(isset($_POST['login'])){ 
                                $_SESSION["USUARIO"] = trim($_POST['usuario']);
                                $_SESSION["CLAVE"] = trim($_POST['clave']);
                                $_SESSION["PORTAONE"] = trim($_POST['portaone']);
                                
                                $registrado = select_sql("select_usuario",$_SESSION["USUARIO"]);
                                $activo = select_sql("select_usuario_activo",$_SESSION["USUARIO"]);
                                
                                if ((!isset($registrado[1]["c_Usuario"])) || (!isset($activo[1]["c_Usuario"]))) {
                                    $_SESSION = array();
                                    echo "<div id='error' class='alert alert-danger'>ERROR: Login o password inválido</div>";
                                }else{
                                     $wsdl = select_sql('select_url_wsdl');
                                     $salida = new nui($_SESSION["USUARIO"],$_SESSION["CLAVE"],$wsdl[1]['x_Url_Wsdl']);
                                    if (!$salida->logged) {
                                        $_SESSION = array();
                                        echo "<div id='error' class='alert alert-danger'>ERROR: Login o password inválido</div>";
                                    }else{
                                        //Redireccionamiento a pag. "af_reportes_usuariolist.php" cuando login/password es correcto y se inicio la sesion
                                        $datos =  select_sql('select_usuario_all', $_SESSION['USUARIO']);
                                        $_SESSION['USUARIO_TYPE']['admin'] = $datos[1]['i_Admin'];
                                        $_SESSION['USUARIO_TYPE']['config'] = $datos[1]['i_Config'];
                                        $_SESSION['filtros']="";
                                        $_SESSION['filtros_umb_dest']="";
                                        $_SESSION['filtros_umb']['reseller']="";
                                        $_SESSION['filtros_umb']['destino']="";
                                        $_SESSION['filtros_umb']['cname']="";
                                        $_SESSION['filtros_umb']['cclass']="";
                                        $_SESSION['filtros_acc']['tipo_accion']="";
                                        $_SESSION['filtros_acc']['clase_accion']="";
                                        $_SESSION['filtros_acc']['reseller']="";
                                        $_SESSION['filtros_acc']['cclass']="";
                                        $_SESSION['filtros_log']['desde']="";
                                        $_SESSION['filtros_log']['hasta']="";
                                        $_SESSION['filtros_log']['tabla']="";
                                        $_SESSION['filtros_log']['campo']="";
                                        $_SESSION['filtros_log']['cambio']="";
                                        $_SESSION['filtros_log']['usuario']="";
                                        $_SESSION['filtros_log']['reporte']="";
                                        $_SESSION['filtros_log']['estatus']="";
                                        $_SESSION['filtros_log']['clase']="";
                                        $_SESSION['filtros_log']['nivel']="";
                                        $_SESSION['filtros_log']['destino']="";
                                        
                                        echo "<script language='javascript'>window.location='af_reportes_usuariolist.php'</script>"; 
                                    }
                                }
                                //abrirConexion_PO();
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- <form action="" method="POST" onsubmit="return validar(this)">
                    <div id="campo1_Fact">
                        <label id="label_usuario" for="usuario">Login</label>
                        <input type="text" name="usuario" id="usuario" value=""> </input>
                    </div>
                    <div id="campo2">
                        <label id="label_clave" for="clave">Password</label>
                        <input type="password" name="clave" id="clave" value=""> </input>
                    </div>
                    <div id="campo2">
                        <label id="label_clave" for="portaone">PortaOne</label>
                        <select name="portaone" id="portaone">
                            <option value="1">Costa Rica (CR)</option>
                            <option value="2">Panama (PA)</option>
                        </select>
                    </div>
                    <div id="boton">
                        <input type="submit" value="Login" id="login" name="login"/>
                    </div>
                </form> -->
                
            </div>
        </div>

        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>