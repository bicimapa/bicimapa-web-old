<?php 
include '../funciones.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>Bicimapa para iOS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Oleo+Script:400,700'>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="logo span4">
                        <h1><a href="">Bicimapa para iOS</a></h1>
                    </div>
                    <div class="links span8">
                        <a class="redessociales" href="https://www.facebook.com/BiciMapa"><img src="http://www.bicimapa.com/img/facebook.png"></a>
						<a class="redessociales" href="https://twitter.com/bicimapa"><img src="http://www.bicimapa.com/img/twitter.png"></a>
						<a class="redessociales" href="http://bit.ly/bicimapaApp"><img src="http://www.bicimapa.com/img/android.png"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                <div class="iphone span5">
                    <img src="https://www.googledrive.com/host/0Bxx88ySE8oUfb1BfbXFheWJVbXM/iphone.png" alt="">
                </div>
                <div class="register span6">
					
                    <form action="" method="post">
						<img src="http://www.bicimapa.com/img/apple.png"/>
						<h2>El mapa de ciclistas en la ciudad. &Uacute;salo, mej&oacute;ralo y comp&aacute;rtelo.</h2>
						
						<?php 

						if(isset($_POST['ok'])&&$_POST['ok']=='ok'){
							$correo=$_POST['correoele'];
							$info=$_SERVER['REMOTE_ADDR']." - ".$_SERVER['HTTP_USER_AGENT'];
							
							
							$link=Conectarse();
							
							$sql="INSERT INTO `notificacion_ios` (`id`, `correo`, `info`, `fecha`) VALUES (NULL, '".sanitize($correo)."', '".sanitize($info)."', CURRENT_TIMESTAMP)";
							
							if(mysql_query($sql,$link)){
								echo'<h3>Gracias! Te avisaremos cuando est&eacute; disponible.</h3>';
							}
							else{
								echo'<h3>Ocurri&oacute; un error guardando el correo :(</h3>';
							}
							mysql_close($link);
						}
						else{
							?>
							
						<h3>Recibir notificaci&oacute;n cuando est&eacute; disponible.</h3>
                        <label for="correoele">Correo Electr&oacute;nico</label>
                        <input type="text" id="email" name="correoele" placeholder="ingresa tu correo electr&oacute;nico...">
                        <input type="hidden" name="ok" value="ok">
                        <button type="submit">INSCRIBIRME</button>
                        
							<?php 
						}
						?>
                        <p><br/><br/><a href="http://www.bicimapa.com/">Regresar a Bicimapa.com</a></p>
                    </form>
                </div>
            </div>
        </div>
		
        <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>

    </body>

</html>

