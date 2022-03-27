<?php
$comp_model = new SharedController;
$csrf_token = Csrf::$token;
//Page Data Information from Controller

$data = $this->view_data;

//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;

$rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
?>
<section class="page">
    <?php
    if ($show_header == true) {
        HTML::addGoBackButtonRow();
    }
    ?>
    <div  class="">
        <?php $this :: display_page_errors(); ?>

        <div class="row">
            <div class="col-lg-12">
                <div  class="card animated fadeIn page-content">
                    <div class="card-header">
                        <h5 class="card-title">Subject Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-borderless table-striped">
                            <!-- Table Body Start -->
                            <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                <tr  class="td-name">
                                    <th class="title">Name: </th>
                                    <td class="value"> 
                                        <?php echo $data['name']; ?> 
                                    </td>
                                </tr>
                                <tr  class="td-name">
                                    <th class="title">Date of birth: </th>
                                    <td class="value"> 
                                        <?= human_date($data['dob']); ?> 
                                    </td>
                                </tr>
                                <tr  class="td-name">
                                    <th class="title">School: </th>
                                    <td class="value">
                                        <?= $this->addTdContSafe('school_id', $data, $comp_model->schools_value_name()) ?> 
                                    </td>
                                </tr>
                                <tr  class="td-name">
                                    <th class="title">Grade: </th>
                                    <td class="value">
                                        <?php echo $data['grade']; ?> 
                                    </td>
                                </tr>
                                <tr  class="td-name">
                                    <th class="title">Cellphone: </th>
                                    <td class="value">
                                        <?php echo $data['cellphone']; ?> 
                                    </td>
                                </tr>
                                <tr  class="td-created">
                                    <th class="title">Date Created: </th>
                                    <td class="value"> <?= human_datetime($data['created']) ?></td>
                                </tr>
                                <tr  class="td-updatetd">
                                    <th class="title">Date Modified: </th>
                                    <td class="value"> <?= human_datetime($data['modified']); ?></td>
                                </tr>
                            </tbody>
                            <!-- Table Body End -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>