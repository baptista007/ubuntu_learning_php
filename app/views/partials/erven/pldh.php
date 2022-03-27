<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;
?>
<section class="page">
    <div  class="" ng-controller="ManagePldhCtrl">
        <?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>
        <form name="devForm" id="erven-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal ajax" action="<?php print_link("erven/manage_pldh" . (!empty($page_id) ? "/" . $page_id : "")) ?>" method="post">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#main">Main</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#erfs">Linked Erven</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#agreement">Signing of Agreement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#attachments">Attachments</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="main">
                    <div class="row ">
                        <div class="col-md-6 comp-grid">
                            <?php
                            $fields = array();
                            $fields[] = array(
                                'name' => 'developer_id',
                                'type' => InputType::select,
                                'label' => 'Developer',
                                'options' => $comp_model->developers_id_option_list(DeveloperType::house),
                                'required' => true,
                                'class' => 'select'
                            );

                            foreach ($fields as $field) {
                                $field['value'] = $this->set_field_value($field['name'], '');
                                $comp_model->addInput($field);
                            }

                            $sc_number = $this->set_field_value($field['name'], 'Auto-generated on save**');

                            echo '<div class="form-group row">';
                            echo '<label class="col-sm-4 col-form-label">Sales Contract Number</label>';
                            echo '<div class="col-sm-8">';
                            echo '<input type="text" name="sc_number" id="sc_number" value="' . $sc_number . '" class="form-control" readonly/>';
                            echo '</div>';
                            echo '</div>';

                            $comp_model->addInput(array(
                                'name' => 'status',
                                'type' => InputType::select,
                                'label' => 'Status',
                                'value' => $this->set_field_value('status', ''),
                                'options' => $comp_model->get_field_options(FieldOptions::pldh_status),
                                'required' => true
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="erfs">
                    <div class="form-group">
                        <button ng-click="openModal();" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i> Add Erven</button>
                    </div>
                    <div id="selected-erf-table" ng-show="selected_erven.length > 0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Extension
                                    </th>
                                    <th>
                                        ERF Number
                                    </th>
                                    <th>
                                        Size
                                    </th>
                                    <th>
                                        Street Address
                                    </th>
                                    <th>
                                        Sale Price
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="erf in selected_erven">
                                    <td>
                                        {{erf.extension}}
                                        <input type="hidden" name="erf[]" value="{{erf.id}}" />
                                    </td>
                                    <td>
                                        {{erf.erf_number}}
                                    </td>
                                    <td>
                                        {{erf.erf_size}}
                                    </td>
                                    <td>
                                        {{erf.street_address}}
                                    </td>
                                    <td>
                                        <input type="text" name="sale_amount[]" class="form-control currency" style="width: auto !important;" ng-model="erf.sale_amount" />
                                    </td>
                                    <td><button type="button" class="btn btn-danger" ng-click="remove($index)" tabindex="-1">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>                        
                    </div>
                </div>
                <div class="tab-pane" id="agreement">
                    <div class="row ">
                        <div class="col-lg-8 col-xs-12 comp-grid">
                            <?php
                            $fields = array();
                            $fields[] = array(
                                'name' => 'ag_setup_date',
                                'type' => InputType::date,
                                'label' => 'Agreement Setup Date',
                                'required' => true
                            );

                            $fields[] = array(
                                'name' => 'ag_signed_date',
                                'type' => InputType::date,
                                'label' => 'Agreement Signed Date',
                                'required' => true
                            );

                            $fields[] = array(
                                'name' => 'ag_validity',
                                'type' => InputType::date,
                                'label' => 'Validity/Date of Expiry',
                                'required' => true
                            );

                            $fields[] = array(
                                'name' => 'ag_amount',
                                'type' => InputType::number,
                                'label' => 'Sales Amount',
                                'required' => true,
                                'other' => " readonly ng-bind='salePrice()'"
                            );

                            $fields[] = array(
                                'name' => 'pay_terms',
                                'type' => InputType::text,
                                'label' => 'Payment Terms'
                            );

                            foreach ($fields as $field) {
                                $field['value'] = $this->set_field_value($field['name'], '');
                                $comp_model->addInput($field);
                            }
                            ?>
                            <fieldset>
                                <legend>Payments</legend>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                ERF Number
                                            </th>
                                            <th>
                                                Sale Amount
                                            </th>
                                            <th>
                                                Outstanding
                                            </th>
                                            <th>
                                                Payment Date
                                            </th>
                                            <th>
                                                Payment Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="erf in selected_erven">
                                            <td>
                                                {{erf.erf_number}}
                                            </td>
                                            <td>
                                                {{unformatNumber(erf.sale_amount) | currency : '<?php print_currency() ?>' : '<?php print_num_decimal() ?>'}}
                                            </td>
                                            <td>
                                                <span>
                                                    {{calculateOutstanding($index) | currency : '<?php print_currency() ?>' : '<?php print_num_decimal() ?>'}}
                                                </span>
                                            </td>
                                            <td>
                                                <input type="date" name="payment_date[]" ng-model="erf.payment_date" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="hidden" name="payment_erf[]" value="{{erf.id}}" />
                                                <input type="text" name="payment_amount[]" ng-model="erf.payment" class="form-control currency" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <strong>
                                                    Total Payments
                                                </strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>
                                                    <strong>{{ paymentTotal() | currency : '<?php print_currency() ?>' : '<?php print_num_decimal() ?>'}}</strong>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <strong>Total Outstanding</strong>
                                            </td>
                                            <td class="text-right">
                                                <strong>{{ totalOutstanding() | currency : '<?php print_currency() ?>' : '<?php print_num_decimal() ?>'}}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="attachments">
                    <div class="form-group required">
                        <label>
                            Sales Agreement
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('sales_agreement_file'); ?>
                        </div>
                    </div>
                    <?php
                    $documents = SharedController::getEntityFiles(FileLinkingEntity::pldh, $page_id);

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
<!--                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Extension
                                </th>
                                <th>
                                    ERF Number
                                </th>
                                <th>
                                    Size
                                </th>
                                <th>
                                    Street Address
                                </th>
                                <th>
                                    Upload Documents
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="erf in selected_erven">
                                <td>
                                    {{erf.extension}}
                                </td>
                                <td>
                                    {{erf.erf_number}}
                                    <input type="hidden" name="erf[]" value="{{erf.id}}" />
                                </td>
                                <td>
                                    {{erf.erf_size}}
                                </td>
                                <td>
                                    {{erf.street_address}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" ng-click="addFile(erf.id, erf.erf_number)">Upload files</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>-->
                </div>
            </div>

            <div class="form-group form-submit-btn-holder mt-5">
                <button id="invoice-submit-btn" class="btn btn-primary" type="submit">
                    Save
                    <i class="fa fa-send"></i>
                </button>

                <button class="btn btn-warning" type="button" onclick="javascript:history.go( - 1)">
                    Close
                    <i class="fas fa-reply"></i>
                </button>
            </div>
        </form>
    </div>
</section>
<script type="text/ng-template" id="erf_modal.html">
    <div class="modal-header">
    <h3 class="modal-title" id="modal-title">Erven Select</h3>
    </div>
    <div class="modal-body pldh-erven-selection" id="modal-body">
    <div id="product-warning" class="alert alert-warning hidden">
    One or more erven have already been added.
    </div>
    <div id="nothing-selected-warning" class="alert alert-warning hidden">
    Select at least one erf to be added.
    </div>
    <div id="already-selected-warning" class="alert alert-warning hidden">
    One or more erven could not be added.
    </div>
    <table class="table table-striped" id="pldh-erf-selection">
    <thead>
    <tr>
    <th class="td-sno td-checkbox"><input class="toggle-check-all" type="checkbox" /></th>
    <th>
    Extension
    </th>
    <th>
    ERF Number
    </th>
    <th>
    Size
    </th>
    <th>
    Street Address
    </th>
    </tr>
    </thead>
    <tbody>
    <tr ng-repeat="erf in available_erven">
    <td>
    <label>
    <input type="checkbox" class="optioncheck" name="optioncheck[]"  data-id="{{erf.id}}" data-extension="{{erf.extension}}" data-number="{{erf.erf_number}}" data-size="{{erf.erf_size}}" data-street="{{erf.street_address}}"  />
    </label>
    </td>
    <td>
    {{erf.extension}}
    </td>
    <td>
    {{erf.erf_number}}
    </td>
    <td>
    {{erf.erf_size}}
    </td>
    <td>
    {{erf.street_address}}
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    <div class="modal-footer">
    <button class="btn btn-primary" type="button" ng-click="addSelected()">Add Selected</button>
    <button class="btn btn-warning" type="button" ng-click="close()">Close</button>
    </div>
</script>

<?php
$db->join('tbl_zoning', "tbl_erf.zoning_id = tbl_zoning.id", 'LEFT');
$db->join('tbl_extension', "tbl_erf.extension_id = tbl_extension.id", 'LEFT');
$db->join('tbl_sale_contract_payment', "tbl_erf.id = tbl_sale_contract_payment.erf_id", 'LEFT');
$db->where("tbl_erf.sales_contract_id", $page_id);
$linked_erven = $db->get(
        'tbl_erf',
        null,
        array(
            "tbl_erf.id",
            "erf_number",
            "street_address",
            "erf_size",
            "sale_amount",
            "tbl_zoning.name as zoning",
            "tbl_extension.name as extension",
            "tbl_sale_contract_payment.date as payment_date",
            "tbl_sale_contract_payment.amount as payment",
        )
);

if (!empty($linked_erven)) {
    ?>
    <script type="text/javascript">
        var erven = '<?= json_encode($linked_erven) ?>';
    </script>
    <?php
}


$db->where("sales_contract_id", $page_id);
$payments = $db->get("tbl_sale_contract_payment");

if (!empty($payments)) {
    ?>
    <script type="text/javascript">
        var payments = '<?= json_encode($payments) ?>';
    </script>
    <?php
}
?>

