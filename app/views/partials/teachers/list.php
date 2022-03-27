
<?php
$comp_model = new SharedController;

//Page Data From Controller
$view_data = $this->view_data;

$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = Router :: $field_name;
$field_value = Router :: $field_value;

$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>

<section class="page">

    <?php
    if ($show_header == true) {
        ?>
        <div  class="bg-light py-2 mb-3">
            <div class="">
                <div class="row ">
                    <div class="col-sm-1 comp-grid">
                        <a  class="btn btn btn-primary btn-block" href="<?php print_link("teachers/add") ?>">
                            <i class="fas fa-plus"></i>                              
                            New
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    ?>

    <div class="row ">

        <div class="col-md-12 comp-grid">

            <div  class="card animated fadeIn">
                <div id="users-list-records">
                    <?php $this :: display_page_errors(); ?>


                    <?php
                    if (!empty($records)) {
                        ?>
                        <div class="page-records table-responsive">
                            <table class="table  table-striped table-sm">
                                <thead class="table-header bg-light">
                                    <tr>
                                        <th class="td-sno td-checkbox"><input class="toggle-check-all" type="checkbox" /></th>

                                        <th class="td-sno">#</th>
                                        <th > Name</th>
                                        <th > Surname</th>
                                        <th > Username</th>
                                        <th > Email Address</th>
                                        <th > Role</th>
                                        <th > Created</th>
                                        <th > Last Modified</th>
                                        <th class="td-btn"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $counter = 0;
                                    foreach ($records as $data) {
                                        $counter++;
                                        ?>
                                        <tr>

                                            <th class=" td-checkbox">
                                                <label>
                                                    <input class="optioncheck" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                                                </label>
                                            </th>

                                            <th class="td-sno"><?php echo $counter; ?></th>
                                            <td> <?php echo $data['name']; ?> </td>
                                            <td> <?php echo $data['surname']; ?> </td>
                                            <td> <?php echo $data['user_name']; ?> </td>
                                            <td> <?php echo $data['user_email']; ?> </td>
                                            <td> <?php echo $data['role']; ?> </td>
                                            <td> <?php echo $data['created']; ?> </td>
                                            <td> <?php echo $data['modified']; ?> </td>
                                            <th class="td-btn">


                                                <a class="btn btn-sm btn-success has-tooltip" title="<?php print_lang('btn_view_tooltip'); ?>" href="<?php print_link('teachers/view/' . $data['id']); ?>">
                                                    <i class="fa fa-eye"></i> <?php print_lang('empty_record_prompt'); ?>
                                                </a>


                                                <a class="btn btn-sm btn-info has-tooltip" title="<?php print_lang('btn_edit_tooltip'); ?>" href="<?php print_link('teachers/edit/' . $data['id']); ?>">
                                                    <i class="fa fa-edit"></i> <?php print_lang('empty_record_prompt'); ?>
                                                </a>


                                                <a class="btn btn-sm btn-danger recordDeletePromptAction has-tooltip" title="<?php print_lang('btn_delete_tooltip'); ?>" href="<?php print_link("teachers/delete/$data[id]"); ?>" >
                                                    <i class="fa fa-times"></i>
                                                    <?php print_lang('empty_record_prompt'); ?>
                                                </a>


                                            </th>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <?php
                        if ($show_footer == true) {
                            ?>
                            <div class="card-footer">
                                <?php
                                if ($show_pagination == true) {
                                    $pager = new Pagination($total_records, $record_count);
                                    $pager->page_name = 'users';
                                    $pager->show_page_count = true;
                                    $pager->show_record_count = true;
                                    $pager->show_page_limit = true;
                                    $pager->show_page_number_list = true;
                                    $pager->pager_link_range = 5;

                                    $pager->render();
                                }
                                ?>

                            </div>
                            <?php
                        }
                    } else {
                        $this->addNoDataFoundMsg("No records found", "text-muted animated bounce");
                    }
                    ?>

                </div>
            </div>

        </div>

    </div>
</section>
