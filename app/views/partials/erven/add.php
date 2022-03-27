
<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;

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

if ($data_array && empty($documents)) {
    echo '<div class="form-group">';
    echo '<button class="btn btn-primary" type="button" onclick="openModalRemoteContent(\'' . SITE_ADDR . 'ajax/erf_plans_upload/' . $data['id'] . '\', \'Upload ERF documents: ' . $data['erf_number'] . '\')">
                Attach Erf Documents
                <i class="fa fa-file"></i>
            </button>';
    echo '</div>';
}
?>
<section class="page">
    <div  class="">
        <?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#main">Main</a>
            </li>
            <?php
            if (!empty($page_id)) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#servicing">Servicing of Erf</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#developer">Developer Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= (empty($data['sales_contract_id']) ? " disabled" : "") ?>" data-toggle="tab" href="#construction">Construction</a>
                </li>

                <?php
                if ($data['zoning_id'] != Zoning::general_residential) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link<?= (empty($construction) ? " disabled" : "") ?>" data-toggle="tab" href="#construction-checks">Construction Checks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= (empty($construction) ? " disabled" : "") ?>" data-toggle="tab" href="#electrical">Electrical Compliance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= (empty($data['sales_contract_id']) ? " disabled" : "") ?>" data-toggle="tab" href="#residential">Residential</a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="main">
                <form class="form form-horizontal ajax" action="<?php print_link("erven/manage_erf" . (!empty($page_id) ? "/" . $page_id : "")) ?>" method="post">
                    <div class="row ">
                        <div class="col-md-6 comp-grid">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="erf_number">Erf Number <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input type="text" name="erf_number" id="erf_number" placeholder="ERF Number" class="form-control" value="<?php echo $this->set_field_value('erf_number', ''); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="erf_number">Street Address</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input type="text" name="street_address" id="street_address" placeholder="Street Address" class="form-control" value="<?php echo $this->set_field_value('street_address', ''); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="erf_size">Erf Size <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input type="number" name="erf_size" id="erf_size" placeholder="ERF Size" class="form-control" value="<?php echo $this->set_field_value('erf_size', ''); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="zoning_id">Zoning <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <select required=""  name="zoning_id" class="form-control">
                                                <option value=""> -- select value --</option>

                                                <?php
                                                $opts = $comp_model->zoning_id_option_list();

                                                foreach ($opts as $arr) {
                                                    ?>
                                                    <option <?php echo $this->set_field_selected('zoning_id', $arr['value']) ?> value="<?= $arr['value']; ?>">
                                                        <?= $arr['label'] ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="extension_id">Extension <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <select name="extension_id" class="form-control">
                                                <option value=""> -- select value --</option>

                                                <?php
                                                $opts = $comp_model->extension_id_option_list();

                                                foreach ($opts as $arr) {
                                                    ?>
                                                    <option <?php echo $this->set_field_selected('extension_id', $arr['value']) ?> value="<?= $arr['value']; ?>">
                                                        <?= $arr['label'] ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-submit-btn-holder mt-5">
                        <button class="btn btn-primary" type="submit">
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

            <?php
            if (!empty($page_id)) {
                ?>
                <div class="tab-pane" id="servicing">
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
                <div class="tab-pane" id="developer">
                    <?php
                    if ($dev_cell) {
                        ?>
                        <table class="table table-hover table-borderless table-striped">
                            <!-- Table Body Start -->
                            <tbody>

                                <tr>
                                    <th class="title"> Company Name:</th>
                                    <td class="value"> <?= $dev_cell['developer']; ?> </td>
                                </tr>

                                <tr>
                                    <th class="title"> Registration Number:</th>
                                    <td class="value"> <?= $dev_cell['developer_registration_number']; ?> </td>
                                </tr>
                            </tbody>
                            <!-- Table Body End -->
                        </table>

                        <?php
                    } else {
                        $this->addNoDataFoundMsg("Erf is not attributed to any developer.", "text-muted animated bounce");
                    }
                    ?>
                </div>
                <div class="tab-pane" id="construction">
                    <form name="devForm" id="erven-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal ajax" action="<?php print_link("erven/save_construction_init/" . $page_id) ?>" method="post">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#construction-main">Main</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#construction-attachments">Attachments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#construction-site-handover">Site Handover</a>
                            </li>
                            <?php
                            if ($data['zoning_id'] == Zoning::general_residential) {
                                echo '<li class="nav-item">';
                                echo '<a class="nav-link" data-toggle="tab" href="#construction-site-subdivision">Subdivision</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="construction-main">
                                <div class="row ">
                                    <div class="col-md-6 comp-grid">
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
                                                $field['value'] = $this->set_field_value($field['name'], '');
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
                                                Solar / Gas Geyser
                                            </legend>
                                            <?php
                                            $fields = array();
                                            $fields[] = array(
                                                'name' => 'gey_type',
                                                'type' => InputType::select,
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
                                    </div>
                                    <div class="col-md-6 comp-grid">
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

                                        <!--Internal Reticulation (General Residential specific)-->
                                        <?php if ($data['zoning_id'] == Zoning::general_residential) { ?>

                                            <fieldset class="mb-2">
                                                <legend>
                                                    Internal Reticulation
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

                                        <?php } ?>

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
                                </div>
                            </div>
                            <div class="tab-pane" id="construction-attachments">
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
                            <div class="tab-pane" id="construction-site-handover">
                                <div class="row ">
                                    <div class="col-md-8 comp-grid">
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
                                            'required' => false
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
                            <?php
                            if ($data['zoning_id'] == Zoning::general_residential) {
                                echo '<div class="tab-pane" id="construction-site-subdivision">';
                                

                                if ($data['gr_subdivided'] != YesNo::yes) {
                                    echo SharedController::AlertDiv("To subdivide this GR into STs, enter the number of STs into which the GR should be subdivided.", "info");
                                    $comp_model->addInput(array(
                                        'name' => 'number_of_sts',
                                        'type' => InputType::text,
                                        'label' => 'Number of sectional titles',
                                        'required' => true
                                    ));
                                } else {
                                    echo SharedController::AlertDiv("This GR has been subdivided into " . count($subdivided_erven) . " STs as listed below.", "info");
                                    
                                    echo '<div class="form-group">';
                                    echo 'Would you like to rerun the subdivision?&nbsp;&nbsp;';
                                    echo '<div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="rerun-check" name="rerun_subdivision" value="1">
                                            &nbsp;&nbsp;<label class="form-check-label" for="rerun-check">Yes, rerun the subdivison</label>
                                          </div>';
                                    echo '</div>';
                                    
                                    echo '<div class="form-group hidden" id="rerun-sub-input">';
                                    $comp_model->addInput(array(
                                        'name' => 'rerun_number_of_sts',
                                        'type' => InputType::text,
                                        'label' => 'Number of sectional titles',
                                        'required' => true,
                                        'value' => count($subdivided_erven)
                                    ));
                                    echo '</div>';
                                    
                                    if ($subdivided_erven) {
                                        echo '<table class="table table-striped" id="st-table">';
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
                                    
                                    ?>
                                    <script>
                                        $(function() {
                                            $(document).on('click', '#rerun-check', function() {
                                               if ($(this).is(':checked')) {
                                                   $('#rerun-sub-input').removeClass('hidden');
                                               } else {
                                                   $('#rerun-sub-input').addClass('hidden');
                                               }
                                            });
                                        });
                                    </script>
                                    <?php
                                }

                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div class="form-group form-submit-btn-holder mt-5">
                            <button id="invoice-submit-btn" class="btn btn-primary" type="submit">
                                Save
                                <i class="fa fa-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="construction-checks">
                    <?php
                    $checks = array();
                    $checks[] = array(
                        'key' => 'excavation',
                        'enum' => ConstructionChecks::excavation,
                        'title' => 'Excavation Inspection',
                        'fields' => array(
                            array(
                                'name' => 'exc_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'exc_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'term_foundation',
                        'enum' => ConstructionChecks::term_foundation,
                        'title' => 'Termite Treatment - Foundation',
                        'fields' => array(
                            array(
                                'name' => 'term_found_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'term_found_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                            array(
                                'name' => 'term_product_used', 'type' => InputType::text, 'label' => 'Product used'
                            ),
                            array(
                                'name' => 'term_dilution_used', 'type' => InputType::text, 'label' => 'Dilution used'
                            ),
                            array(
                                'name' => 'term_method_used', 'type' => InputType::text, 'label' => 'Method used'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'foundation',
                        'enum' => ConstructionChecks::foundation,
                        'title' => 'Foundation',
                        'fields' => array(
                            array(
                                'name' => 'found_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'found_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'foundation_wall',
                        'enum' => ConstructionChecks::foundation_wall,
                        'title' => 'Foundation Wall & Level Check',
                        'fields' => array(
                            array(
                                'name' => 'found_wall_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'found_wall_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'back_fill',
                        'enum' => ConstructionChecks::back_fill,
                        'title' => 'Back Fill',
                        'fields' => array(
                            array(
                                'name' => 'back_fill_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'back_fill_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'term_floor',
                        'enum' => ConstructionChecks::term_floor,
                        'title' => 'Termite Treatment - Finished floor level',
                        'fields' => array(
                            array(
                                'name' => 'term_floor_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'term_floor_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                            array(
                                'name' => 'term_floor_product_used', 'type' => InputType::text, 'label' => 'Product used'
                            ),
                            array(
                                'name' => 'term_floor_dilution_used', 'type' => InputType::text, 'label' => 'Dilution used'
                            ),
                            array(
                                'name' => 'term_floor_method_used', 'type' => InputType::text, 'label' => 'Method used'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'dpc',
                        'enum' => ConstructionChecks::dpc,
                        'title' => 'DPC',
                        'fields' => array(
                            array(
                                'name' => 'dpc_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'dpc_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'surface_bed',
                        'enum' => ConstructionChecks::surface_bed,
                        'title' => 'Surface Bed',
                        'fields' => array(
                            array(
                                'name' => 'surface_bed_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'surface_bed_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'window',
                        'enum' => ConstructionChecks::window,
                        'title' => 'Window Height (Building Check)',
                        'fields' => array(
                            array(
                                'name' => 'window_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'window_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'roof',
                        'enum' => ConstructionChecks::roof,
                        'title' => 'Roof Height (Building Check)',
                        'fields' => array(
                            array(
                                'name' => 'roof_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'roof_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'trusses',
                        'enum' => ConstructionChecks::trusses,
                        'title' => 'Trusses',
                        'fields' => array(
                            array(
                                'name' => 'trusses_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'trusses_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                            array(
                                'name' => 'trusses_type', 'type' => InputType::text, 'label' => 'Type'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'sisalation',
                        'enum' => ConstructionChecks::sisalation,
                        'title' => 'Sisalation',
                        'fields' => array(
                            array(
                                'name' => 'sis_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'sis_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                            array(
                                'name' => 'sis_type', 'type' => InputType::text, 'label' => 'Type'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'roof_sheeting',
                        'enum' => ConstructionChecks::roof_sheeting,
                        'title' => 'Roof Sheeting',
                        'fields' => array(
                            array(
                                'name' => 'roof_sheet_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'roof_sheet_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'storm_water',
                        'enum' => ConstructionChecks::storm_water,
                        'title' => 'Storm Water',
                        'fields' => array(
                            array(
                                'name' => 'storm_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'storm_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name'
                            ),
                            array(
                                'name' => 'storm_notes', 'type' => InputType::textarea, 'label' => 'Notes'
                            ),
                        )
                    );

                    $checks[] = array(
                        'key' => 'house',
                        'enum' => ConstructionChecks::house,
                        'title' => 'Final House Inspection',
                        'fields' => array(
                            array(
                                'name' => 'house_insp_date', 'type' => InputType::date, 'label' => 'Date', 'required' => true
                            ),
                            array(
                                'name' => 'house_insp_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative Name', 'required' => true
                            ),
                            array(
                                'name' => 'house_insp_opmc_eng', 'type' => InputType::text, 'label' => 'OPMC Engineer Name', 'required' => true
                            ),
                            array(
                                'name' => 'house_insp_num_lavatories', 'type' => InputType::number, 'label' => 'Number of Lavatories', 'required' => true
                            ),
                            array(
                                'name' => 'house_insp_notes', 'type' => InputType::textarea, 'label' => 'Notes'
                            ),
                            array(
                                'name' => 'house_insp_result', 'type' => InputType::select, 'label' => 'Passed/Failed', 'options' => $comp_model->get_field_options(FieldOptions::pass_fail)
                            ),
                            array(
                                'name' => 'house_insp_re_inspection_date', 'type' => InputType::date, 'label' => 'Re-inspection Date', 'ngshow' => "house_insp_result == " . PassFail::fail
                            ),
                            array(
                                'name' => 'house_insp_re_inspection_opmc_rep', 'type' => InputType::text, 'label' => 'OPMC Representative', 'ngshow' => "house_insp_result == " . PassFail::fail
                            ),
                            array(
                                'name' => 'house_insp_re_result', 'type' => InputType::select, 'label' => 'Passed/Failed', 'options' => $comp_model->get_field_options(FieldOptions::pass_fail), 'ngshow' => "house_insp_result == " . PassFail::fail
                            )
                        )
                    );

                    $checks[] = array(
                        'key' => 'okh_build_certificate',
                        'enum' => ConstructionChecks::okh_build_certificate,
                        'title' => 'Okahandja Building Certificate',
                        'fields' => array(
                            array(
                                'name' => 'okh_cert_number', 'type' => InputType::text, 'label' => 'Certificate Number'
                            ),
                            array(
                                'name' => 'okh_cert_inspector_name', 'type' => InputType::text, 'label' => 'Inspector Name'
                            ),
                            array(
                                'name' => 'okh_cert_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'okh_cert_improve_area', 'type' => InputType::text, 'label' => 'Improvement Area'
                            ),
                            array(
                                'name' => 'okh_cert_est_cost', 'type' => InputType::number, 'label' => 'Estimate Building Cost'
                            )
                        )
                    );

                    $checks[] = array(
                        'key' => 'cert_occupation',
                        'enum' => ConstructionChecks::cert_occupation,
                        'title' => 'Certificate of Occupancy (CO)',
                        'fields' => array(
                            array(
                                'name' => 'cert_date', 'type' => InputType::date, 'label' => 'Date'
                            ),
                            array(
                                'name' => 'cert_number', 'type' => InputType::text, 'label' => 'Certificate Number'
                            )
                        )
                    );

//                    $checks[] = array(
//                        'key' => 'plan_approval',
//                        'enum' => ConstructionChecks::plan_approval,
//                        'title' => 'Plan Approval',
//                        'fields' => array(
//                            array(
//                                'name' => 'inv_date', 'type' => InputType::date, 'label' => 'Invoice Date'
//                            ),
//                            array(
//                                'name' => 'inv_number', 'type' => InputType::text, 'label' => 'Invoice Number'
//                            )
//                        )
//                    );
//
//                    $checks[] = array(
//                        'key' => 'site_admin',
//                        'enum' => ConstructionChecks::site_admin,
//                        'title' => 'Site Administration',
//                        'fields' => array(
//                            array(
//                                'name' => 'site_admin_inv_date', 'type' => InputType::date, 'label' => 'Invoice Date'
//                            ),
//                            array(
//                                'name' => 'site_admin_inv_number', 'type' => InputType::text, 'label' => 'Invoice Number'
//                            )
//                        )
//                    );
//
//                    $checks[] = array(
//                        'key' => 'water_meter',
//                        'enum' => ConstructionChecks::water_meter,
//                        'title' => 'Water Meter',
//                        'fields' => array(
//                            array(
//                                'name' => 'wm_inv_date', 'type' => InputType::date, 'label' => 'Invoice Date'
//                            ),
//                            array(
//                                'name' => 'wm_inv_number', 'type' => InputType::text, 'label' => 'Invoice Number'
//                            ),
//                            array(
//                                'name' => 'wm_po', 'type' => InputType::text, 'label' => 'Purchase Order Number'
//                            ),
//                            array(
//                                'name' => 'wm_go_ahead', 'type' => InputType::date, 'label' => 'Go-Ahead Date'
//                            )
//                        )
//                    );


                    echo '<div class="row mb-4">';

                    foreach ($checks as $check) {
                        $done = in_array($check['enum'], $completed_checks);
                        echo '<div class="col-lg-6 col-xs-12 mb-4">';
                        echo '<form class="form form-horizontal ajax" action="' . get_link("erven/construction_checks/" . $page_id) . '" method="post" data-feedback-div="check-feedback-', $check['enum'], '">';
                        echo '<fieldset ' . ($done ? 'class="completed-check"' : '') . '>';
                        echo '<legend>' . $check['title'] . '</legend>';

                        //Microdata
                        echo '<input type="hidden" name="form_id" value="', $check['enum'], '" />';
                        echo '<div id="check-feedback-', $check['enum'], '"></div>';

                        foreach ($check['fields'] as $field) {
                            echo '<div class="form-group row" ' . (array_key_exists('ngshow', $field) ? 'ng-show="' . $field['ngshow'] . '"' : '') . '>';
                            echo '<label for="', $field['name'], '" class="col-sm-4 col-form-label">', $field['label'], '</label>';
                            echo '<div class="col-sm-8">';
                            $other_str = 'placeholder="' . $field['label'] . '"';

                            if (array_key_exists('required', $field) && $field['required']) {
                                $other_str .= ' required="required"';
                            }

                            echo $comp_model->getInput(
                                    $field['name'],
                                    $field['type'],
                                    $this->set_field_value($field['name'], ''),
                                    'form-control' . ($field['type'] == InputType::date ? ' datepicker' : ''),
                                    '',
                                    $other_str,
                                    (array_key_exists('options', $field) ? $field['options'] : null)
                            );
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '<div class="form-group form-submit-btn-holder text-center mt-5">
                                <button class="btn btn-primary" type="submit">
                                    Save
                                    <i class="fa fa-send"></i>
                                </button>
                            </div>';

                        echo '</fieldset>';
                        echo '</form>';
                        echo '</div>';
                    }

                    echo '</div>';
                    ?>
                </div>
                <div class="tab-pane" id="electrical">
                    <form class="form form-horizontal ajax" action="<?php print_link("erven/save_electrical/" . $page_id) ?>" method="post">
                        <?php
                        $elec = array();
                        $elec[] = array(
                            'key' => 'electrical_compliance',
                            'title' => 'Electrical Compliance Check',
                            'fields' => array(
                                array(
                                    'name' => 'elect_date', 'type' => InputType::date, 'label' => 'Date'
                                ),
                                array(
                                    'name' => 'elec_name', 'type' => InputType::text, 'label' => 'Electrician name - Builder'
                                ),
                                array(
                                    'name' => 'elec_opmc_rep', 'type' => InputType::text, 'label' => 'Inspector - OPMC'
                                ),
                                array(
                                    'name' => 'elec_pass_date', 'type' => InputType::date, 'label' => 'Pass Date'
                                ),
                                array(
                                    'name' => 'elec_seal_number', 'type' => InputType::textarea, 'label' => 'Seal Number'
                                ),
                                array(
                                    'name' => 'elec_coc_test_sheet_number', 'type' => InputType::text, 'label' => 'Dwelling inspection sheet number'
                                ),
                                array(
                                    'name' => 'elec_coc_test_sheet_date', 'type' => InputType::date, 'label' => 'Dwelling inspection sheet date'
                                ),
                                array(
                                    'name' => 'elec_coc_cert_number', 'type' => InputType::text, 'label' => 'CoC Certificate Number'
                                )
                            )
                        );

                        echo '<div class="row mb-4">';

                        foreach ($elec as $check) {
                            echo '<div class="col-lg-6 col-xs-12 mb-4">';
                            echo '<fieldset ' . ($this->set_field_value('elect_date', '') !== '' ? 'class="completed-check"' : '') . '>';
                            echo '<legend>' . $check['title'] . '</legend>';

                            foreach ($check['fields'] as $field) {
                                echo '<div class="form-group row">';
                                echo '<label for="', $field['name'], '" class="col-sm-4 col-form-label">', $field['label'], '</label>';
                                echo '<div class="col-sm-8">';
                                $other_str = 'placeholder="' . $field['label'] . '"';

                                if (array_key_exists('required', $field) && $field['required']) {
                                    $other_str .= ' required="required"';
                                }

                                echo $comp_model->getInput(
                                        $field['name'],
                                        $field['type'],
                                        $this->set_field_value($field['name'], ''),
                                        'form-control' . ($field['type'] == InputType::date ? ' datepicker' : ''),
                                        '',
                                        $other_str
                                );
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '<div class="form-group form-submit-btn-holder text-center mt-5">
                                <button class="btn btn-primary" type="submit">
                                    Save
                                    <i class="fa fa-send"></i>
                                </button>
                            </div>';

                            echo '</fieldset>';
                            echo '</div>';
                        }

                        echo '</div>';
                        ?>
                    </form>
                </div>
                <div class="tab-pane" id="residential">
    <?php
    $sections = array();
    $sections[] = array(
        'key' => 'contract_info',
        'enum' => ResidentialInfo::contract_info,
        'title' => 'Contract Information',
        'fields' => array(
            array(
                'name' => 'ci_date_signed', 'type' => InputType::date, 'label' => 'Owner Contract signed Date'
            ),
            array(
                'name' => 'ci_purchase_price', 'type' => InputType::text, 'label' => 'Purchase Price'
            ),
            array(
                'name' => 'ci_bond_instruction_date', 'type' => InputType::date, 'label' => 'Bond Instruction Received Date'
            ),
            array(
                'name' => 'ci_bank', 'type' => InputType::select, 'label' => 'Homeloand Bank', 'options' => $comp_model->get_bank_options()
            ),
            array(
                'name' => 'ci_mortgage_amount_1', 'type' => InputType::text, 'label' => '1st Mortgage Amount'
            ),
            array(
                'name' => 'ci_mortgage_amount_2', 'type' => InputType::text, 'label' => '2nd Mortgage Amount'
            )
        )
    );

    $sections[] = array(
        'key' => 'transfer_info',
        'enum' => ResidentialInfo::transfer_info,
        'title' => 'Transfer Information',
        'fields' => array(
            array(
                'name' => 'tri_date', 'type' => InputType::date, 'label' => 'Date of Transfer'
            ),
            array(
                'name' => 'trf_number', 'type' => InputType::text, 'label' => 'Deed of Transfer Number'
            ),
            array(
                'name' => 'trf_convenyancer_name', 'type' => InputType::text, 'label' => 'Conveyancer\'s Name'
            )
        )
    );

    echo '<div class="row mb-4">';

    foreach ($sections as $section) {
        echo '<div class="col-lg-6 col-xs-12 mb-4">';
        echo '<form class="form form-horizontal ajax" action="' . get_link("erven/save_contract_transfer_info/" . $page_id) . '" method="post">';
        echo '<input type="hidden" name="form_id" value="', $section['enum'], '" />';
        echo '<fieldset>';
        echo '<legend>' . $section['title'] . '</legend>';

        foreach ($section['fields'] as $field) {
            $rquired = array_key_exists('required', $field) && $field['required'];
            echo '<div class="form-group row ' . ($rquired ? 'required' : '') . '">';
            echo '<label for="', $field['name'], '" class="col-sm-4 col-form-label">', $field['label'], '</label>';
            echo '<div class="col-sm-8">';

            $other_str = '';

            if ($rquired) {
                $other_str .= ' required="required"';
            }

            echo $comp_model->getInput(
                    $field['name'],
                    $field['type'],
                    $this->set_field_value($field['name'], ''),
                    'form-control' . ($field['type'] == InputType::date ? ' datepicker' : ''),
                    '',
                    $other_str,
                    (array_key_exists('options', $field) ? $field['options'] : null)
            );
            echo '</div>';
            echo '</div>';
        }

        echo '<div class="form-group form-submit-btn-holder text-center mt-5">
                                <button class="btn btn-primary" type="submit">
                                    Save
                                    <i class="fa fa-send"></i>
                                </button>
                            </div>';

        echo '</fieldset>';
        echo '</form>';
        echo '</div>';
    }

    echo '</div>';
    ?>
                    <form class="form form-horizontal ajax" action="<?= get_link("erven/save_owner_info/" . $page_id) ?>" method="post" ng-controller="HomeOwnerController">
                    <?php echo $comp_model->getInput("owner_save_url", InputType::hidden, get_link("erven/save_owner_info/" . $page_id)) ?>
                        <fieldset>
                            <legend>Home Owners Information</legend>
                            <fieldset ng-repeat="(oIndex, owner) in owners" class="mb-2">
                                <legend>Owner {{oIndex + 1}}</legend>

                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                First Name
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="first_name[]" ng-model="owner.first_name" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Last Name
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="last_name[]" ng-model="owner.last_name" class="form-control">
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                ID Number
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="id_number[]" ng-model="owner.id" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Gender
                                            </label>
                                            <div class="col-sm-8">
                                                <select name="gender[]" ng-model="owner.gender" class="form-control">
                                                    <option value="">--select gender--</option>
                                                    <option value="1">Female</option>
                                                    <option value="2">Male</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Nationality
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="nationality[]" ng-model="owner.nationality" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Date of birth
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="date" name="dob[]" ng-model="owner.dob" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Email Addresses
                                            </label>
                                            <div class="col-sm-8">
                                                <div class="input-group mb-3" ng-repeat="(iIndex, email) in owner.email_addresses">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Email {{iIndex + 1}}</span>
                                                    </div>
                                                    <input type="text" name="emails[]addresses[]" ng-model="email.address" class="form-control" aria-describedby="basic-addon2">
                                                    <div class="input-group-append" ng-if="iIndex != 0">
                                                        <button class="btn btn-outline-secondary" type="button" ng-click="removeEmailAddress(oIndex, iIndex)" tabindex="-1">Remove</button>
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-info" ng-click="addEmailAddress($index)" type="button" tabindex="-1">Add</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                P O Box
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="p_o_box[]" ng-model="owner.p_o_box" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Contact Numbers
                                            </label>
                                            <div class="col-sm-8">
                                                <div class="input-group" ng-repeat="(iIndex, contact) in owner.contact_numbers">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Number {{iIndex + 1}}</span>
                                                    </div>
                                                    <input type="number" name="contacts[]numbers[]" ng-model="contact.number" class="form-control" aria-describedby="basic-addon2">
                                                    <div class="input-group-append" ng-if="iIndex != 0">
                                                        <button class="btn btn-outline-secondary" type="button" ng-click="removeContactNumber(oIndex, iIndex)" tabindex="-1">Remove</button>
                                                    </div>
                                                </div>
                                                <small id="emailHelp" class="form-text text-muted">Enter Namibian telephone number. E.x. 0811234567</small>
                                                <br />
                                                <button class="btn btn-sm btn-info" ng-click="addContactNumber($index)" type="button" tabindex="-1">Add another</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Employer
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="employer[]" ng-model="owner.employer" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Occupation
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="occupation[]" ng-model="owner.occupation" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                First Time Home Owner
                                            </label>
                                            <div class="col-sm-8">
                                                <select name="first_time_owner[]" ng-model="owner.first_time_owner" class="form-control">
                                                    <option value="">--select--</option>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Vehicle Application Date
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="date" name="vehicle_application_date[]" ng-model="owner.vehicle_application_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Vehicle Make
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="vehicle_make[]" ng-model="owner.vehicle_make" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Vehicle Type
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="vehicle_type[]" ng-model="owner.vehicle_type" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Vehicle Registration Number
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="vehicle_reg_number[]" ng-model="owner.vehicle_reg_number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Orientation Attendance Date
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="date" name="orientation_date[]" ng-model="owner.orientation_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-form-label">
                                                Utility Account Reference
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="utility_account[]" ng-model="owner.utility_account" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xs-12">

                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <button class="btn btn-sm btn-info" ng-click="addOwner()" type="button">Add Owner</button>
                            </div> 

                            <div class="form-group form-submit-btn-holder text-center mt-5">
                                <button class="btn btn-primary" type="button" ng-disabled="owners.length < 1" ng-click="submitOwners()">
                                    Save
                                    <i class="fa fa-send"></i>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
    <?php
}
?>
        </div>
    </div>
</section>
<script type="text/javascript">
    var owners = '<?= json_encode($owners) ?>';
</script>