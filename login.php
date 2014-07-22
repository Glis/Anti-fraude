<?php
include_once ("lib/nui.php");
include ("lib/libreriaBD.php");
include ("lib/libreriaBD_portaone.php");
session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

date_default_timezone_set('America/Caracas'); 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>M&oacute;dulo de Reportes de PortaOne</title>
        <link rel="stylesheet" type="text/css" media="all" href="css/index.css"/>
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
<?php

if(isset($_POST['login'])){ 
    $_SESSION["USUARIO"] = trim($_POST['usuario']);
    $_SESSION["CLAVE"] = trim($_POST['clave']);
    $_SESSION["PORTAONE"] = trim($_POST['portaone']);
	
    $registrado = select_sql("select_usuario",$_SESSION["USUARIO"]);
    if (!isset($registrado[1]["c_Usuario"])) {
        $_SESSION = array();
        //session_destroy();
        echo "<h1>asd</h1>";
        goto fin2;
    }

    $activo = select_sql("select_usuario_activo",$_SESSION["USUARIO"]);
    if (!isset($activo[1]["c_Usuario"])) {
        $_SESSION = array();
        //session_destroy();
        echo "<h1>asd</h1>";
        goto fin3;
    }

    $salida = new nui($_SESSION["USUARIO"],$_SESSION["CLAVE"],$_SESSION["PORTAONE"]);
    if (!$salida->logged) {
        $_SESSION = array();
        //session_destroy();
        goto fin1;
    }

    //abrirConexion_PO();
    //Redireccionamiento a pag. "af_acc_cclasslist.php" cuando login/password es correcto y se inicio la sesion
    echo "<script language='javascript'>window.location='af_acc_cclasslist.php'</script>"; 
}
?>
    <body>
        <div id="logo"> </div>
        <div id="cuerpo">
            <h3 id="titulo">M&oacute;dulo de Reportes de PortaOne</h3>
            <hr/>
            <form action="" method="POST" onsubmit="return validar(this)">
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
            </form>
        </div>
    </body>
<?php
goto fin;
	
fin1:
?>
    <body>
        <div id="logo"> </div>
        <div id="cuerpo">
            <h3 id="titulo">M&oacute;dulo de Reportes de PortaOne</h3>
            <hr/>
            <form action="" method="POST" onsubmit="return validar(this)">
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
            </form>
            <h5 id="error"><?php echo "ERROR: Login o password inv&aacute;lido"."<br><br>"; ?></h5>
        </div>
    </body>
<?php	
    goto fin;

fin2:
?>
    <body>
        <div id="logo"> </div>
        <div id="cuerpo">
            <h3 id="titulo">M&oacute;dulo de Reportes de PortaOne</h3>
            <hr/>
            <form action="" method="POST" onsubmit="return validar(this)">
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
            </form>
            <h5 id="error"><?php echo "ERROR: Usuario no registrado en el M&oacute;dulo"."<br><br>"; ?></h5>
        </div>
    </body>
<?php	
    goto fin;
	
fin3:
?>
    <body>
        <div id="logo"> </div>
        <div id="cuerpo">
            <h3 id="titulo">M&oacute;dulo de Reportes de PortaOne</h3>
            <hr/>
            <form action="" method="POST" onsubmit="return validar(this)">
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
            </form>
            <h5 id="error"><?php echo "ERROR: Usuario no Activo en el M&oacute;dulo"."<br><br>"; ?></h5>
        </div>
    </body>
<?php	
    goto fin;
	
fin:
?>
</html>