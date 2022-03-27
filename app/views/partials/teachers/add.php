
<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;
$data_array = $this->view_data;

$subjects = $db->get(SqlTables::tbl_subjects);

if (!empty(Router::$page_id)) {
    $query = "select
                subject_id
            from tbl_user_subjects
            where user_id = " . Router::$page_id;
    $checked = $db->rawQueryValue($query);
} else {
    $checked = array();
}
?>
<section class="page">
    <form action="<?= get_link("teachers/manage" . (!empty(Router::$page_id) ? '/' . Router::$page_id : '')) . '?csrf_token=' . Csrf::$token ?>" method="post" class="form form-horizontal needs-validation ajax">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-7 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn">

                        <div class="card-body">
                            <?php
                            $fields = array();

                            $fields[] = array(
                                'name' => 'name',
                                'type' => InputType::text,
                                'label' => 'Name',
                                'required' => true
                            );

                            $fields[] = array(
                                'name' => 'surname',
                                'type' => InputType::text,
                                'label' => 'Surname',
                                'required' => true
                            );

                            $fields[] = array(
                                'name' => 'user_name',
                                'type' => InputType::text,
                                'label' => 'Username',
                                'required' => true
                            );

                            $fields[] = array(
                                'name' => 'user_email',
                                'type' => InputType::text,
                                'label' => 'Email Address',
                                'required' => true
                            );

                            $fields[] = array(
                                'name' => 'user_password_hash',
                                'type' => InputType::password,
                                'label' => 'Password',
                                'required' => !$data_array
                            );

                            $fields[] = array(
                                'name' => 'confirm_password',
                                'type' => InputType::password,
                                'label' => 'Confirm Password',
                                'required' => !$data_array
                            );

                            foreach ($fields as $field) {
                                if (!in_array($field['name'], ['user_password_hash', 'confirm_password'])) {
                                    $field['value'] = $this->set_field_value($field['name'], ($data_array ? $data_array[$field['name']] : ''));
                                }
                                
                                $comp_model->addInput($field);
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 comp-grid">
                    <div class="form-group">
                        <label>
                            Check all subjects which the teacher should have access to:
                        </label>
                        <div>
                            <?php
                            foreach ($subjects as $subject) {
                                echo '<div class="form-check mb-2">';
                                echo '<input type="checkbox" name="subj_' . $subject['id'] . '" id="subj_' . $subject['id'] . '" ' . (in_array($subject['id'], $checked) ? 'checked' : '') . ' />';
                                echo '<label class="form-check-label" for="subj_', $subject['id'], '">', $subject['name'], '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group form-submit-btn-holder text-center">
                <button class="btn btn-primary" type="submit">
                    Save
                    <i class="fa fa-send"></i>
                </button>
            </div>
        </div>
    </form>
</section>
