<?php
$records = $this->view_data;
?>
<section class="page">
    <div  class="bg-light py-2 mb-3">
        <div class="">
            <div class="row ">
                <div class="col-sm-1 comp-grid">
                    <a  class="btn btn btn-primary btn-block" href="<?php print_link("communication/send_email") ?>">
                        <i class="fas fa-plus"></i>                              
                        New
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div  class="card animated fadeIn">
        <?php
            if (!empty($records)) {
                ?>
                <div class="page-records table-responsive">
                    <table class="table  table-striped table-sm">
                        <thead class="table-header bg-light">
                            <tr>
                                <th class="td-sno">Send To</th>
                                <th > Subject </th>
                                <th > Message </th>
                                <th > Status </th>
                                <th > Created</th>
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
                                    <td> <?php echo ($data['send_to'] == CommsSendTo::all_residents ? 'All' : 'Selected') . ' residents'; ?> </td>
                                    <td> <?php echo $data['subject']; ?> </td>
                                    <td> <?php echo $data['message']; ?> </td>
                                    <td> <?php echo $data['status']; ?> </td>
                                    <td> <?php echo $data['created']; ?> </td>

                                    <th class="td-btn">
                                        <a class="btn btn-sm btn-info has-tooltip" title="<?= EDIT_RECORD_MSG ?>" href="<?php print_link('communication/send_email/' . $data['id']); ?>">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <a class="btn btn-sm btn-danger recordDeletePromptAction has-tooltip" title="<?= EDIT_RECORD_MSG ?>" href="<?= print_link("communication/delete_email/{$data['id']}"); ?>" >
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
            } else {
                $this->addNoDataFoundMsg("No previously sent SMSs found", "text-muted animated bounce");
            }
        ?>
    </div>
</section>