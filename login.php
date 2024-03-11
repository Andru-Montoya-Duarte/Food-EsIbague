<!doctype html>
	<html lang="en">
		<head>
			<title>Login | Food&Es</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
			<link rel="stylesheet" href="./includes/css/style.css">
			<link href="./includes/Librerias/bootstrap/css/bootstrap.css" rel="stylesheet" media="all">
			<link href="./includes/Librerias/bootstrap_validation/css/bootstrapValidator.css" rel="stylesheet" media="all">
			<link href="./includes/Librerias/animate/css/animate.min.css" rel="stylesheet" media="all">
			<link href="./includes/Librerias/Jquery-confirm/css/jquery-confirm.min.css" rel="stylesheet" media="all">
			<style>
				.form-control
				{
					background-color: transparent;
				}
				.form-control:focus
				{
					background-color: transparent;
				}
			</style>
		</head>
		<body class="img js-fullheight" style="background-image: url(./includes/Imagenes/Login/Fondo.jpg);">
			<section class="ftco-section">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-6 text-center mb-4">
							<h2 class="heading-section">Login #10</h2>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-6 col-lg-4">
							<div class="login-wrap p-0">
								<h3 class="mb-4 text-center">Inicio de Sesion</h3>
								<form id="form_login" name="form_login" class="signin-form">    
									<div class="form-group">
										<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nikename o Correo Electronico">
									</div>
									<div class="form-group">
									  <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
									  <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
									</div>
									<div class="form-group">
										<button type="submit" class="form-control btn btn-primary submit px-3">Ingresar</button>
									</div>
									<div class="form-group d-md-flex">
										<div class="w-50">
											<label class="checkbox-wrap checkbox-primary">Recordarme
												<input type="checkbox" checked>
												<span class="checkmark"></span>
											</label>
										</div>
										<div class="w-50 text-md-right">
											<a href="#" style="color: #fff" onclick="olvidePassword('ObtenerCodigo')">¿Olvidaste tu contraseña?</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="toast-container position-absolute top-0 end-0 p-3">
				<div class="toast" id="ToastNoti" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="toast-header" id="cabeceraToast">
					</div>
					<div class="toast-body" id="contenidoToast">
					</div>
				</div>
			</div>

			<div class="modal fade" id="modalAcciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Mi Modal Estático</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <div class="modal-body">
					<p>Contenido del modal...</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary">Guardar cambios</button>
				  </div>
				</div>
			  </div>
			</div>
				
			<script src="./includes/Librerias/Jquery/jquery-3.7.1.min.js"></script>
			<script src="./includes/Librerias/Jquery-confirm/js/jquery-confirm.min.js"></script>
			<script src="./includes/js/popper.js"></script>
			<script src="./includes/Librerias/bootstrap/js/bootstrap.min.js"></script>
			<script src="./includes/Librerias/bootstrap_validation/js/bootstrapValidator.min.js"></script>
			<script src="./includes/js/main.js"></script>
			<script src="./includes/Librerias/bootstrap/js/bootstrap.bundle.js"></script>
			<script type="text/javascript">
				var FormOlvideCon;
				var ToaNotifi = new bootstrap.Toast(document.getElementById('ToastNoti'));
				
				$(document).ready(function() {
					$('#form_login').bootstrapValidator({
						excluded: [":disabled", ":hidden", ":not(:visible)"],
						message: 'Este Valor no es Valido',
						feedbackIcons: {
											valid: 'glyphicon glyphicon-ok',
											invalid: 'glyphicon glyphicon-remove',
											validating: 'glyphicon glyphicon-refresh'
										},      
						fields: {
									usuario: {
										validators: { 
														notEmpty: {
																	message: 'Seleccionar un valor válido'
																	}
													}
										},
									password: {
											validators: { 
															notEmpty: {
																		message: 'Seleccionar un valor válido'
																	}
														}
										}, 
								}
					}).on('success.form.bv', function(e) {
						e.preventDefault();   
						var $form = $(e.target);
                        $(".chosen-select").trigger('chosen:updated');
						requisitos(
									"POST", 
									"./peticiones_json/login/login_json.php", 
									"opcion=InicioSesion&" + $form.serialize()+"&jsonp=?", 
									function(data){
										if(data["ALERTA"] == '')
										{
											window.location.replace("./index.php");// agregar vista de administracion por el usuario
										}	
										if(data["ALERTA"] == 'ERROR')
										{
											toastNotifi(data["ALERTA"],'ERROR', data["MENSAJE"], '', 'abrir');
										}
										if(data["ALERTA"] == 'NOTI')
										{
											toastNotifi(data["ALERTA"],'NOTIFICACIÓN', data["MENSAJE"], '', 'abrir');
										}
									}, 
									"", 
									Array()
								);
						$form
						.bootstrapValidator('disableSubmitButtons', true);
					});
				});
				
				function requisitos(method, url, data, successCallback, errorCallback, headers) {
					$.ajax({
						type: method,
						url: url,
						data: data,
						success: successCallback,
						error: errorCallback,
						headers: headers
					});
				}
				
				function startProgressBar() {
					var progressBar = document.getElementById('myProgressBar');
					var width = 0;
					var interval = setInterval(function () {
						if (width >= 100) {
							clearInterval(interval);
							setTimeout(function () {
								toastNotifi('','', '', '', 'cerrar');
							}, 200);
						} else {
							width += 2;
							progressBar.style.width = width + '%';
						}
					}, 50);
				}
				
				function olvidePassword(accion) {
					if(accion == 'ObtenerCodigo')
					{
						FormOlvideCon = $.confirm({
							title: 'Restablece tu contraseña',
							backgroundDismiss: false,
							closeIcon: false,
							columnClass: 'col-md-offset-2 col-md-8',
							content: `<div class="panel panel-body">
										  <form id="formRestPassw">
											<div class="row">
												<div class="col-md-6" id="div_nickname">
													<div class="form-group">
													  <label for="nickname">Nikename:</label>
													  <input type="text" class="form-control text-dark bg-white" id="nikename" name="nikename" placeholder="Ingresar Nickname registrado."/>
													</div>
												</div>
												<div class="col-md-6" id="div_email" style="display: none;">
													<div class="form-group">
													  <label for="correo_electronico">Correo Electronico:</label>
													  <input type="text" class="form-control text-dark bg-white" id="correo_electr" name="correo_electr" placeholder="Ingresar Correo Electronico registrado."/>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
													  <label class="d-block">Opciones</label>
													  <div class="form-check form-check-inline" style="margin-top: 15px;">
														<input class="form-check-input checked" type="radio" id="NickName" name="opciones_rest" value="si" checked>
														<label class="form-check-label" for="opcionSi">Nickname</label>
													  </div>
													  <div class="form-check form-check-inline" style="margin-top: 15px;">
														<input class="form-check-input" type="radio" id="CorreoElect" name="opciones_rest" value="no">
														<label class="form-check-label" for=<"opcionNo">Correo Electronico</label>
													  </div>
													</div>
												</div>
											</div>
										  </form>
										</div>`,
								buttons: {
									cancelar: {
										text: 'Cancelar',
										btnClass: 'btn btn-warning',
										action: function(ModalCerrar){
										}
									},
									ObtenerCod: {
												text: 'Obtener Codigo',
												btnClass: 'btn btn-primary',
												action: function(saveButton){
													$('#formRestPassw').bootstrapValidator().submit();
													return false;
												}
											}
								},
								onContentReady: function (){
									$("#CorreoElect").click(function () {
										$("#div_nickname").hide();
										$("#div_email").show();
									});
									$("#NickName").click(function () {
										$("#div_nickname").show();
										$("#div_email").hide();
									});
									
									$('#formRestPassw').bootstrapValidator({
															excluded: [":disabled", ":hidden", ":not(:visible)"],
															message: 'Este Valor no es Valido',
															feedbackIcons: {
																valid: 'glyphicon glyphicon-ok',
																invalid: 'glyphicon glyphicon-remove',
																validating: 'glyphicon glyphicon-refresh'
															},      
															fields: {
																nikename: {
																			validators: { 
																							notEmpty: {
																										message: 'El Nickname no puede estar vacio.'
																										}
																						}
																},
																correo_electr: {
																	validators: { 
																					notEmpty: {
																								message: 'El Correo Electronico no puede estar vacio.'
																								}
																				}
																},
															}
														}).on('success.form.bv', function(e) {
																								e.preventDefault();   
																								var $form = $(e.target);
																								var bv = $form.data('bootstrapValidator');
																								requesitos( "POST", 
																											"../peticiones_json/GestionHumana/Vacaciones_json.php", 
																											"opcion=InsertProgramacion&" + $form.serialize() + "&jsonp=?", 
																											function(data){
																												programaVaca.buttons.guardar.enable();
																												
																												if(data["ALERTA"] == 'NOT'){
																													var errorm = $(`<p id="mensaje">${data["MENSAJE"]}</p>`);
																													$("#mensaje").replaceWith(errorm);
																													$("#alerta_error").show();
																												}else{
																													programaVaca.close();
																													$('#modal').modal({
																																		backdrop:'static',
																																		keyboard: false
																																	});
																													$('#modal').modal('show');
																													$("#div_close").show();
																													var titulo = $(`<h5 class="modal-title" id="TituloModal" style="font-size: 24px; color: white;">Notificación</h5>`);
																													$("#TituloModal").replaceWith(titulo);
																													var mensaje = $(`<div class="modal-body" id="MensajeModal" color: black; font-size: 17px;">${data["MENSAJE"]}</div>`);
																													$("#MensajeModal").replaceWith(mensaje);
																													var botones = $(`<div class="modal-footer" id="div_close" style="padding: 14px;">
																																		<button type="button" id="OK" class="btn btn-sm" style="color:white; background-color: #002060; width: 14%;">OK</button>
																																	</div>`);
																													$("#div_close").replaceWith(botones);
																													$("#OK").click(function(){
																														$('#modal').modal('hide');
																														ActualizarDatosTB();
																													});
																												}
																											}, 
																											"", 
																											Array()
																										);
																								$form
																									.bootstrapValidator('disableSubmitButtons', false);
																							});
									}
						});
					}
				}
				
				function accionModal(tipo_mod, titu, conte, botons, accion) {
					if(accion == 'abrir'){
						$('#modalAcciones').modal('show');
					}else
					{
						$('#modalAcciones').modal('hide');
					}
				}
				
				function toastNotifi(tipo_noti, titu, conte, botons, accion) {
					if(accion == 'cerrar')
					{
						ToaNotifi.hide();
					}
					if(accion == 'abrir')
					{
						if(tipo_noti == 'ERROR')
						{
							var cabecera = $(`<div class="toast-header" id="cabeceraToast" style="background-color: #E4080A;">
												<h4 class="me-auto fs-6" style="color: #FFFFFF;"><strong>${titu}</strong></h4>
												<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
											</div>`);
							$("#cabeceraToast").replaceWith(cabecera);
							var contenido = $(`<div class="toast-body" id="contenidoToast">
													${conte}
													<div class="progress mt-2">
													  <div id="myProgressBar" style="background-color: #E4080A;" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>`);
							$("#contenidoToast").replaceWith(contenido);
							ToaNotifi.show();
							ToaNotifi._element.addEventListener('shown.bs.toast', function () {
								startProgressBar();
							});
						}
						if(tipo_noti == 'NOTI'){
							var cabecera = $(`<div class="toast-header" id="cabeceraToast" style="background-color: #09A1FF;">
												<h4 class="me-auto fs-6" style="color: #FFFFFF;"><strong>${titu}</strong></h4>
												<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Cerrar"></button>
											</div>`);
							$("#cabeceraToast").replaceWith(cabecera);
							var contenido = $(`<div class="toast-body" id="contenidoToast">
													${conte}
													<div class="progress mt-2">
													  <div id="myProgressBar" style="background-color: #09A1FF;" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												</div>`);
							$("#contenidoToast").replaceWith(contenido);
							ToaNotifi.show();
							ToaNotifi._element.addEventListener('shown.bs.toast', function () {
								startProgressBar();
							});
						}
					}
				}
			</script>
		</body>
	</html>