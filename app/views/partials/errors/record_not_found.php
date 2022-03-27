<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section>
    <div  class="">
        <div  class="p-3 animated fadeIn page-content">
            <div>
                <?php $this :: display_page_errors(); ?>
            </div>
        </div>
        <div class="text-center">
            <a href="<?php print_link(HOME_PAGE); ?>" class="btn btn-primary"><?= get_lang('go_to_home_page') ?></a>
        </div>
    </div>
</section>