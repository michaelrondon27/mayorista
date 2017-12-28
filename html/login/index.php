<!DOCTYPE html>
<html>
 	<head>
    	<meta charset="UTF-8">
    	<!-- ICONO EN LA PESTAÑA -->
    	<link rel="shortcut icon" href="<?php echo ICON;?>">
    	<title><?php echo APP_TITLE;?></title>
    	<base href="<?php echo APP_URL;?>">
        <link rel="stylesheet" href="views/app/css/login.css">
        <link rel="stylesheet" href="views/bootstrap/css/bootstrap.css">
        <script src='views/web/assets/jquery/jquery.min.js'></script>
        <script src="views/app/js/index.js"></script>
        <script src='views/bootstrap/js/bootstrap.min.js'></script>
	</head>
	<body>
    	<div class="wrapper">
			<div class="container">
				<h1 style="color: white;">Sistema de Cotización Comersso</h1>
				<img src="<?php echo LOGO;?>" width="20%">
				<form action="login.php" method="post" class="form">
					<input type="text" name="user" placeholder="USUARIO">
					<input type="password" name="pass" placeholder="CONTRASEÑA">
					<button type="submit" id="login-button">Iniciar Sesión</button>
				</form>
			</div>
			<ul class="bg-bubbles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
			<footer style="color: white;"><?php echo APP_COPY;?></footer>
			<?php
				if(isset($_GET['error'])){
					if($_GET['error']==1){
						?>
							<div class="container">
								<div class="alert alert-dismissible alert-danger">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>ERROR:</strong>Usuario o contraseña incorrecta.
								</div>
							</div>
						<?php
					}else if($_GET['error']==2){
						?>
							<div class="container">
								<div class="alert alert-dismissible alert-danger">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>ERROR:</strong>Todos los datos deben estar llenos.
								</div>
							</div>
						<?php
					}
					else if($_GET['error']==3){
						?>
							<div class="container">
								<div class="alert alert-dismissible alert-danger">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<strong>ERROR:</strong>Su usuario se encuentra bloqueado del sistema.
								</div>
							</div>
						<?php
					}
				}
			?>
		</div>
	</body>
</html>
