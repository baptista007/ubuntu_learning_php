<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;
?>
<section class="page">
    <div  class="" ng-controller="AddDevCellCtrl">
        <?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>
        <form name="devForm" id="erven-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal ajax" action="<?php print_link("erven/manage_dev_cell"  . (!empty($page_id) ? "/" . $page_id : "")) ?>" method="post">
            <?= "<input type='hidden' name='form_id' id='form_id' value='" . Form::dev_cell_info . "' />" ?>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#main">Main</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#erfs">Linked Erven</a>
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
                                'options' => $comp_model->developers_id_option_list(DeveloperType::bulk), 
                                'required' => true,
                                'class' => 'select'
                            );
                            
                            $fields[] = array(
                                'name' => 'vo_number', 'type' => InputType::text, 'label' => 'VO Number', 'required' => true
                            );

                            foreach ($fields as $field) {
                                $field['value'] = $this->set_field_value($field['name'], '');
                                $comp_model->addInput($field);
                            }
                            ?>
                        </div>
                    </div>
                    <fieldset>
                        <legend>Services Status</legend>
                        <div class="row">
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'water_status',
                                        'type' => InputType::select,
                                        'label' => 'Water',
                                        'options' => $comp_model->get_field_options(FieldOptions::service_status),
                                        'required' => true,
                                        'value' => $this->set_field_value('water_status', '')
                                    ));
                                    ?>
                                </div>
                                <div ng-show="water_status == '<?= ServiceStatus::partially_serviced ?>'">
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'water_expected_completion_date',
                                            'type' => InputType::date,
                                            'label' => 'Expected Completion Date',
                                            'value' => $this->set_field_value('water_expected_completion_date', '')
                                        ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'water_commencement_date',
                                            'type' => InputType::date,
                                            'label' => 'Actual Commencement Date',
                                            'value' => $this->set_field_value('water_commencement_date', '')
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="water_status == '<?= ServiceStatus::completed ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'water_completion_date',
                                        'type' => InputType::date,
                                        'label' => 'Actual Completion Date',
                                        'value' => $this->set_field_value('water_completion_date', '')
                                    ));
                                    ?>
                                </div>
                                <div class="form-group" ng-show="water_status == '<?= ServiceStatus::handed_over ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'water_handover_date',
                                        'type' => InputType::date,
                                        'label' => 'Final Handover Date',
                                        'value' => $this->set_field_value('water_handover_date', '')
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'electricity_status',
                                        'type' => InputType::select,
                                        'label' => 'Electricity',
                                        'options' => $comp_model->get_field_options(FieldOptions::service_status),
                                        'required' => true,
                                        'value' => $this->set_field_value('electricity_status', '')
                                    ));
                                    ?>
                                </div>
                                <div ng-show="electricity_status == '<?= ServiceStatus::partially_serviced ?>'">
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'electricity_expected_completion_date',
                                            'type' => InputType::date,
                                            'label' => 'Expected Completion Date',
                                            'value' => $this->set_field_value('electricity_expected_completion_date', '')
                                        ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'electricity_commencement_date',
                                            'type' => InputType::date,
                                            'label' => 'Actual Commencement Date',
                                            'value' => $this->set_field_value('electricity_commencement_date', '')
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="electricity_status == '<?= ServiceStatus::completed ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'electricity_completion_date',
                                        'type' => InputType::date,
                                        'label' => 'Actual Completion Date',
                                        'value' => $this->set_field_value('electricity_completion_date', '')
                                    ));
                                    ?>
                                </div>
                                <div class="form-group" ng-show="electricity_status == '<?= ServiceStatus::handed_over ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'electricity_handover_date',
                                        'type' => InputType::date,
                                        'label' => 'Final Handover Date',
                                        'value' => $this->set_field_value('electricity_handover_date', '')
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'sewage_status',
                                        'type' => InputType::select,
                                        'label' => 'Sewage',
                                        'options' => $comp_model->get_field_options(FieldOptions::service_status),
                                        'required' => true,
                                        'value' => $this->set_field_value('sewage_status', '')
                                    ));
                                    ?>
                                </div>
                                <div ng-show="sewage_status == '<?= ServiceStatus::partially_serviced ?>'">
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'sewage_expected_completion_date', 
                                            'type' => InputType::date,
                                            'label' => 'Expected Completion Date',
                                            'value' => $this->set_field_value('sewage_expected_completion_date', '')
                                        ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'sewage_commencement_date', 
                                            'type' => InputType::date, 
                                            'label' => 'Actual Commencement Date',
                                            'value' => $this->set_field_value('sewage_commencement_date', '')
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="sewage_status == '<?= ServiceStatus::completed ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'sewage_completion_date', 
                                        'type' => InputType::date,
                                        'label' => 'Actual Completion Date',
                                        'value' => $this->set_field_value('sewage_completion_date', '')
                                    ));
                                    ?>
                                </div>
                                <div class="form-group" ng-show="sewage_status == '<?= ServiceStatus::handed_over ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'sewage_handover_date', 
                                        'type' => InputType::date,
                                        'label' => 'Final Handover Date',
                                        'value' => $this->set_field_value('sewage_handover_date', '')
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'storm_water_status', 
                                        'type' => InputType::select, 
                                        'label' => 'Storm Water', 
                                        'options' => $comp_model->get_field_options(FieldOptions::service_status), 'required' => true,
                                        'value' => $this->set_field_value('storm_water_status', '')
                                    ));
                                    ?>
                                </div>
                                <div ng-show="storm_water_status == '<?= ServiceStatus::partially_serviced ?>'">
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'storm_water_expected_completion_date', 
                                            'type' => InputType::date, 
                                            'label' => 'Expected Completion Date',
                                            'value' => $this->set_field_value('storm_water_expected_completion_date', '')
                                        ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'storm_water_commencement_date', 
                                            'type' => InputType::date, 
                                            'label' => 'Actual Commencement Date',
                                            'value' => $this->set_field_value('storm_water_commencement_date', '')
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="storm_water_status == '<?= ServiceStatus::completed ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'storm_water_completion_date', 
                                        'type' => InputType::date,
                                        'label' => 'Actual Completion Date',
                                        'value' => $this->set_field_value('storm_water_completion_date', '')
                                    ));
                                    ?>
                                </div>
                                <div class="form-group" ng-show="storm_water_status == '<?= ServiceStatus::handed_over ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'storm_water_handover_date', 
                                        'type' => InputType::date,
                                        'label' => 'Final Handover Date',
                                        'value' => $this->set_field_value('storm_water_handover_date', '')
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'prov_roads_status',
                                        'type' => InputType::select, 
                                        'label' => 'Provisional Roads', 
                                        'options' => $comp_model->get_field_options(FieldOptions::service_status),
                                        'required' => true,
                                        'value' => $this->set_field_value('prov_roads_status', '')
                                    ));
                                    ?>
                                </div>
                                <div ng-show="prov_roads_status == '<?= ServiceStatus::partially_serviced ?>'">
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'prov_roads_expected_completion_date',
                                            'type' => InputType::date,
                                            'label' => 'Expected Completion Date',
                                            'value' => $this->set_field_value('prov_roads_expected_completion_date', '')
                                        ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?=
                                        $comp_model->addInput(array(
                                            'name' => 'prov_roads_commencement_date',
                                            'type' => InputType::date,
                                            'label' => 'Actual Commencement Date',
                                            'value' => $this->set_field_value('prov_roads_commencement_date', '')
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group" ng-show="prov_roads_status == '<?= ServiceStatus::completed ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'prov_roads_completion_date',
                                        'type' => InputType::date,
                                        'label' => 'Actual Completion Date',
                                        'value' => $this->set_field_value('prov_roads_completion_date', '')
                                    ));
                                    ?>
                                </div>
                                <div class="form-group" ng-show="prov_roads_status == '<?= ServiceStatus::handed_over ?>'">
                                    <?=
                                    $comp_model->addInput(array(
                                        'name' => 'prov_roads_handover_date',
                                        'type' => InputType::date,
                                        'label' => 'Final Handover Date',
                                        'value' => $this->set_field_value('prov_roads_handover_date', '')
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="tab-pane" id="erfs">
                    <?php
                    $this->addErfSelectorButton("vo-select-erf", "selected-erf-table", "selected-erf-hidden");
                    ?>
                    <div id="selected-erf-table">   
                        <?php
                            $db->where("tbl_erf.dev_cell_id", $page_id);
                            $db->join('tbl_zoning', "tbl_erf.zoning_id = tbl_zoning.id", "LEFT");
                            $db->join('tbl_extension', "tbl_erf.extension_id = tbl_extension.id", "LEFT");
                            $linked_erven = $db->get('tbl_erf', null, array("tbl_erf.id", "erf_number", "street_address", "erf_size", "tbl_zoning.name as zoning", "tbl_extension.name as extension"));
                            
                            $erf_ids_hidden = "";
                            
                            if (!empty($linked_erven)) {
                                 echo '<table class="table table-striped" id="items_table">',
                                        '<thead>',
                                        '<tr>',
                                        '<th>Extension</th>',
                                        '<th>ERF Number</th>',
                                        '<th>ERF Size</th>',
                                        '<th>Street Address</th>',
                                        '<th></th>',
                                        '</tr>',
                                        '</thead>',
                                        '<tbody class="erf-selection-section">';

                                 foreach ($linked_erven as $erf) {
                                    $erf_ids_hidden .= (!empty($erf_ids_hidden) ? "," : "") . $erf['id'];
                                     
                                    echo  '<tr id="erf-tr-' . $erf['id'] . '">';
                                    echo  '<td>';
                                    echo  $erf['extension'];
                                    echo  '</td>';
                                    echo  '<td>';
                                    echo  $erf['erf_number'];
                                    echo  '</td>';
                                    echo  '<td>';
                                    echo  $erf['erf_size'];
                                    echo  '</td>';
                                    echo  '<td>';
                                    echo  $erf['street_address'];
                                    echo  '</td>';
                                    echo  '<td>';
                                    echo  '<button type="button" onclick="removeErf(' . $erf['id'] . ', \'selected-erf-hidden\')" class="btn btn-sm btn-danger">Remove</button>';
                                    echo  '</td>';
                                    echo  '</tr>';
                                 }
                                

                                echo '</tbody></table>';
                            }
                        ?>
                    </div>
                    <input type="hidden" name="selected_erven" id="selected-erf-hidden" value="<?= $erf_ids_hidden ?>" />
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