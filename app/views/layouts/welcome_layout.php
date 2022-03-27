<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Ubuntu Learning - Welcome</title>

      <!-- Latest compiled and minified CSS -->
      <?php
        Html :: page_meta('theme-color', META_THEME_COLOR);
        Html :: page_meta('author', META_AUTHOR);
        Html :: page_meta('keyword', META_KEYWORDS);
        Html :: page_meta('description', META_DESCRIPTION);
        Html :: page_meta('viewport', META_VIEWPORT);

        Html :: page_css('bootstrap-default.css');
        Html :: page_css('animate.css');
        Html :: page_css('welcome.css');

        Html :: page_js('jquery-2.2.0.min.js');
        Html :: page_js('common.js');
        ?>
   </head>
      <header class="header-bottom active">
         <div class="container-fluid">
            <div class="header-wrapper">
               <div class="logo">
                  <a href="/">
                     <img src="<?= SITE_ADDR ?>assets/images/ubuntu-logo-sm.png" class="c-sidebar-brand-full" alt="Logo" />
                  </a>
               </div>
               <!--
               <div class="system-header">
                  <h4>
                     Ubuntu Learning
                  </h4>
               </div>
               -->
               <ul class="menu ml-auto">
                  <li>
                     <a href="<?= SITE_ADDR ?>">
                           Home
                     </a>
                  </li>
                  <li>
                     <a href="<?= SITE_ADDR ?>info/about">
                           About
                     </a>
                  </li>
                  <li>
                     <a href="<?= SITE_ADDR ?>info/contact">
                           Contact
                     </a>
                  </li>
               </ul>
               <div class="right">
                    <a class="custom-button" href="<?= SITE_ADDR ?>index">
                        Access portal                
                    </a>
               </div>
            </div>
         </div>
      </header>
      <section class="center-content">
         <main class="container-fluid">
               <!-- Flash messages -->
               <div class="flash-msg-container">
                  
               </div>

               <div class="">
                  <div class="fade-in">
                     <?php $this->render_body(); ?>
                  </div>
               </div>
         </main>
      </section>

      <section class="our-partners bg-light">
            <section class="container">
                <div class="text-center">
                    <h2 class="mb-3 color-logo-text">
                        Our Sponsors
                    </h2>
                    <div class="partner-items">
                        <div class="partner-card">
                            <div class="card-body">
                                <a href="https://www.dundeeprecious.com/English/Careers/Namibia/default.aspx" target="_blank">
                                    <img class="logo" src="<?= SITE_ADDR ?>assets/images/partners/ClientLogo.png"> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
      </section>

      <section class="our-partners">
            <section class="container">
                <div class="text-center">
                    <h2 class="mb-3 color-logo-text">
                        Our Strategic Partners
                    </h2>
                    <div class="strategic-partner-items">
                        <div class="partner-card">
                            <div class="card-body">
                                <a href="http://www.moe.gov.na/" target="_blank">
                                    <img class="logo" src="<?= SITE_ADDR ?>assets/images/partners/na-coat-of-arms.png"> 
                                </a>
                                <p class="card-text">
                                    Ministry of Education, Arts, & Culture
                                </p>
                            </div>
                        </div>
                        <div class="partner-card">
                            <div class="card-body">
                                <a href="http://www.moe.gov.na/" target="_blank">
                                    <img class="logo" src="<?= SITE_ADDR ?>assets/images/partners/na-coat-of-arms.png"> 
                                </a>
                                <p class="card-text">
                                    Ministry of Information and Communication Technology
                                </p>
                            </div>
                        </div>
                        <div class="partner-card">
                            <div class="card-body">
                                <a href="http://www.moe.gov.na/" target="_blank">
                                    <img class="logo" src="<?= SITE_ADDR ?>assets/images/partners/na-coat-of-arms.png" /> 
                                </a>
                                <p class="card-text">
                                    Ministry of Higher Education Training and Innovation 
                                </p>
                            </div>
                        </div>
                        <div class="partner-card">
                            <div class="card-body">
                                <a href="http://www.moe.gov.na/" target="_blank">
                                    <img class="logo" src="<?= SITE_ADDR ?>assets/images/partners/nied-logo.png" /> 
                                </a>
                                <p>
                                    National Institute for Educational Development
                                </p>
                            </div>
                        </div>
                        <div class="partner-card">
                            <div class="card-body">
                                <a href="http://www.moe.gov.na/" target="_blank">
                                    <img class="logo" src="<?= SITE_ADDR ?>assets/images/partners/nyc.png" /> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
      </section>

      <section class="footer-content">
            <div class="footer-top">
                <div class="footer-overlay">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 col-xs-12 text-center">
                                <div class="footer-widget widget-follow">
                                    <h5 class="title">
                                        Help and FAQ
                                    </h5>
                                    <ul class="links-list">
                                        <li>
                                            <a href="/info/faq">FAQ</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12 text-center">
                                <div class="footer-widget widget-follow">
                                    <h5 class="title">
                                        Our Contact Details
                                    </h5>
                                    <ul class="links-list">
                                        <li>
                                            <a href="#0">
                                                <i class="fa fa-phone-alt"></i>+264 (81) 488 8886
                                            </a>
                                        </li>
                                        <li>
                                            <a href="mailto:support@ubuntu-learning.com">
                                                <i class="fa fa-envelope-open-text"></i> support@ubuntu-learning.com
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container-fluid">
                    <div class="copyright-area">
                        <div class="row footer-bottom-wrapper">
                            <div class="col-lg-3 col-xs-12">
                                 <img src="<?= SITE_ADDR ?>assets/images/ubuntu-logo-sm.png" class="c-sidebar-brand-full" alt="Logo" />
                            </div>
                            <div class="col-lg-6 col-xs-12 text-center">
                                <div class="text-white">
                                    &copy; Copyright <?= date('Y') ?> Ubuntu Learning. All rights reserved.
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
   </section>
   <div id="preloader"></div>
   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
   <?= Html :: page_js('bootstrap.js'); ?>
   <?= Html :: page_js('info.js'); ?>
</html>