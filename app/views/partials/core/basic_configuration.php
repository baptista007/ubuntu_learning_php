
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
                        <h3 class="record-title"><?php print_lang('edit_core'); ?></h3>

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

                    <?php $this :: display_page_errors(); ?>

                    <div  class="card animated fadeIn">
                        <form role="form" enctype="multipart/form-data"  class="form form-horizontal needs-validation" novalidate action="<?php print_link("core/basic_configuration"); ?>" method="post">
                            <div class="card-body">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="company">Client <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="company" value="<?php echo $data['company']; ?>" type="text" placeholder="<?php print_lang('enter_company'); ?>"  name="company" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="email">Email <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="email" value="<?php echo $data['email']; ?>" type="email" placeholder="<?php print_lang('enter_email'); ?>"  name="email" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="domain"><?php print_lang('domain'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="domain" value="<?php echo $data['domain']; ?>" type="text" placeholder="<?php print_lang('enter_domain'); ?>"  name="domain" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tax"><?php print_lang('tax'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="tax" value="<?php echo $data['tax']; ?>" type="text" placeholder="<?php print_lang('enter_tax'); ?>"  name="tax" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="second_tax"><?php print_lang('second_tax'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="second_tax" value="<?php echo $data['second_tax']; ?>" type="text" placeholder="<?php print_lang('enter_second_tax'); ?>"  name="second_tax" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="currency"><?php print_lang('currency'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="currency" value="<?php echo $data['currency']; ?>" type="text" placeholder="<?php print_lang('enter_currency'); ?>"  name="currency" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="invoice_terms"><?php print_lang('invoice_terms'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <textarea placeholder="<?php print_lang('enter_invoice_terms'); ?>" rows="" name="invoice_terms" class=" form-control"><?php echo $data['invoice_terms']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="company_reference"><?php print_lang('company_reference'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="company_reference" value="<?php echo $data['company_reference']; ?>" type="number" placeholder="<?php print_lang('enter_company_reference'); ?>" step="1"  name="company_reference" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="invoice_reference"><?php print_lang('invoice_reference'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="invoice_reference" value="<?php echo $data['invoice_reference']; ?>" type="number" placeholder="<?php print_lang('enter_invoice_reference'); ?>" step="1"  name="invoice_reference" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="date_format"><?php print_lang('date_format'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="date_format" class="form-control" value="<?php echo $data['date_format']; ?>" type="text" name="date_format" placeholder="<?php print_lang('enter_date_format'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="date_time_format"><?php print_lang('date_time_format'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="date_time_format" class="form-control" value="<?php echo $data['date_time_format']; ?>" type="text" name="date_time_format" placeholder="<?php print_lang('enter_date_time_format'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="pw_reset_mail_subject"><?php print_lang('pw_reset_mail_subject'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="pw_reset_mail_subject" value="<?php echo $data['pw_reset_mail_subject']; ?>" type="text" placeholder="<?php print_lang('enter_pw_reset_mail_subject'); ?>"  name="pw_reset_mail_subject" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="pw_reset_link_mail_subject"><?php print_lang('pw_reset_link_mail_subject'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="pw_reset_link_mail_subject" value="<?php echo $data['pw_reset_link_mail_subject']; ?>" type="text" placeholder="<?php print_lang('enter_pw_reset_link_mail_subject'); ?>"  name="pw_reset_link_mail_subject" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="language"><?php print_lang('language'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="language" value="<?php echo $data['language']; ?>" type="text" placeholder="<?php print_lang('enter_language'); ?>"  name="language" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="invoice_address"><?php print_lang('invoice_address'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="invoice_address" value="<?php echo $data['invoice_address']; ?>" type="text" placeholder="<?php print_lang('enter_invoice_address'); ?>"  name="invoice_address" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="invoice_city"><?php print_lang('invoice_city'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="invoice_city" value="<?php echo $data['invoice_city']; ?>" type="text" placeholder="<?php print_lang('enter_invoice_city'); ?>"  name="invoice_city" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="invoice_contact"><?php print_lang('invoice_contact'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="invoice_contact" value="<?php echo $data['invoice_contact']; ?>" type="text" placeholder="<?php print_lang('enter_invoice_contact'); ?>"  name="invoice_contact" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="invoice_tel"><?php print_lang('invoice_tel'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="invoice_tel" value="<?php echo $data['invoice_tel']; ?>" type="text" placeholder="<?php print_lang('enter_invoice_tel'); ?>"  name="invoice_tel" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="vat"><?php print_lang('vat'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="vat" value="<?php echo $data['vat']; ?>" type="text" placeholder="<?php print_lang('enter_vat'); ?>"  name="vat" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="money_currency_position"><?php print_lang('money_currency_position'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="money_currency_position" value="<?php echo $data['money_currency_position']; ?>" type="number" placeholder="<?php print_lang('enter_money_currency_position'); ?>" step="1"  name="money_currency_position" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="money_format"><?php print_lang('money_format'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="money_format" value="<?php echo $data['money_format']; ?>" type="number" placeholder="<?php print_lang('enter_money_format'); ?>" step="1"  name="money_format" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="pdf_font"><?php print_lang('pdf_font'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="pdf_font" value="<?php echo $data['pdf_font']; ?>" type="text" placeholder="<?php print_lang('enter_pdf_font'); ?>"  name="pdf_font" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="pdf_path"><?php print_lang('pdf_path'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="pdf_path" value="<?php echo $data['pdf_path']; ?>" type="number" placeholder="<?php print_lang('enter_pdf_path'); ?>" step="1"  name="pdf_path" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="invoice_prefix"><?php print_lang('invoice_prefix'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="invoice_prefix" value="<?php echo $data['invoice_prefix']; ?>" type="text" placeholder="<?php print_lang('enter_invoice_prefix'); ?>"  name="invoice_prefix" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="company_prefix"><?php print_lang('company_prefix'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="company_prefix" value="<?php echo $data['company_prefix']; ?>" type="text" placeholder="<?php print_lang('enter_company_prefix'); ?>"  name="company_prefix" class="form-control " />



                                            </div>


                                        </div>
                                    </div>
                                </div>




                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="timezone"><?php print_lang('timezone'); ?></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="timezone" class="form-control" value="<?php echo $data['timezone']; ?>" type="text" name="timezone" placeholder="<?php print_lang('enter_timezone'); ?>" />
                                            </div>


                                        </div>
                                    </div>
                                </div>




                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary" type="submit">
                                    <?php print_lang('submit'); ?>
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
