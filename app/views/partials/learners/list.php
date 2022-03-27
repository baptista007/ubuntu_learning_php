
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
                        <a  class="btn btn btn-primary btn-block" href="<?php print_link("learners/add") ?>">
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

    <div  class="">
        <div class="">

            <div class="row ">

                <div class="col-md-12 comp-grid">

                    <?php $this :: display_page_errors(); ?>

                    <div  class="card animated fadeIn">
                        <div id="clients-list-records">

                            <?php
                            if (!empty($records)) {
                                ?>
                                <div class="page-records table-responsive">
                                    <table class="table  table-striped table-sm">
                                        <thead class="table-header bg-light">
                                            <tr>
                                                <th class="td-sno td-checkbox"><input class="toggle-check-all" type="checkbox" /></th>
                                                <th class="td-sno">#</th>
                                                <th>Name</th>
                                                <th>DOB</th>
                                                <th>School</th>
                                                <th>Grade</th>
                                                <th>Cellphone</th>
                                                <th>Created</th>
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
                                                    <td><a href="<?php print_link("learners/view/$data[id]") ?>"><?php echo $data['name']; ?></a></td>
                                                    <td> <?= human_date($data['dob']) ?> </td>
                                                    <td> <?= $this->addTdContSafe('school_id', $data, $comp_model->schools_value_name()) ?> </td>
                                                    <td> <?php echo $data['grade']; ?> </td>
                                                    <td> <?php echo $data['cellphone']; ?> </td>
                                                    <td> <?php echo $data['created']; ?> </td>
                                                    <th class="td-btn">
                                                        <a class="btn btn-sm btn-success has-tooltip" title="<?php print_lang('view_record'); ?>" href="<?php print_link('learners/view/' . $data['id']); ?>">
                                                            <i class="fa fa-eye"></i> <?php print_lang(''); ?>
                                                        </a>
                                                        <a class="btn btn-sm btn-info has-tooltip" title="<?php print_lang('edit_this_record'); ?>" href="<?php print_link('learners/edit/' . $data['id']); ?>">
                                                            <i class="fa fa-edit"></i> <?php print_lang(''); ?>
                                                        </a>
                                                        <a class="btn btn-sm btn-danger recordDeletePromptAction has-tooltip" title="<?php print_lang('delete_this_record'); ?>" href="<?php print_link("clients/delete/$data[id]"); ?>" >
                                                            <i class="fa fa-times"></i>
                                                            <?php print_lang(''); ?>
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
                                        <div class="row">   
                                            <div class="col">   

                                                <?php
                                                if ($show_pagination == true) {
                                                    $pager = new Pagination($total_records, $record_count);
                                                    $pager->page_name = 'clients';
                                                    $pager->show_page_count = true;
                                                    $pager->show_record_count = true;
                                                    $pager->show_page_limit = true;
                                                    $pager->show_page_number_list = true;
                                                    $pager->pager_link_range = 5;

                                                    $pager->render();
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="text-muted animated bounce">
                                    <h4><i class="fa fa-ban"></i> <?php print_lang(''); ?></h4>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</section>
