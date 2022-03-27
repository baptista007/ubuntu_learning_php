<?php
$comp_model = new SharedController;

//Page Data Information from Controller
$data_array = $this->view_data;

if ($data_array) {
    $data = $data_array->main_record;
    $erven = $data_array->linked_erven;
    $payments = $data_array->payments;
    $documents = $data_array->documents;
} else {
    $data = null;
    $erven = null;
    $payments = null;
    $documents = null;
}

$page_id = Router::$page_id; //Page id from url
?>
<section class="page">
    <div class="row ">

        <div class="col-md-12 comp-grid">

            <?php $this :: display_page_errors(); ?>

            <div  class="animated fadeIn pt-2">
                <?php
                if (!empty($data)) {
                    ?>
                    <div class="page-records ">
                        <div class="row mb-2">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Sales Contract Details
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-borderless table-striped">
                                            <!-- Table Body Start -->
                                            <tbody>

                                                <tr>
                                                    <th class="title"> Developer:</th>
                                                    <td class="value"> <?= $data['developer']; ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Sales Contract Number:</th>
                                                    <td class="value"> <?= $data['sc_number']; ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Status:</th>
                                                    <td class="value"> <?= $this->addTdContSafe('status', $data, $comp_model->get_field_options_value_name(FieldOptions::pldh_status)) ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Created:</th>
                                                    <td class="value"> <?= $this->getFormattedValueForDisplay($data['created']) ?></td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Modified:</th>
                                                    <td class="value"> <?= $this->getFormattedValueForDisplay($data['modified']) ?></td>
                                                </tr>
                                            </tbody>
                                            <!-- Table Body End -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Linked Erven
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-borderless table-striped">
                                            <thead class="table-header bg-light">
                                                <tr>
                                                    <th class="td-sno">ERF #</th>
                                                    <th > ERF Size </th>
                                                    <th > Street Address </th>
                                                    <th > Zoning </th>
                                                    <th > Extension</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach ($erven as $erf) {
                                                    ?>
                                                    <tr>
                                                        <td><a href="<?php print_link("erven/view_erf/{$erf['id']}") ?>" target="_blank"><?php echo $erf['erf_number']; ?></a></td>
                                                        <td> <?php echo $erf['erf_size']; ?> </td>
                                                        <td> <?php echo $erf['street_address']; ?> </td>
                                                        <td> <?php echo $erf['zoning']; ?> </td>
                                                        <td> <?php echo $erf['extension']; ?> </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Signing of Agreement
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-borderless table-striped">
                                            <!-- Table Body Start -->
                                            <tbody>

                                                <tr>
                                                    <th class="title"> Agreement Setup Date:</th>
                                                    <td class="value"> <?= $this->getFormattedValueForDisplay($data['setup_date']) ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Agreement Signed Date:</th>
                                                    <td class="value"> <?= $this->getFormattedValueForDisplay($data['signed_date']) ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Validity Date/Expiry Date:</th>
                                                    <td class="value"> <?= $this->getFormattedValueForDisplay($data['expiry_date']) ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Sales Amount:</th>
                                                    <td class="value"> <?= number_format($data['sales_amount']); ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Payment Terms:</th>
                                                    <td class="value"> <?php echo $data['payment_terms']; ?> </td>
                                                </tr>
                                            </tbody>
                                            <!-- Table Body End -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Payments
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-borderless table-striped mb-2">
                                            <thead class="table-header bg-light">
                                                <tr>
                                                    <th > ERF #</th>
                                                    <th > Amount</th>
                                                    <th > Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($payments as $pay) {
                                                    ?>
                                                    <tr>
                                                        <td> <?= $pay['erf_number'] ?> </td>
                                                        <td> <?= number_display($pay['amount']); ?> </td>
                                                        <td class="value"> <?= $this->getFormattedValueForDisplay($pay['date']) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="button" onclick="openModalRemoteContent('<?= SITE_ADDR . 'erven/add_payment_pldh/' . $page_id ?>', 'Register Payment')">
                                                New Payment
                                                <i class="fa fa-money"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Documents/Attachments
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if ($documents) {
                                            ?>
                                            <table class="table table-hover table-borderless table-striped">
                                                <!-- Table Body Start -->
                                                <tbody>
                                                    <tr>
                                                        <th class="title">Document Type:</th>
                                                        <th class="title">File</th>
                                                        <th>Actions</th>
                                                    </tr>

                                                    <?php
                                                    foreach ($documents as $doc) {
                                                        ?>
                                                        <tr>
                                                            <td class="value"> <?= $this->getFormattedValueForDisplay($doc['doc_type']) ?></td>
                                                            <td class="value">
                                                                <a href="<?= print_link(UPLOAD_FILE_DIR . $doc['path']) ?>" target="_blank">
                                                                    <?= $doc['original_name'] ?>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-sm btn-danger recordDeletePromptAction has-tooltip" title="<?= EDIT_RECORD_MSG ?>" href="<?= print_link("ajax/delete_files/{$doc['id']}"); ?>" >
                                                                    <i class="fa fa-times"></i>
                                                                    Delete
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <!-- Table Body End -->
                                            </table>

                                            <?php
                                        } else {
                                            $this->addNoDataFoundMsg("No documents attached to PLDH.", "text-muted animated bounce");
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3">
                        <a class="btn btn-sm btn-info"  href="<?php print_link("erven/manage_pldh/{$data['id']}"); ?>">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <a class="btn btn-sm btn-danger recordDeletePromptAction"  href="<?php print_link("erven/delete_pldh/$data[id]"); ?>" >
                            <i class="fa fa-times"></i> Delete
                        </a>

                        <a class="btn btn-sm btn-warning" href="javascript:void(0)" onclick="javascript:history.go(-1)">
                            <i class="fas fa-reply"></i> Close
                        </a>
                    </div>
                    <?php
                } else {
                    $this->addNoDataFoundMsg("Record not found.", "text-muted animated bounce");
                }
                ?>
            </div>

        </div>

    </div>
</section>
