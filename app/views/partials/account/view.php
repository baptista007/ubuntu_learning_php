
<?php
$comp_model = new SharedController;

//Page Data Information from Controller
$data = $this->view_data;

//$rec_id = $data['__tableprimarykey'];
$page_id = Router::$page_id; //Page id from url

$view_title = $this->view_title;

$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>

<section class="page">

    <?php
    if ($show_header == true) {
        ?>

        <div  class="bg-light p-3 mb-3">
            <div class="container-fluid">

                <div class="row ">

                    <div class="col-lg-9 comp-grid">
                        <h3 class="record-title"><?php print_lang('txt_account_page_title'); ?></h3>

                    </div>
                    <div class="col-xs-3 comp-grid">
                        <button class="btn btn-block btn-primary" onclick="javascript:history.go(-1)">
                            <i class="fa fa-arrow-left"></i> Back
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
    ?>

    <div  class="">
        <div class="container-fluid">

            <div class="row ">

                <div class="col-md-12 comp-grid">

                    <div  class="card animated fadeIn">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3 card p-2">
                                    <ul class="nav nav-pills flex-column text-left">
                                        <li class="nav-item"><a data-toggle="tab" href="#AccountPageView" class="nav-link active"><i class="fa fa-user"></i> <?php print_lang('txt_account_view'); ?></a></li>
                                        <li class="nav-item"><a data-toggle="tab" href="#AccountPageEdit" class="nav-link"><i class="fa fa-edit"></i> <?php print_lang('link_edit_account'); ?></a></li>
                                        <li class="nav-item"><a data-toggle="tab" href="#AccountPageChangeEmail" class="nav-link"><i class="fa fa-user"></i> <?php print_lang('link_change_email'); ?></a></li>
                                        <li class="nav-item"><a data-toggle="tab" href="#AccountPageChangePassword" class="nav-link"><i class="fa fa-key"></i> <?php print_lang('link_reset_password'); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <div class="tab-content">
                                        <div class="tab-pane show active fade" id="AccountPageView" role="tabpanel">
                                            <div class="profile-bg">
                                                <div class="profile">
                                                    <div class="avatar"><img src="<?php print_link("assets/images/avatar.png") ?>" /> </div>
                                                    <h1 class="title mt-4"><?php echo $data['user_name']; ?></h1>
                                                </div>
                                            </div>
                                            <table class="table table-hover table-borderless table-striped">
                                                <tbody>

                                                    <tr>
                                                        <th class="title"> <?php print_lang('students_list_name_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['name']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('students_list_surname_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['surname']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_user_name_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['user_name']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_user_email_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['user_email']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_user_account_status_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['user_account_status']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_super_user_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['role']; ?> </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_user_failed_logins_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['user_failed_logins']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_user_last_failed_login_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['user_last_failed_login']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_created_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['created']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('account_list_last_modified_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['modified']; ?> </td>
                                                    </tr>


                                                    <tr>
                                                        <th class="title"> <?php print_lang('students_list_id_title'); ?> :</th>
                                                        <td class="value"> <?php echo $data['id']; ?> </td>
                                                    </tr>


                                                </tbody>    
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="AccountPageEdit" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php $this->render_page("account/edit"); ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane  fade" id="AccountPageChangeEmail" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php $this->render_page("account/change_email"); ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="AccountPageChangePassword" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php $this->render_page("passwordmanager"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</section>
