<?php

header('Content-Type: application/json');
include_once("../../conexiones/Base_Datos/conexion.php");

$con=conectar();

if($_POST['opcion'] == 'InicioSesion')
{
	
	$informacion                =                               array();
	$usuario                    =                               '';
    $password                   =                               '';
	$alerta                     =                               '';
    $mensaje                    =                               '';
	$usuario                    =                               $_POST["usuario"];
	$password                   =                               $_POST["password"];
	
	
	$consu_usu 					=								$con->query('SELECT * 
																					FROM usuarios 
																				WHERE nikename = "'.$_POST["usuario"].'"');
	$consu_email 				=								$con->query('SELECT * 
																				FROM usuarios 
																			WHERE correo_electronico = "'.$_POST["usuario"].'"');

	if($consu_usu->num_rows == 0){
		if($consu_email->num_rows == 0){
			$mensaje                    =                               'El Usuario no existe en nuestra Base de Datos';
			$alerta						= 								'ERROR';
		}else{
			$consu_usu_co 					=								$con->query('SELECT * 
																							FROM usuarios 
																								WHERE correo_electronico = "'.$_POST["usuario"].'"
																								AND password =  "'.$_POST["password"].'"');
			if($consu_usu_co->num_rows == 0){
				$mensaje                    =                               'La contraseña ingresada es incorrecta.';
				$alerta						= 								'ERROR';
			}elseif($consu_usu_co->num_rows > 0){
				
				
				
			}
		}
	}elseif($consu_usu->num_rows > 0){
		$consu_usu_co 					=								$con->query('SELECT * 
																						FROM usuarios 
																							WHERE nikename = "'.$_POST["usuario"].'"
																							AND password =  "'.$_POST["password"].'"');
		if($consu_usu_co->num_rows == 0){
			$mensaje                    =                               'La contraseña ingresada es incorrecta.';
			$alerta						= 								'ERROR';
		}elseif($consu_usu_co->num_rows > 0){
			foreach($consu_usu_co as $data)
			{
				$tp_documento      	                =                               $data["tp_documento"];
				$numero_documento                   =                               $data["numero_documento"];
				$nombre_usurio                      =                               $data["primer_nombre"].' '.$data["primer_apellido"];
				$nikename                      		=                               $data["nikename"];
				$email                      		=                               $data["correo_electronico"];
				$fecha_nacimiento                   =                               $data["fecha_nacimiento"];
				$cant_gemas                   		=                               $data["gemas"];
				$estado_usu                			=                               $data["estado"];
				$rol_usu                   			=                               $data["rol"];
				$fecha_creacion          			=                               $data["fecha_create"];
			}
			
			if($estado_usu == 0)
			{
				session_start();
				$estado_session                   	=                               'Activa';
				$id_session                         =                               session_id();
				$_SESSION["id_session"]             =                               $id_session;
				$_SESSION["nikename"]               =                               $nikename;
				$_SESSION["tp_documento"]           =                               $tp_documento;
				$_SESSION["numero_documento"]       =                               $numero_documento;
				$_SESSION["nombre_usurio"]          =                               $nombre_usurio;
				$_SESSION["email"]               	=                               $email;
				$_SESSION["fecha_nacimiento"]       =                               $fecha_nacimiento;
				$_SESSION["cant_gemas"]             =                               $cant_gemas;
				$_SESSION["estado_usu"]             =                               $estado_usu;
				$_SESSION["rol_usu"]               	=                               $rol_usu;
				$_SESSION["fecha_creacion"]         =                               $fecha_creacion;
				$_SESSION["estado_session"]         =                               $estado_session;
				$informacion    					= 								array(
																							"ID_SESSION"            =>              $id_session,
																							"ESTADO_SESION"         =>              $estado_session,
																						);
			}
			elseif($estado_usu == 1)
			{
				$mensaje                    =                               'El usuario actualmente esta inactivo, porfavor contactarse con el administrador.';
				$alerta						= 								'NOTI';
			}
			elseif($estado_usu == 2)
			{
				$mensaje                    =                               'El usuario actualmente esta betado, porfavor contactarse con el administrador.';
				$alerta						= 								'NOTI';
			}
		}
	}
	print json_encode(array("INFORMACION" => $informacion, "ALERTA" => $alerta, "MENSAJE" => $mensaje));
}
elseif($_POST['opcion'] == 'CerrarSesion')
{
    session_start();
    $estado_sesion                      =                               'Inactiva';
    $_SESSION["estado_session"]         =                               $estado_sesion;

    print json_encode(array("ESTADO_SESSION" => $_SESSION["estado_session"]));
}
