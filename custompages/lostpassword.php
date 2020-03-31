<?php
/* For licensing terms, see /license.txt */
/**
 * Quick form to ask for password reminder.
 *
 * @package chamilo.custompages
 */
require_once api_get_path(SYS_PATH).'main/inc/global.inc.php';
require_once __DIR__.'/language.php';

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
<!--    <link rel="stylesheet" type="text/css" href="<?php /*echo $rootWeb; */?>custompages/assets/js/vegas/vegas.css" />
-->
    <script type="text/javascript" src="<?php echo $rootWeb; ?>web/assets/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $rootWeb; ?>web/assets/bootstrap/dist/js/bootstrap.min.js"></script>

<!--    <script type="text/javascript" src="<?php /*echo $rootWeb; */?>custompages/assets/js/vegas/vegas.js"></script>
<!---->    <script type="text/javascript" src="<?php /*echo $rootWeb; */?>custompages/assets/js/main.js"></script>
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
        <div class="panel panel-default form-lost-password">
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
                        <div class="padding-login">
                            <div class="section-title-container">
                                <h2 class="section-title"><?php echo custompages_get_lang('LostPassword'); ?></h2>
                            </div>
                            <?php
                            echo isset($content['form']) ? $content['form'] : '';
                            ?>
                        </div>
                    </div>
                    <!--<div class="col-md-4">
                        <img src="<?php /*echo $rootWeb; */?>custompages/assets/img/password.svg"/>
                    </div>-->
                </div>

            </div>
        </div>
    </div> <!-- /container -->
</body>
</html>
