<?php
$page_name = Router :: get_page_name();
$page_action = Router :: get_page_action();
$page_id = Router :: get_page_id();

$body_class = "$page_name-" . str_ireplace('index', 'list', $page_action);
$page_title = $this->get_page_title();
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title; ?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="shortcut icon" href="<?php print_link(SITE_FAVICON); ?>" />
        <?php
            Html :: page_meta('theme-color', META_THEME_COLOR);
            Html :: page_meta('author', META_AUTHOR);
            Html :: page_meta('keyword', META_KEYWORDS);
            Html :: page_meta('description', META_DESCRIPTION);
            Html :: page_meta('viewport', META_VIEWPORT);
            Html :: page_css('font-awesome.css');
            Html :: page_css('animate.css');
            Html :: page_css('bootstrap-default.css');
            Html :: page_css('sb-admin.css');
            Html :: page_css('custom-style.css');
            Html :: page_css('flatpickr.min.css');
            Html :: page_css('metisMenu.css');
            Html :: page_js('jquery-2.2.0.min.js');
            Html :: page_js('jquery.form.min.js');
            Html :: page_js('common.js');
        ?>
    </head>
    <body class="login">
        <div class="container-fluid">
            <!-- Page Main Content Start -->
            <div id="page-content">
                <div class="text-center mb-4">
                  <div class="mb-4 text-center">
                    <a href="/">
                      <img src="<?= SITE_ADDR ?>assets/images/ubuntu-logo.png" />
                    </a>
                  </div>
                </div>
                <?php $this->render_body(); ?>
            </div>	
            <!-- Page Main Content [End] -->
            <div class="flash-msg-container"><?php show_flash_msg(); ?></div>
        </div>
        <script>
            var siteAddr = '<?php echo SITE_ADDR; ?>';
            var defaultPageLimit = <?php echo MAX_RECORD_COUNT; ?>;
        </script>
        <?php
            Html :: page_js('popper.js');
            Html :: page_js('bootstrap.js');
            Html :: page_js('flatpickr.min.js');
            Html :: page_js('metisMenu.js');
            Html :: page_js('plugins.js');
            Html :: page_js('script.js');
        ?>
    </body>
</html>