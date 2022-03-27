<?php
$page_name = Router :: get_page_name();
$page_action = Router :: get_page_action();
$page_id = Router :: get_page_id();

$body_class = "$page_name-" . str_ireplace('index', 'list', $page_action);
$page_title = $this->get_page_title();
$comp_model = new SharedController();
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title; ?></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php print_link(SITE_FAVICON); ?>" />
        <?php
        Html :: page_meta('theme-color', META_THEME_COLOR);
        Html :: page_meta('author', META_AUTHOR);
        Html :: page_meta('keyword', META_KEYWORDS);
        Html :: page_meta('description', META_DESCRIPTION);
        Html :: page_meta('viewport', META_VIEWPORT);

        Html :: page_css('flatpickr.min.css');
        Html :: page_css('bootstrap-default.css');
        Html :: page_css('sb-admin.css');
        Html :: page_css('font-awesome.min.css');
        Html :: page_css('datatables.min.css');
        Html :: page_css('select2.min.css');
        Html :: page_css('animate.css');
        Html :: page_css('custom-style.css');

        Html :: page_js('jquery-2.2.0.min.js');
        Html :: page_js('jquery.form.min.js');
        Html :: page_js('angular.min.js');
        Html :: page_js('angular-reset-on.min.js');
        Html :: page_js('select2.min.js');
        Html :: page_js('ui-bootstrap-custom-tpls-2.5.0.min.js');
        Html :: page_js('NumberFormat154.js');
        Html :: page_js('common.js');
        
        if ($page_name == 'report') {
            Html :: page_js('highcharts/highcharts.js');
            Html :: page_js('highcharts/data.js');
            Html :: page_js('highcharts/export-data.js');
            Html :: page_js('highcharts/exporting.js');
            Html :: page_js('highcharts/accessibility.js');
        }
        ?>
    </head>
    <body id="page-top" ng-app="007App">
        <div class="se-pre-con"></div>
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                    <div class="sm-screen-logo">
                        <img src="<?= SITE_ADDR . SITE_LOGO_SIGN_ONLY ?>" alt="Logo" />
                    </div>
                    <div class="lg-screen-logo">
                        <img src="<?= SITE_ADDR . SITE_LOGO ?>" alt="Logo" />
                    </div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                    <a class="nav-link" href="<?= SITE_ADDR?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">
                
                <?php
                    if (USER_ROLE == UserRole::admin) {
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= SITE_ADDR ?>subjects">
                        <i class="fas fa-book"></i> <span>Manage Subjects</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= SITE_ADDR ?>schools">
                        <i class="fas fa-book"></i> <span>Manage Schools</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= SITE_ADDR ?>learners">
                        <i class="fas fa-book"></i> <span>Manage Learners</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= SITE_ADDR ?>teachers">
                        <i class="fas fa-book"></i> <span>Manage Teachers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#configs" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-cogs"></i> <span>Configuration</span>
                    </a>
                    <div id="configs" class="collapse <?= isActiveController(array("users", "core"), $page_name) ?>" data-parent="#accordionSidebar" style="">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="<?= SITE_ADDR ?>core/basic_configuration">System Config</a>
                            <a class="collapse-item" href="<?= SITE_ADDR ?>users/">Users</a>
                        </div>
                    </div>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#my-subjects" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-book-open"></i> <span>My Subjects</span>
                    </a>
                    <div id="my-subjects" class="collapse <?= isActiveController(array("index", "core"), $page_name) ?>" data-parent="#accordionSidebar" style="">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <?php
                                $subjects = $comp_model->getUserSubjects();
                                
                                foreach ($subjects as $subject) {
                                    echo '<a class="collapse-item" href="' . SITE_ADDR . 'index/workspace/' . $subject['id'] . '">' . $subject['name'] . '</a>';
                                }
                            
                            ?>
                        </div>
                    </div>
                </li>
                <?php }  ?>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fas fa-bars"></i>
                    </button>

                    <h3 style="width: 60%;">
                        <?php echo $page_title; ?>
                    </h3>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"  method="get" action="">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small search-field" placeholder="Search for..."
                                   aria-label="Search" aria-describedby="basic-addon2" name="search" value="<?= (!empty($_GET['search']) ? $_GET['search'] : '') ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                                <button class="btn btn-secondary" type="reset" onclick="$('.search-field').val(''); $('.navbar-search').submit();"> 
                                    <i class="fas fa-times fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                 aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search" method="get" action=""> 
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small search-field"
                                               placeholder="Search for..." aria-label="Search"
                                               aria-describedby="basic-addon2" name="search" value="<?= (!empty($_GET['search']) ? $_GET['search'] : '') ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                            <button class="btn btn-secondary" type="reset" onclick="$('.search-field').val(''); $('.navbar-search').submit();"> 
                                                <i class="fas fa-times fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo ucwords(USER_NAME); ?>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php print_link('info/logout?csrf_token=' . Csrf::$token) ?>"><i class="fas fa-sign-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Main Content -->
                <div id="content">
                    <!-- Page Main Content Start -->
                    <div id="app-body">
                        <div class="container-fluid">
                            <div class="flash-msg-container"><?php show_flash_msg(); ?></div>
                        </div>
                        <div class="m-2">
                            <div  class="card animated fadeIn">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-xs-12 comp-grid">
                                            <?php $this->render_body(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <div class="copyright">All rights reserved. &copy; <?= date('Y') . ' ' . SITE_NAME ?></div>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
        </div>

        <div id="ajax-modal" class="modal fade-scale" tabindex="-1" style="display: none;"></div>
        <script type="text/javascript">
            var siteAddr = '<?= SITE_ADDR ?>';
        </script>
        <?php
        Html :: page_js('popper.js');
        Html :: page_js('bootstrap.js');
        Html :: page_js('flatpickr.min.js');
        Html :: page_js('datatables.min.js');
        Html :: page_js('metisMenu.js');
        Html :: page_js('plugins.js');
        Html :: page_js('script.js?ts=' . time());
        Html :: page_js('angular-app.js?ts=' . time());
        ?>
    </body>
</html>
