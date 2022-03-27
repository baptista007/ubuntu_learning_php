
<?php
$comp_model = new SharedController;

//Page Data Information from Controller
$data_array = $this->view_data;

if ($data_array) {
    $data = $data_array->main_record;
    $dev_cell = $data_array->dev_cell;
    $sales_contract = $data_array->sales_contract;
    $developer = $data_array->developer;
    $payments = $data_array->payments;
    $documents = $data_array->documents;
    $construction = $data_array->construction;
    $completed_checks = $data_array->completed_checks;
    $owners = $data_array->owners;
    $subdivided_erven = (property_exists($data_array, 'subdivided_erven') ? $data_array->subdivided_erven : null);
} else {
    $data = null;
    $dev_cell = null;
    $sales_contract = null;
    $developer = null;
    $payments = null;
    $documents = null;
    $construction = null;
    $completed_checks = array();
    $owners = null;
    $subdivided_erven = null;
}
//$rec_id = $data['__tableprimarykey'];
$page_id = Router::$page_id; //Page id from url
?>
<section class="page">
    <div class="row ">

        <div class="col-md-12 comp-grid">

            <?php $this :: display_page_errors(); ?>

            <div  class="animated fadeIn">
                <?php
                if (!empty($data)) {
                    ?>
                    <div class="page-records ">
                        <div class="row mb-2">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        ERF Details
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-borderless table-striped">
                                            <!-- Table Body Start -->
                                            <tbody>

                                                <tr>
                                                    <th class="title"> ERF Number:</th>
                                                    <td class="value"> <?= $data['erf_number']; ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> ERF Size:</th>
                                                    <td class="value"> <?= $data['erf_size']; ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Zoning:</th>
                                                    <td class="value"> <?= $data['zoning']; ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Extension:</th>
                                                    <td class="value"> <?= $data['extension']; ?> </td>
                                                </tr>


                                                <tr>
                                                    <th class="title"> Developer:</th>
                                                    <td class="value"> <?= ($developer ? $developer['name'] : ''); ?> </td>
                                                </tr>


                                                <tr>
                                                    <th class="title"> Created:</th>
                                                    <td class="value"> <?= $this->getFormattedValueForDisplay($data['created']) ?> </td>
                                                </tr>

                                                <tr>
                                                    <th class="title"> Modified:</th>
                                                    <td class="value"> <?= $this->getFormattedValueForDisplay($data['modified']) ?> </td>
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
                                        Servicing Information
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if ($dev_cell) {
                                            ?>
                                            <table class="table table-hover table-borderless table-striped">
                                                <!-- Table Body Start -->
                                                <tbody>

                                                    <tr>
                                                        <th class="title"> VO Number:</th>
                                                        <td class="value"> <?= $dev_cell['vo_number']; ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Developer:</th>
                                                        <td class="value"> <?= $dev_cell['developer']; ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Water Status:</th>
                                                        <td class="value"> <?= $this->addTdContSafe('water_status', $dev_cell, $comp_model->get_field_options_value_name(FieldOptions::service_status)); ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Electricity Status:</th>
                                                        <td class="value"> <?= $this->addTdContSafe('electricity_status', $dev_cell, $comp_model->get_field_options_value_name(FieldOptions::service_status)); ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Sewage Status:</th>
                                                        <td class="value"> <?= $this->addTdContSafe('sewage_status', $dev_cell, $comp_model->get_field_options_value_name(FieldOptions::service_status)); ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Storm Water Status:</th>
                                                        <td class="value"> <?= $this->addTdContSafe('storm_water_status', $dev_cell, $comp_model->get_field_options_value_name(FieldOptions::service_status)); ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Provisional Roads Status:</th>
                                                        <td class="value"> <?= $this->addTdContSafe('prov_roads_status', $dev_cell, $comp_model->get_field_options_value_name(FieldOptions::service_status)); ?> </td>
                                                    </tr>
                                                </tbody>
                                                <!-- Table Body End -->
                                            </table>

                                            <?php
                                        } else {
                                            $this->addNoDataFoundMsg("Erf is not attributed to any development cell.", "text-muted animated bounce");
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Sales Contracts
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if ($sales_contract) {
                                            ?>
                                            <table class="table table-hover table-borderless table-striped">
                                                <!-- Table Body Start -->
                                                <tbody>
                                                    <tr>
                                                        <th class="title"> Sales Contract Number:</th>
                                                        <td class="value"> <?= $sales_contract['sc_number']; ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Developer:</th>
                                                        <td class="value"> <?= $sales_contract['developer']; ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Setup Date:</th>
                                                        <td class="value"> <?= $this->getFormattedValueForDisplay($sales_contract['setup_date']) ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> Signed Date:</th>
                                                        <td class="value"> <?= $this->getFormattedValueForDisplay($sales_contract['signed_date']) ?> </td>
                                                    </tr>
                                                </tbody>
                                                <!-- Table Body End -->
                                            </table>

                                            <?php
                                        } else {
                                            $this->addNoDataFoundMsg("Erf is not attributed to any PLDH.", "text-muted animated bounce");
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Payments
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if ($payments) {
                                            ?>
                                            <table class="table table-hover table-borderless table-striped">
                                                <!-- Table Body Start -->
                                                <tbody>
                                                    <tr>
                                                        <th class="title">Date:</th>
                                                        <th class="title">Amount</th>
                                                    </tr>

                                                    <?php
                                                    foreach ($payments as $payment) {
                                                        ?>
                                                        <tr>
                                                            <td class="value"> <?= $this->getFormattedValueForDisplay($payment['date']) ?> </td>
                                                            <td class="value"> <?= $this->getFormattedValueForDisplay($payment['amount']) ?> </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <!-- Table Body End -->
                                            </table>

                                            <?php
                                        } else {
                                            $this->addNoDataFoundMsg("No payments registered for ERF.", "text-muted animated bounce");
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-6 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        Documents
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
                                                    </tr>

                                                    <?php
                                                    foreach ($documents as $doc) {
                                                        ?>
                                                        <tr>
                                                            <td class="value"> <?= $this->getFormattedValueForDisplay($doc['doc_type']) ?> </td>
                                                            <td class="value">
                                                                <a href="<?= print_link(UPLOAD_FILE_DIR . $doc['path']) ?>" target="_blank">
                                                                    <?= $doc['original_name'] ?>
                                                                </a>
                                                            <td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <!-- Table Body End -->
                                            </table>

                                            <?php
                                        } else {
                                            $this->addNoDataFoundMsg("No documents attached to ERF.", "text-muted animated bounce");
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($data['zoning_id'] == Zoning::general_residential && $data['gr_subdivided'] == YesNo::yes) {
                                echo '<div class="col-lg-6 col-xs-12">';
                                echo '<div class="card">';
                                echo '<div class="card-header">';
                                echo 'Subdivided Erven';
                                echo '</div>';
                                echo '<div class="card-body">';

                                if ($subdivided_erven) {
                                    echo '<table class="table table-striped datatable" data-max-record="10">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>';
                                    echo 'ERF Number';
                                    echo '</th>';
                                    echo '<th>';
                                    echo 'Action';
                                    echo '</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    foreach ($subdivided_erven as $serf) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo $serf['erf_number'];
                                        echo '</td>';
                                        echo '<td>';
                                        HTML::page_link('erven/view_erf/' . $serf['id'], 'View', '', 'target="_blank"');
                                        echo '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                } else {
                                    SharedController::AlertDiv("No subdivided erven found.", "warning");
                                }

                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="p-3">
                        <a class="btn btn-sm btn-info"  href="<?php print_link("erven/manage_erf/{$data['id']}"); ?>">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <a class="btn btn-sm btn-danger recordDeletePromptAction"  href="<?php print_link("acc_invoices/delete_invoice/$data[id]"); ?>" >
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