<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section class="page">
    <div  class="">
<?php $this :: display_page_errors(); ?>
        <div id="feedback"></div>
        <form class="form form-horizontal ajax" action="<?php print_link("communication/send_sms") ?>" method="post">
            <div class="form-group form-submit-btn-holder">
                <button class="btn btn-primary" type="submit">
                    Send
                    <i class="fa fa-send"></i> 
                </button>
            </div>
            <div class="row">
                <div class="col-lg-8 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="send_to">Send To<span class="text-danger">*</span></label>
                        <div class="">
                            <select class="form-control" name="send_to" id="send_to" required="required">
                                <option value="">--select option--</option>
                                <option value="1">All residents</option>
                                <option value="2">Selected residents</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="message">Message <span class="text-danger">*</span></label>
                        <div class="">
                            <textarea name="message" id="message" maxlength="160" rows="5" class="form-control" placeholder="Enter sms message...max 160 characters." required="required"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="selected-owners" name="selected_owners" />
                </div>
                <div class="col-lg-8 col-xs-12">
                    <fieldset id="select-owner-selected-wrapper">
                        <legend>Selected Owners</legend>
                        <div id="select-owner-selected-div"></div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    function showHideSelectedOwners() {
        $('#select-owner-selected-div').html('');
        $('#selected-owners').val('');
        
        if ($('#send_to').val() === '2') {
            $('#select-owner-selected-wrapper').removeClass('hidden');
        } else {
            $('#select-owner-selected-wrapper').addClass('hidden');
        }
    }

    $(function () {
        showHideSelectedOwners();

        $('#send_to').on('change', function () {
            if ($(this).val() === '2') {
                openModalRemoteContent('<?= SITE_ADDR ?>ajax/home_owner_select_send_sms/');
            }

            showHideSelectedOwners();
        });

        $('body').on('click', '#select-owner-sms-add-btn', function () {
            let table = $('#select-owner-sms-datatable').DataTable();
            let selected = table.$("input.optioncheck:checkbox:checked", {"page": "all"});

            if (selected.length < 1) {
                $('#select-owner-sms-feedback').html('<div class="alert alert-warning">Please select one or more erven to be added.</div>');
                scrollToElement('select-owner-sms-feedback');
                return false;
            }

            let html = getSelectedOwnersTableSms(selected, 'selected-owners');
            $('#select-owner-selected-div').html(html);

            let ids = selected.map(function () {
                return $(this).val();
            }).get();

            $('#selected-owners').val(ids);
        });
    });
</script>