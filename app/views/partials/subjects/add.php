
<?php
$comp_model = new SharedController;
$db = $comp_model->GetModel();

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$page_id = Router::$page_id;

$data_array = $this->view_data;
?>
<section class="page">
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn">
                        <form id="clients-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal needs-validation ajax"  novalidate action="<?= get_link("subjects/manage" . (!empty(Router::$page_id) ? '/' . Router::$page_id : '')) . '?csrf_token=' . Csrf::$token ?>" method="post">
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
                                    'name' => 'description',
                                    'type' => InputType::textarea,
                                    'label' => 'Description',
                                    'required' => false
                                );

                                $fields[] = array(
                                    'name' => 'grade_start',
                                    'type' => InputType::select,
                                    'label' => 'Grade Start',
                                    'options' => Getters::$grades,
                                    'required' => true,
                                    'default_label' => '--select grade--'
                                );
                                
                                $fields[] = array(
                                    'name' => 'grade_stop',
                                    'type' => InputType::select,
                                    'label' => 'Grade Stop',
                                    'options' => Getters::$grades,
                                    'required' => true,
                                    'default_label' => '--select grade--'
                                );

                                foreach ($fields as $field) {
                                    $field['value'] = $this->set_field_value($field['name'], ($data_array ? $data_array[$field['name']] : ''));
                                    $comp_model->addInput($field);
                                }
                                ?>
                            </div>
                            <div class="form-group form-submit-btn-holder text-center">
                                <button class="btn btn-primary" type="submit">
                                    Save
                                    <i class="fa fa-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
