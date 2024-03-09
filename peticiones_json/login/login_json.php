<?php

header('Content-Type: application/json');
include_once("../../conexiones/Base_Datos/conexion.php");

$con=conectar();

if($_POST['opcion'] == 'InicioSesion'){
	$usuario                    =                               '';
    $password                   =                               '';
    $mensaje                    =                               '';
	$usuario                    =                               $_POST["usuario"];
	$password                   =                               $_POST["usuario"];
}





if($_POST['opcion'] == 'InicioSesion'){

    $usuario                    =                               '';
    $password                   =                               '';
    $mensaje                    =                               '';
    $informacion                =                               array();
    $usuario                    =                               $_POST["usuario"];
    $estado_sesion              =                               'Inactiva';
    $estado                     =                               '';
    
    $user                       =                               $db->ConsultarUsuario($usuario);

    if($user == ''){
        $mensaje                    =                               'El Usuario no existe en nuestra Base de Datos';
        $estado                     =                               'NOT_USER';
        $informacion    = array(
                                "ESTADO"                =>              $estado,
                                "MENSAJE"               =>              $mensaje
                                );
    }else{
        $password                   =                               $_POST["password"];

        if($password == $user["PASS_USU"]){

            if($user["CREACIONZOOM"] == 'N'){
                $mensaje                    =                               'El Usuario no tiene permisos para crear Zoom, porfavor contactar el administrador';
                $estado                     =                               'NOT_CREATE_ZOOM';
                $informacion    = array(
                                        "ESTADO"                =>              $estado,
                                        "MENSAJE"               =>              $mensaje
                                        );
            }else{
                $mensaje                    =                               'OK';
                session_start();
                $id_session                         =                               session_id();
                $estado_sesion                      =                               'Activa';
                $Nombre_usu                         =                               $user["NOM_COMP"];
                $_SESSION["estado_session"]         =                               $estado_sesion;
                $_SESSION["Nombre"]                 =                               $Nombre_usu;
                $estado                             =                               '';
                $_SESSION["User"]                   =                               $user["NOM_USU"];
                // $_SESSION["Area"]                   =                               $user["Area"];

                $informacion    = array(
                                            "ESTADO"                =>              $estado,
                                            "MENSAJE"               =>              $mensaje,
                                            "ID_SESSION"            =>              $id_session,
                                            "ESTADO_SESION"         =>              $estado_sesion,
                                        );
            }  
            
        }else{
            $estado                     =                               'NOT_PASSWORD';
            $mensaje                    =                               'La Contraseña ingresada es incorrecta.';
            $informacion    = array(
                                        "ESTADO"                =>              $estado,
                                        "MENSAJE"               =>              $mensaje
                                    );
        } 
    }

    print json_encode(array("DATA" => $informacion));
}elseif($_POST['opcion'] == 'CerrarSesion'){
    session_start();
    $estado_sesion                      =                               'Inactiva';
    $_SESSION["estado_session"]         =                               $estado_sesion;

    print json_encode(array("ESTADO_SESSION" => $_SESSION["estado_session"]));
}
