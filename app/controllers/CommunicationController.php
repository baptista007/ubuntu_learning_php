<?php

class CommunicationController extends SecureController {
    function sms() {
        $db = $this->GetModel();
        $db->where("type", CommunicationType::sms);
        $coms = $db->get('tbl_communication');
        $this->view->page_title = 'Bulk SMS';
        $this->view->render('communication/sms.php', $coms, 'main_layout.php');
    }
    
    function email() {
        $db = $this->GetModel();
        $db->where("type", CommunicationType::email);
        $coms = $db->get('tbl_communication');
        
        $this->view->page_title = 'Bulk Email';
        $this->view->render('communication/email.php', $coms, 'main_layout.php');
    }
    
    function send_sms($rec_id = null) {
        $db = $this->GetModel();
        
        if (is_post_request()) {
            $modeldata = $_POST;
            $rules_array = array();
            $rules_array['send_to'] = 'required|numeric';
            $rules_array['message'] = 'required';
            
            if ($_POST['send_to'] == CommsSendTo::selected) {
                $rules_array['selected_owners'] = 'required';
            }
            
            $is_valid = GUMP::is_valid($modeldata, $rules_array);
            $errors = array();
            if ($is_valid !== true) {
                if (is_array($is_valid)) {
                    foreach ($is_valid as $error_msg) {
                        $errors[] = $error_msg;
                    }
                } else {
                    $errors[] = $is_valid;
                }
            }

            if (empty($errors)) {
                $insert_data = array(
                    'type' => CommunicationType::sms,
                    'send_to' => $modeldata['send_to'],
                    'message' => $modeldata['message']
                );
                
                if (empty($rec_id)) {
                    $rec_id = $db->insert('tbl_communication', $insert_data);
                } else {
                    $db->where('id', $rec_id);
                    if (!$db->update('tbl_communication', $insert_data)) {
                        $rec_id = null;
                    }
                }

                if (empty($rec_id)) {
                    if ($db->getLastError()) {
                        $errors[] = $db->getLastError();
                    } else {
                        $errors[] = INSERT_ERROR_MSG;
                    }
                }
            }

            ajaxFormPostOutcome($errors, get_link("communication/sms"), "Message saved for sending.");
            return;
        }
        
        $this->view->page_title = 'Send SMS';
        $this->view->render('communication/send_sms.php', null, 'main_layout.php');
    }
    
    function send_email() {
        $db = $this->GetModel();
        
        if (is_post_request()) {
            $modeldata = $_POST;
            $rules_array = array();
            $rules_array['send_to'] = 'required|numeric';
            $rules_array['subject'] = 'required';
            $rules_array['message'] = 'required';
            
            if ($_POST['send_to'] == CommsSendTo::selected) {
                $rules_array['selected_owners'] = 'required';
            }
            
            $is_valid = GUMP::is_valid($modeldata, $rules_array);
            $errors = array();
            if ($is_valid !== true) {
                if (is_array($is_valid)) {
                    foreach ($is_valid as $error_msg) {
                        $errors[] = $error_msg;
                    }
                } else {
                    $errors[] = $is_valid;
                }
            }

            if (empty($errors)) {
                $insert_data = array(
                    'type' => CommunicationType::email,
                    'send_to' => $modeldata['send_to'],
                    'subject' => $modeldata['subject'],
                    'message' => $modeldata['message']
                );
                
                if (empty($rec_id)) {
                    $rec_id = $db->insert('tbl_communication', $insert_data);
                } else {
                    $db->where('id', $rec_id);
                    if (!$db->update('tbl_communication', $insert_data)) {
                        $rec_id = null;
                    }
                }

                if (empty($rec_id)) {
                    if ($db->getLastError()) {
                        $errors[] = $db->getLastError();
                    } else {
                        $errors[] = INSERT_ERROR_MSG;
                    }
                }
            }

            ajaxFormPostOutcome($errors, get_link("communication/sms"), "Message saved for sending.");
            return;
        }
        
        $this->view->page_title = 'Send Email';
        $this->view->render('communication/send_email.php', null, 'main_layout.php');
    }
}

