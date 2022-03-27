<?php

/**
 * Core Page Controller
 * @category  Controller
 */
class CoreController extends SecureController {
    /**
     * Edit Record Action 
     * If Not $_POST Request, Display Edit Record Form View
     * @return View
     */
    function basic_configuration($rec_id = null) {
        $db = $this->GetModel();
        if (is_post_request()) {
            $modeldata = transform_request_data($_POST);
            $rules_array = array(
                'email' => 'required|valid_email',
                'company' => 'required'
            );
            
            $is_valid = GUMP::is_valid($modeldata, $rules_array);
            if ($is_valid !== true) {
                if (is_array($is_valid)) {
                    foreach ($is_valid as $error_msg) {
                        $this->view->page_error[] = $error_msg;
                    }
                } else {
                    $this->view->page_error[] = $is_valid;
                }
            }
            if (empty($this->view->page_error)) {
                $db->where('id', 1);
                $bool = $db->update('core', $modeldata);
                if ($bool) {
                    set_flash_msg('', '');
                    redirect_to_page("core/basic_configuration");
                    return;
                } else {
                    $this->view->page_error[] = $db->getLastError();
                }
            }
        }
        $fields = array('id', 'domain', 'email', 'company', 'default_account', 'tax', 'second_tax', 'currency', 'invoice_terms', 'company_reference', 'invoice_reference', 'date_format', 'date_time_format', 'pw_reset_mail_subject', 'pw_reset_link_mail_subject', 'language', 'invoice_address', 'invoice_city', 'invoice_contact', 'invoice_tel', 'logo', 'vat', 'money_currency_position', 'money_format', 'pdf_font', 'pdf_path', 'invoice_prefix', 'company_prefix', 'timezone');
        $db->where('id', 1);
        $data = $db->getOne('core', $fields);
        $this->view->page_title = get_lang('edit_core');
        if (!empty($data)) {
            $this->view->render('core/basic_configuration.php', $data, 'main_layout.php');
        } else {
            if ($db->getLastError()) {
                $this->view->page_error[] = $db->getLastError();
            } else {
                $this->view->page_error[] = get_lang('record_not_found');
            }
            $this->view->render('core/basic_configuration.php', $data, 'main_layout.php');
        }
    }

}
