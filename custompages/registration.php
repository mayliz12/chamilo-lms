<?php
/* For licensing terms, see /license.txt */
/**
 * This script allows for specific registration rules (see CustomPages feature of Chamilo)
 * Please contact CBlue regarding any licences issues.
 * Author: noel@cblue.be
 * Copyright: CBlue SPRL, 20XX (GNU/GPLv3).
 *
 * @package chamilo.custompages
 */
require_once api_get_path(SYS_PATH).'main/inc/global.inc.php';
require_once __DIR__.'/language.php';
/**
 * Removes some unwanted elementend of the form object.
 */
/*$content['form']->removeElement('extra_mail_notify_invitation');
$content['form']->removeElement('extra_mail_notify_message');
$content['form']->removeElement('extra_mail_notify_group_message');
$content['form']->removeElement('official_code');
$content['form']->removeElement('phone');
$content['form']->removeElement('submit');
if (isset($content['form']->_elementIndex['status'])) {
    $content['form']->removeElement('status');
    $content['form']->removeElement('status');
}*/
$content['form']->removeElement('official_code');
$content['form']->removeElement('phone');
$content['form']->removeElement('extra_rol_unico_tributario');
$content['form']->removeElement('extra_rut_factura');

$rootWeb = api_get_path('WEB_PATH');

?>
<!doctype html>
<html lang="es">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso al aula virtual</title>

    <link rel="icon" type="image/png" href="<?php echo $rootWeb; ?>custompages/assets/img/favicon.png" />
    <link rel="stylesheet" type="text/css" href="<?php echo $rootWeb; ?>web/assets/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $rootWeb; ?>web/assets/flag-icon-css/css/flag-icon.min.css" />

    <script type="text/javascript" src="<?php echo $rootWeb; ?>web/assets/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $rootWeb; ?>web/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo $rootWeb; ?>custompages/assets/css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i,900,900i&display=swap');
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="text-center">
    <div class="container">
        <div class="logo">
            <a href="<?php echo $rootWeb; ?>">
                <img src="<?php echo $rootWeb; ?>custompages/assets/img/logo.svg" width="300px"/>
            </a>
        </div>
        <div class="panel panel-default form-register">
            <div class="panel-body">
                <div class="message">
                    <?php
                        if (isset($content['info']) && !empty($content['info'])) {
                            echo '<div class="alert alert-info" role="alert">'.$content['info'].'</div>';
                        }

                        if (isset($error_message)) {
                            echo '<div id="login-form-info" class="alert alert-danger" role="alert">'.$error_message.'</div>';
                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title-container">
                            <h2 class="section-title">Registro de nuevo usuario</h2>
                        </div>
                        <div class="alert alert-info text-register">
                            Si ya tienes una cuenta, <a href="<?php echo $rootWeb; ?>">inicia sesión aquí</a> ó <a href="<?php echo $rootWeb; ?>main/auth/lostPassword.php?language=spanish2">¿Ha olvidado su contraseña?</a>
                        </div>
                        <?php
                            $content['form']->display();
                        ?>
                        <div class="custom_required">
                            * Esta información la utilizaremos para tu certificado de aprobación.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- /container -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#extra_rol_unico_tributario').bind('keypress', function (event) {

            var keyCode = event.keyCode || event.which
            // Don't validate the input if below arrow, delete and backspace keys were pressed
            if (keyCode == 8 || (keyCode >= 35 && keyCode <= 40)) { // Left / Up / Right / Down Arrow, Backspace, Delete keys
                return;
            }

            var regex = new RegExp("^[a-zA-Z0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('#extra_rut_factura').bind('keypress', function (event) {

            var keyCode = event.keyCode || event.which
            // Don't validate the input if below arrow, delete and backspace keys were pressed
            if (keyCode == 8 || (keyCode >= 35 && keyCode <= 40)) { // Left / Up / Right / Down Arrow, Backspace, Delete keys
                return;
            }

            var regex = new RegExp("^[a-zA-Z0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
</body>
</html>
