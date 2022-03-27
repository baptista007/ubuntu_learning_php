
<div class="container-fluid">
	<h4>Select your language</h4>
	<hr />
	<div class="row">
            <div class="col-lg-12">
		<?php 
			$files = glob(LANGS_DIR . "*.ini");
			foreach ($files as $file) {
				$langname = pathinfo($file, PATHINFO_FILENAME);;
				?>
					<a class="btn btn-secondary btn-lg mr-5" href="<?php print_link("info/change_language/$langname") ?>">
						
						<?php echo ucfirst($langname); ?>
						
					</a>
				<?php
			}
		?>
            </div>
	</div>
</div>