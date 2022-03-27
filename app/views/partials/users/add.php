
<?php
$comp_model = new SharedController;

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>

<section class="page">
    <div  class="">
        <div class="container-fluid">

            <div class="row ">

                <div class="col-md-7 comp-grid">

                    <div  class="card animated fadeIn">
                        <?php
                        $this :: display_page_errors();
                        ?>
                        <form id="users-add-form" role="form" enctype="multipart/form-data" class="form form-horizontal needs-validation"  novalidate action="<?php print_link("users/add") ?>" method="post">
                            <div class="card-body">


                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="name">Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="name" value="<?php echo $this->set_field_value('name', ''); ?>" type="text" placeholder="<?php print_lang('students_add_name_placeholder'); ?>"  required="" name="name" class="form-control " />



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
                                                <input  id="surname" value="<?php echo $this->set_field_value('surname', ''); ?>" type="text" placeholder="<?php print_lang('students_add_surname_placeholder'); ?>"  required="" name="surname" class="form-control " />



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
                                                <input  id="user_name" value="<?php echo $this->set_field_value('user_name', ''); ?>" type="text" placeholder="<?php print_lang('users_add_user_name_placeholder'); ?>"  required="" name="user_name" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="user_email">Email Address <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="user_email" value="<?php echo $this->set_field_value('user_email', ''); ?>" type="email" placeholder="<?php print_lang('users_add_user_email_placeholder'); ?>"  required="" name="user_email" class="form-control " />



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




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="user_password_hash"><?php print_lang('user_password_hash'); ?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="user_password_hash" value="<?php echo $this->set_field_value('user_password_hash', ''); ?>" type="password" placeholder="<?php print_lang('users_add_user_password_hash_placeholder'); ?>"  required="" name="user_password_hash" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-submit-btn-holder text-center">
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
