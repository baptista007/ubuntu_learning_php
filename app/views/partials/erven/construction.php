<?php
$comp_model = new SharedController;

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;
$erf_select_id = "cc_" . time();
?>
<section class="page">
    <div  class="" ng-controller="ManagePldhCtrl">
        <?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>
        <form name="devForm" id="erven-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal ajax" action="<?php print_link("erven/manage_construction" . (!empty($page_id) ? "/" . $page_id : "")) ?>" method="post">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#main">Main</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#attachments">Attachments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#site-handover">Site Handover</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="main">
                    <div class="row ">
                        <div class="col-md-6 comp-grid">
                            <?php
                            $fields = array();
                            $dev_id = $this->set_field_value('developer_id', '');
                            $fields[] = array(
                                'name' => 'developer_id',
                                'type' => InputType::select,
                                'label' => 'Developer',
                                'options' => $comp_model->developers_id_option_list(),
                                'required' => true,
                                'value' => $dev_id
                            );

                            $fields[] = array(
                                'name' => 'sales_contract_id',
                                'type' => InputType::select,
                                'label' => 'Sales Contract',
                                'options' => (!empty($dev_id) ? $comp_model->get_developer_sc_options($dev_id) : null),
                                'required' => true,
                                'default_label' => '--select developer--'
                            );

                            foreach ($fields as $field) {
                                if (!array_key_exists('value', $field)) {
                                    $field['value'] = $this->set_field_value($field['name'], '');
                                }

                                $comp_model->addInput($field);
                            }
                            ?>
                            <fieldset class="mb-2">
                                <legend>
                                    Property Building Plans
                                </legend>
                                <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'opmc_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'OPMC Approval Date',
                                    'required' => true
                                );

                                $fields[] = array(
                                    'name' => 'opmc_agent',
                                    'type' => InputType::text,
                                    'label' => 'Name of OPMC Agent',
                                    'required' => true
                                );

                                $fields[] = array(
                                    'name' => 'okh_building_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'OKH Municipality Building Department Approval Date',
                                    'required' => true
                                );

                                $fields[] = array(
                                    'name' => 'okh_civil_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'OKH Municipality Civil Department Approval Date',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                                ?>
                            </fieldset>

                            <fieldset class="mb-2">
                                <legend>
                                    Site Development Plan
                                </legend>
                                <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'site_dev_opmc_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'OPMC Approval Date',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                                ?>
                            </fieldset>

                            <fieldset class="mb-2">
                                <legend>
                                    Service Layout
                                </legend>
                                <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'ser_opmc_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'OPMC Approval Date',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                                ?>
                            </fieldset>

                            <fieldset class="mb-2">
                                <legend>
                                    Specifications, Finishes & Technical Documentation
                                </legend>
                                <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'spec_opmc_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'PLDH / OPMC Approval Date',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                                ?>
                            </fieldset>

                            <fieldset class="mb-2">
                                <legend>
                                    Solar / Gas Geyser
                                </legend>
                                <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'gey_type',
                                    'type' => InputType::date,
                                    'label' => 'Type',
                                    'options' => $comp_model->get_field_options(FieldOptions::geyser_type),
                                    'required' => false,
                                    'default_label' => '--select geyser type--'
                                );

                                $fields[] = array(
                                    'name' => 'gey_brand',
                                    'type' => InputType::text,
                                    'label' => 'Brand',
                                    'required' => false
                                );

                                $fields[] = array(
                                    'name' => 'gey_size',
                                    'type' => InputType::text,
                                    'label' => 'Size',
                                    'required' => false
                                );

                                $fields[] = array(
                                    'name' => 'gey_specifications',
                                    'type' => InputType::text,
                                    'label' => 'Specifications',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                                ?>
                            </fieldset>

                            <fieldset class="mb-2">
                                <legend>
                                    Internal Reticulation (General Residential specific)
                                </legend>
                                <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'ret_opmc_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'OPMC Approval Date',
                                    'required' => false
                                );

                                $fields[] = array(
                                    'name' => 'ret_okh_approval_date',
                                    'type' => InputType::date,
                                    'label' => 'OPMC Approval Date',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                                ?>
                            </fieldset>

                            <fieldset class="mb-2">
                                <legend>
                                    Lavatories
                                </legend>
                                <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'lavatories',
                                    'type' => InputType::number,
                                    'label' => 'Number of Lavetories on plan',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                                ?>
                            </fieldset>
                        </div>
                        <div class="col-md-6 comp-grid">
                            <div id="selected-erf-table">     
                                <span class="text-muted"><i>Selected erven will be listed here.</i></span>
                            </div>
                            <input type="hidden" name="selected_erven" id="selected-erf-hidden" />
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="attachments">
                    <div class="form-group required">
                        <label>
                            Proposed Development Plan (Project Timeline)
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('project_timeline'); ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label>
                            Waste Management System
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('waste_management'); ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label>
                            Proposal Letter
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('proposal_letter'); ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="site-handover">
                    <div class="row ">
                        <div class="col-md-6 comp-grid">
                            <?php
                                $fields = array();
                                $fields[] = array(
                                    'name' => 'site_handover_date',
                                    'type' => InputType::date,
                                    'label' => 'Site Handover Date',
                                    'required' => true
                                );

                                $fields[] = array(
                                    'name' => 'site_handover_opmc_rep',
                                    'type' => InputType::text,
                                    'label' => 'OPMC Representative Name',
                                    'required' => true
                                );
                                
                                $fields[] = array(
                                    'name' => 'site_handover_dev_rep',
                                    'type' => InputType::text,
                                    'label' => 'Developer Representative Name',
                                    'required' => true
                                );
                                
                                $fields[] = array(
                                    'name' => 'site_handover_other_people',
                                    'type' => InputType::text,
                                    'label' => 'Other People Present',
                                    'required' => true
                                );
                                
                                $fields[] = array(
                                    'name' => 'site_handover_checked',
                                    'type' => InputType::select,
                                    'label' => 'Curbs and OPMC Infrastructure Checked',
                                    'required' => true,
                                    'options' => $comp_model->get_field_options(FieldOptions::yes_no)
                                );
                                
                                $fields[] = array(
                                    'name' => 'site_handover_notes',
                                    'type' => InputType::textarea,
                                    'label' => 'Notes',
                                    'required' => false
                                );

                                foreach ($fields as $field) {
                                    if (!array_key_exists('value', $field)) {
                                        $field['value'] = $this->set_field_value($field['name'], '');
                                    }

                                    $comp_model->addInput($field);
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-submit-btn-holder mt-5">
                <button id="invoice-submit-btn" class="btn btn-primary" type="submit">
                    Save
                    <i class="fa fa-send"></i>
                </button>

                <button class="btn btn-warning" type="button" onclick="javascript:history.go(-1)">
                    Close
                    <i class="fas fa-reply"></i>
                </button>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(function () {
        function getDeveloperScs(dev_id) {
            doGet('<?= SITE_ADDR ?>ajax/get_developer_contracts/' + dev_id, function (data) {
                if (data !== '-1') {
                    $('#sales_contract_id').html(data);
                } else {
                    $('#selected-erf-table').html("<div class='alert alert-danger'>The selected developer does not have any approved contracts</div>");
                }
            });
        }

        $('#developer_id').change(function () {
            if (!isEmpty($(this).val())) {
                getDeveloperScs($(this).val());
            } else {
                $('#selected-erf-table').html('<span class="text-muted"><i>Selected erven will be listed here.</i></span>');
                $('#selected-erf-hidden').val("");
            }
        });

        $('#sales_contract_id').change(function () {
            if (!isEmpty($(this).val())) {
                openModalRemoteContent('<?= SITE_ADDR ?>ajax/erf_select_from_sc/<?= $erf_select_id ?>/' + $(this).val(), 'Select Erven');
            } else {
                $('#selected-erf-table').html('<span class="text-muted"><i>Selected erven will be listed here.</i></span>');
                $('#selected-erf-hidden').val("");
            }
        });

        $('body').on('click', '#<?= $erf_select_id ?>-add-btn', function () {
            let selected = $('#<?= $erf_select_id ?>-modal').find("input.optioncheck:checkbox:checked");

            if (selected.length < 1) {
                $('#<?= $erf_select_id ?>-feedback').html('<div class="alert alert-wanring">Please select one or more erven to be added.</div>');
                setTimeout(function () {
                    $('#<?= $erf_select_id ?>-feedback').html("");
                }, 2500);
                return false;
            }

            let html = getSelectedErfTable(selected);
            $('#selected-erf-table').html(html);

            let ids = selected.map(function () {
                return $(this).val();
            }).get();

            $('#selected-erf-hidden').val(ids);
        });
    });
</script>