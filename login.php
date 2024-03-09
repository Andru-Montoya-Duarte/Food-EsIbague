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
											<a href="#" style="color: #fff" data-bs-toggle="modal" data-bs-target="#exampleModal">Olvide mi contraseña</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <div class="modal-body">
					...
				  </div>
				  <div class="modal-footer" id="botones">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				  </div>
				</div>
			  </div>
			</div>
			<script src="./includes/Librerias/Jquery/jquery-3.7.1.min.js"></script>
			<script src="./includes/js/popper.js"></script>
			<script src="./includes/Librerias/bootstrap/js/bootstrap.min.js"></script>
			<script src="./includes/Librerias/bootstrap_validation/js/bootstrapValidator.min.js"></script>
			<script src="./includes/js/main.js"></script>
			<script type="text/javascript">
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
				
				function modal(titu, conte, botons, accion) {
					if(accion == 'abrir'){
						$('#modal').modal('show');
						var titulo = $(titu);
						$("#alerta").replaceWith(mensajeError);
						var contenido = $(conte);
						$("#alerta").replaceWith(mensajeError);
						var botones = $(botons);
						$("#alerta").replaceWith(mensajeError);
					}
					if(accion == 'cerrar'){
						$('#modal').modal('hide');
					}
				}
			</script>
		</body>
	</html>