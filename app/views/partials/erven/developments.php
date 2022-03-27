
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
                        <a  class="btn btn btn-primary btn-block" href="<?php print_link("erven/manage_dev_cell") ?>">
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

    <div class="row">
        <div class="col-md-12 comp-grid">
            <?php $this :: display_page_errors(); ?>

            <div  class="card animated fadeIn">
                <?php
                if (!empty($records)) {
                    ?>
                    <div class="page-records table-responsive">
                        <table class="table  table-striped table-sm">
                            <thead class="table-header bg-light">
                                <tr>
                                    <th class="td-sno">VO Number</th>
                                    <th> Developer </th>
                                    <th> Number of erven </th>
                                    <th> Water Status </th>
                                    <th> Electricity Status </th>
                                    <th> Sewage Status</th>
                                    <th> Storm Water </th>
                                    <th> Provisional Roads</th>
                                    <th> Created </th>
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
                                        <td><a href="<?php print_link("erven/manage_dev_cell/{$data['id']}") ?>"><?php echo $data['vo_number']; ?></a></td>
                                        <td> <?php echo $data['developer']; ?> </td>
                                        <td> <?php echo $data['erven_count']; ?> </td>
                                        <td> <?php echo $this->addTdContSafe('water_status', $data, $comp_model->get_field_options_value_name(FieldOptions::service_status)); ?> </td>
                                        <td> <?php echo $this->addTdContSafe('electricity_status', $data, $comp_model->get_field_options_value_name(FieldOptions::service_status));?> </td>
                                        <td> <?php echo $this->addTdContSafe('sewage_status', $data, $comp_model->get_field_options_value_name(FieldOptions::service_status));?> </td>
                                        <td> <?php echo $this->addTdContSafe('storm_water_status', $data, $comp_model->get_field_options_value_name(FieldOptions::service_status));?> </td>
                                        <td> <?php echo $this->addTdContSafe('prov_roads_status', $data, $comp_model->get_field_options_value_name(FieldOptions::service_status));?> </td>
                                        <td> <?php echo $data['created']; ?> </td>

                                        <th class="td-btn">
                                            <a class="btn btn-sm btn-info has-tooltip" title="<?= EDIT_RECORD_MSG ?>" href="<?php print_link('erven/manage_dev_cell/' . $data['id']); ?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>

                                            <a class="btn btn-sm btn-danger recordDeletePromptAction has-tooltip" title="<?= EDIT_RECORD_MSG ?>" href="<?= print_link("erven/delete_dev_cell/{$data['id']}"); ?>" >
                                                <i class="fa fa-times"></i>
                                                Delete
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
                                <div class="col-sm-3">  

                                    <button data-prompt-msg="Are you sure you want to delete these records" data-url="<?php print_link("acc_invoices/delete/{sel_ids}"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                        <i class="material-icons">clear</i> <?php print_lang('delete_selected'); ?>
                                    </button>


                                    <button class="btn btn-sm btn-primary export-btn"><i class="fa fa-save"></i> <?php print_lang(''); ?></button>


                                    <?php Html :: import_form('acc_invoices/import_data', get_lang(''), 'CSV , JSON'); ?>

                                </div>
                                <div class="col">   
                                    <?php
                                    if ($show_pagination == true) {
                                        $pager = new Pagination($total_records, $record_count);
                                        $pager->page_name = 'acc_invoices';
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
                    $this->addNoDataFoundMsg("No records found", "text-muted animated bounce");
                }
                ?>
            </div>
        </div>
    </div>
</section>
