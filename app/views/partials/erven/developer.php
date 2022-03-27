<?php
$comp_model = new SharedController;

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;

$data_array = $this->view_data;

if ($data_array) {
    $data = $data_array->main_record;
    $owners = $data_array->owners;
    $contacts = $data_array->contacts;
} else {
    $data = null;
    $owners = null;
    $contacts = null;
}
?>
<section class="page">
    <div  class="" ng-controller="ManageDeveloper">
        <?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>
        <form name="devForm" id="erven-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal ajax" action="<?php print_link("erven/manage_developer" . (!empty($page_id) ? "/" . $page_id : "")) ?>" method="post">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#main">Main</a>
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
                                'name' => 'type',
                                'type' => InputType::select,
                                'label' => 'Developer Type', 
                                'options' => $comp_model->get_field_options(FieldOptions::developer_type),
                                'required' => false,
                                'default_label' => '--select geyser type--'
                            );
                            
                            $fields[] = array(
                                'name' => 'name',
                                'type' => InputType::text,
                                'label' => 'Company Name', 
                                'required' => true
                            );
                            
                            $fields[] = array(
                                'name' => 'registration_number',
                                'type' => InputType::text,
                                'label' => 'Company Registration Number', 
                                'required' => true
                            );
                            
                            foreach ($fields as $field) {
                                $field['value'] = $this->set_field_value($field['name'], '');
                                $comp_model->addInput($field);
                            }
                            ?>
                            
                            <div class="mb-2"></div>
                            
                            <fieldset class="mb-4">
                                <legend>Owners</legend>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Cellphone</th>
                                            <th>Email Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in owners">
                                            <td>
                                                <input type="text" name="owners_name[]" ng-model="item.first_name" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="text" name="owners_last_name[]" ng-model="item.last_name" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="text" name="owners_cell[]" ng-model="item.cell" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="email" name="owners_email[]" ng-model="item.email" class="form-control" />
                                            </td>
                                            <td><button type="button" class="btn btn-danger" ng-click="removeOwner($index)">Delete</button></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <button type="button" class="btn btn-primary" ng-click="addOwner()">
                                                    <i class="fa fa-plus"></i> Add Owner
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                            
                            <fieldset>
                                <legend>Other Contact Persons</legend>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Cellphone</th>
                                            <th>Email Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in contacts">
                                            <td>
                                                <input type="text" name="contacts_name[]" ng-model="item.first_name" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="text" name="contacts_last_name[]" ng-model="item.last_name" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="text" name="contacts_cell[]" ng-model="item.cell" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="email" name="contacts_email[]" ng-model="item.email" class="form-control" />
                                            </td>
                                            <td><button type="button" class="btn btn-danger" ng-click="removeContact($index)">Delete</button></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <button type="button" class="btn btn-primary" ng-click="addContact()">
                                                    <i class="fa fa-plus"></i> Add Contact
                                                </button>
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
                            Company Profile
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('profile_docs'); ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label>
                            Reference List
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('reference_docs'); ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label>
                            Secretarial Documents
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('secretarial_docs'); ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label>
                            Management and Professional Team Details
                        </label>
                        <div>
                            <?= $comp_model->addFileInput('team_docs'); ?>
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
<?php
if ($owners) {
    ?>
    <script type="text/javascript">
        var owners = '<?= json_encode($owners) ?>';
    </script>
    <?php
}
?>

<?php
if ($contacts) {
    ?>
    <script type="text/javascript">
        var contacts = '<?= json_encode($contacts) ?>';
    </script>
    <?php
}
?>
