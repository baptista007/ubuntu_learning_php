
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
                        <a  class="btn btn btn-primary btn-block" href="<?php print_link("erven/manage_erf") ?>">
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
                        <table id="erf-list" class="table  table-striped table-sm">
                            <thead class="table-header bg-light">
                                <tr>
                                    <th class="td-sno"><?= HTML::get_field_order_link('erf_number', 'ERF #') ?></th>
                                    <th > ERF Size </th>
                                    <th > Street Address </th>
                                    <th > <?= HTML::get_field_order_link('zoning_id', 'Zoning') ?></th>
                                    <th > <?= HTML::get_field_order_link('extension_id', 'Extension') ?></th>
                                    <th > <?= HTML::get_field_order_link('tbl_erf.created', 'Created') ?></th>
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
                                        <td><a href="<?php print_link("erven/view_erf/{$data['id']}") ?>"><?php echo $data['erf_number']; ?></a></td>
                                        <td> <?php echo $data['erf_size']; ?> </td>
                                        <td> <?php echo $data['street_address']; ?> </td>
                                        <td> <?php echo $data['zoning']; ?> </td>
                                        <td> <?php echo $data['extension']; ?> </td>
                                        <td> <?php echo $data['created']; ?> </td>

                                        <th class="td-btn">
                                            <a class="btn btn-sm btn-success has-tooltip" title="<?= VIEW_RECORD_MSG ?>" href="<?php print_link('erven/view_erf/' . $data['id']); ?>">
                                                <i class="fa fa-eye"></i> View
                                            </a>

                                            <a class="btn btn-sm btn-info has-tooltip" title="<?= EDIT_RECORD_MSG ?>" href="<?php print_link('erven/manage_erf/' . $data['id']); ?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>

                                            <a class="btn btn-sm btn-danger recordDeletePromptAction has-tooltip" title="<?= EDIT_RECORD_MSG ?>" href="<?= print_link("erven/delete_erf/{$data['id']}"); ?>" >
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
