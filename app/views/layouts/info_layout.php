<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="shortcut icon" href="<?php print_link(SITE_FAVICON); ?>" />
		<title><?php echo $this->get_page_title();; ?></title>
		<?php 
			Html ::  page_meta('theme-color',META_THEME_COLOR);
			Html ::  page_meta('author',META_AUTHOR); 
			Html ::  page_meta('keyword',META_KEYWORDS); 
			Html ::  page_meta('description',META_DESCRIPTION); 
			Html ::  page_meta('viewport',META_VIEWPORT);
			Html ::  page_css('font-awesome.css');
			Html ::  page_css('animate.css');
		?>
				<?php 
			Html ::  page_css('bootstrap-theme-pulse-darkblue-no-round.css');
			Html ::  page_css('custom-style.css');
                        Html ::  page_css('bootstrap-custom.css');
		?>
		<?php
			Html ::  page_js('jquery-2.2.0.min.js');
		?>
	</head>
	
	<body>
		<?php 
			Html ::  page_header(); 
		?>
		<div id="main-content" class="mt-4">
			<div id="page-content">
				<?php $this->render_body();?>
			</div>
			<?php 
				Html ::  page_footer(); 
			?>
		</div>
		<?php 
			Html ::  page_js('popper.js');
			Html ::  page_js('bootstrap.js');
		?>
            <script type="text/javascript">
                function fixBodyPadding() {
                    var winHeight = $(window).height();
                    var navTopHeight = $('#main-nav').outerHeight();
                    document.body.style.paddingTop = navTopHeight + 'px';
                }

                $(function(){
                    fixBodyPadding();
                });

                $(window).resize(fixBodyPadding);
            </script>
	</body>
</html>