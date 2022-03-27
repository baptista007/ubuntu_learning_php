
<?php
$comp_model = new SharedController;
$data = $this->view_data;

//$rec_id = $data['__tableprimarykey'];
$page_id = Router :: $page_id;

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>

<section class="page">

    <?php
    if ($show_header == true) {
        ?>

        <div  class="bg-light p-3 mb-3">
            <div class="container-fluid">

                <div class="row ">

                    <div class="col-lg-9 comp-grid">
                        <h3 class="record-title"><?php print_lang('edit_users'); ?></h3>

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

                <div class="col-md-7 comp-grid">

                    <div  class="card animated fadeIn">
                        <?php
                        $this :: display_page_errors();
                        ?>
                        <form role="form" enctype="multipart/form-data"  class="form form-horizontal needs-validation" novalidate action="<?php print_link("users/edit/$page_id"); ?>" method="post">
                            <div class="card-body">


                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="name">Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="name" value="<?php echo $data['name']; ?>" type="text" placeholder="<?php print_lang('students_add_name_placeholder'); ?>"  required="" name="name" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="surname">Surname <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="surname" value="<?php echo $data['surname']; ?>" type="text" placeholder="<?php print_lang('students_add_surname_placeholder'); ?>"  required="" name="surname" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="user_name">Username <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="user_name" value="<?php echo $data['user_name']; ?>" type="text" placeholder="<?php print_lang('users_add_user_name_placeholder'); ?>"  required="" name="user_name" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="user_account_status"><?php print_lang('user_account_status'); ?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="user_account_status" value="<?php echo $data['user_account_status']; ?>" type="number" placeholder="<?php print_lang('users_edit_user_account_status_placeholder'); ?>" step="1"  required="" name="user_account_status" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="role">Role <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select name="role" id="role" class="form-control">
                                                    <option value="administrator"><?php print_lang('administrator'); ?></option>
                                                    <option value="supervisor"><?php print_lang('supervisor'); ?></option>
                                                    <option value="cashier"><?php print_lang('cashier'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary" type="submit">
                                    <?php print_lang('empty_record_prompt'); ?>
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
