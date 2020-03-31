<?php
/* For licensing terms, see /license.txt */
/**
 * Redirect script.
 *
 * @package chamilo.custompages
 */
require_once api_get_path(SYS_PATH).'main/inc/global.inc.php';
require_once __DIR__.'/language.php';

/**
 * Homemade micro-controller.
 */
if (isset($_GET['loginFailed'])) {
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case 'account_expired':
                $error_message = custompages_get_lang('AccountExpired');
                break;
            case 'account_inactive':
                $error_message = custompages_get_lang('AccountInactive');
                break;
            case 'user_password_incorrect':
                $error_message = custompages_get_lang('InvalidId');
                break;
            case 'access_url_inactive':
                $error_message = custompages_get_lang('AccountURLInactive');
                break;
            default:
                $error_message = custompages_get_lang('InvalidId');
        }
    } else {
        $error_message = get_lang('InvalidId');
    }
}

$rootWeb = api_get_path('WEB_PATH');

/**
 * HTML output.
 */
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
<!--    <link rel="stylesheet" type="text/css" href="<?php /*echo $rootWeb; */?>custompages/assets/js/vegas/vegas.css" />
-->
    <script type="text/javascript" src="<?php echo $rootWeb; ?>web/assets/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $rootWeb; ?>web/assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!--    <script type="text/javascript" src="<?php /*echo $rootWeb; */?>custompages/assets/js/vegas/vegas.js"></script>
    <script type="text/javascript" src="<?php /*echo $rootWeb; */?>custompages/assets/js/main.js"></script>-->
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
                <img src="<?php echo $rootWeb; ?>custompages/assets/img/logo.svg" class="logo" width="300px"/>
            </a>
        </div>
        <div class="panel panel-default form-signin">
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
                    <div class="col-md-6">
                        <div class="padding-login">
                            <form id="login-form" action="<?php echo api_get_path(WEB_PATH); ?>index.php" method="post">
                                <div class="section-title-container">
                                    <h2 class="section-title">Acceso Aula Virtual</h2>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="user" name="login" placeholder="<?php echo custompages_get_lang('User'); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo custompages_get_lang('Password'); ?>">
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    <?php echo custompages_get_lang('LoginEnter'); ?>
                                </button>
                                <?php if (api_get_setting('allow_registration') === 'true') { ?>
                                    <a href="<?php echo api_get_path(WEB_CODE_PATH); ?>auth/inscription.php?language=<?php echo api_get_interface_language(); ?>" class="btn btn-default btn-block" >
                                        <?php echo custompages_get_lang('Registration'); ?>
                                    </a >
                                <?php } ?>
                                <div class="last-password">
                                    <a href="<?php echo api_get_path(WEB_CODE_PATH); ?>auth/lostPassword.php?language=<?php echo api_get_interface_language(); ?>">
                                        <?php echo custompages_get_lang('LostPassword'); ?>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="image-login">
                            <img class="img-responsive" src="<?php echo $rootWeb; ?>custompages/assets/img/img_login.png"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="help">
            <ul>
                <li>Por razones de seguridad, no olvide cerrar la sesión, incluso antes de cerrar el navegador.</li>
            </ul>
        </div>
    </div> <!-- /container -->
</body>
</html>
