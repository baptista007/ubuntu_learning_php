<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxController extends SecureController {

    function getStandardErfQuery() {
        return "SELECT 
                    tbl_erf.id, 
                    erf_number, 
                    street_address, 
                    erf_size, 
                    extension_id,
                    developer_id,
                    zoning_id,
                    dev_cell_id,
                    tbl_erf.created, 
                    tbl_erf.modified, 
                    tbl_zoning.name as zoning, 
                    tbl_extension.name as extension, 
                    tbl_developer.name as developer 
                FROM tbl_erf 
                    LEFT JOIN tbl_zoning ON tbl_erf.zoning_id = tbl_zoning.id 
                    LEFT JOIN tbl_extension ON tbl_erf.extension_id = tbl_extension.id 
                    LEFT JOIN tbl_developer ON tbl_erf.developer_id = tbl_developer.id
                WHERE true";
    }

    function erf_selection($id, $title = null) {
        $selected = explode(',', $_POST['data']);
        $db = $this->GetModel();
        $query = $this->getStandardErfQuery();
//        $query .= " AND tbl_erf.dev_cell_id IS NULL";

        $records = $db->rawQuery($query);
        $data = new stdClass;
        $data->records = $records;
        $data->record_count = count($records);
        $data->id = $id;
        $data->title = $title;
        $data->selected = $selected;
        $this->view->render('ajax/erf_selection.php', $data, 'ajax_layout.php');
    }

    function unsold_erf_json() {
        $db = $this->GetModel();
        $query = $this->getStandardErfQuery();
        $query .= " AND tbl_erf.sales_contract_id IS NULL";
        echo json_encode($db->rawQuery($query));
    }

    function unsold_erf_selection($id, $title = null) {
        $db = $this->GetModel();
        $query = $this->getStandardErfQuery();
        $query .= " AND tbl_erf.sales_contract_id IS NULL";

        $records = $db->rawQuery($query);
        $data = new stdClass;
        $data->records = $records;
        $data->record_count = count($records);
        $data->id = $id;
        $data->title = $title;
        $this->view->render('ajax/erf_selection.php', $data, 'ajax_layout.php');
    }

    function erf_select_from_sc($id, $sc_id, $title = null) {
        $db = $this->GetModel();
        $query = $this->getStandardErfQuery();
        $query .= " AND tbl_erf.sales_contract_id = $sc_id";

        $records = $db->rawQuery($query);
        $data = new stdClass;
        $data->records = $records;
        $data->record_count = count($records);
        $data->id = $id;
        $data->title = $title;
        $this->view->render('ajax/erf_selection.php', $data, 'ajax_layout.php');
    }

    function unlinked_erf_json() {
        $db = $this->GetModel();
        $query = "select * from tbl_erf where id not in (select development_cell_id from tbl_development_cell_erf)";
        echo json_encode($db->rawQuery($query));
    }

    function get_developer_contracts($dev_id) {
        $sc_controller = new SharedController();
        $opts = $sc_controller->get_developer_sc_options($dev_id);

        if (!empty($opts)) {
            echo '<option value="">--select sales contract--</option>';

            foreach ($opts as $opt) {
                echo '<option value="', $opt['value'], '">', $opt['label'], '</option>';
            }
        } else {
            echo '-1';
        }
    }

    function erf_plans_upload($rec_id) {
        $errors =  array();
        
        if (is_post_request()) {
            $filepaths = "";

            $file_array = array(
                Documents::concept_houseplan => "concept_house_plans",
                Documents::three_dimen_drawing => "three_dimensional_drawings",
                Documents::finishing_schedule_color_scheme => "finish_and_color_scheme",
                Documents::pricing_model => "pricing_model",
                Documents::quality_control_plan => "qa_plan",
                Documents::st_bc_reg_method_statement => "reg_method"
            );

            foreach ($file_array as $key => $name) {
                if (!empty($_FILES[$name])) {
                    $uploader = new Uploader();

                    $upload_config = array(
                        'maxSize' => CUSTOM_MAX_UPLOAD_SIZE,
                        'limit' => 1,
                        'extensions' => getAllowedExtensions(),
                        'uploadDir' => UPLOAD_FILE_DIR,
                        'required' => false,
                        'returnfullpath' => true,
                        'removeFiles' => true
                    );

                    $upload_data = $uploader->upload($_FILES[$name], $upload_config);

                    if ($upload_data['isComplete']) {
                        $filepaths = $upload_data['data']['metas'];
                    }

                    if ($upload_data['isSuccess']) {
                        $db = PDODb::getInstance();

                        if (!is_array($filepaths)) {
                            $filepaths = array($filepaths);
                        }

                        foreach ($filepaths as $file) {
                            $data = array(
                                'linking_entity_type' => FileLinkingEntity::erf,
                                'link_id' => $rec_id,
                                'document_type_id' => $key,
                                'path' => $file['name'],
                                'original_name' => $file['old_name']
                            );

                            if (!$db->insert("tbl_file", $data)) {
                                $errors[] = $db->getLastError();
                            }
                        }
                    } else {
                        if ($upload_data['hasErrors']) {
                            $upload_errors = $upload_data['errors'];
                            foreach ($upload_errors as $key => $val) {

                                //you can pass upload errors to the view
                                $errors[] = $val[0];
                            }
                        } else {
                            $errors[] = "Upload encountered an error.";
                        }
                    }
                }
            }

            ajaxFormPostOutcome($errors);
            exit();
        }

        $this->view->render('ajax/erf_building_plan_upload.php', $rec_id, 'ajax_layout.php');
    }
    
    function home_owner_select_send_sms() {
        $db = $this->GetModel();
        $db->join("tbl_erf", "tbl_erf.id=tbl_owner.erf_id");
        $db->join('tbl_zoning', "tbl_erf.zoning_id = tbl_zoning.id", "LEFT");
        $db->join('tbl_extension', "tbl_erf.extension_id = tbl_extension.id", "LEFT");
        $db->where("phone_numbers IS NOT NULL");
        
        $fields = array(
            "tbl_owner.id",
            "tbl_owner.first_name",
            "tbl_owner.last_name",
            "tbl_owner.phone_numbers",
            "tbl_erf.erf_number",
            "tbl_erf.street_address",
            "tbl_erf.erf_size",
            "tbl_zoning.name as zoning",
            "tbl_extension.name as extension"
        );
        
        $records = $db->get('tbl_owner', null, $fields);
        $data = new stdClass;
        $data->records = $records;
        $data->record_count = count($records);
        $data->selected = array();
        $this->view->render('ajax/comm_sms_select_owner.php', $data, 'ajax_layout.php');
    }
    
    function home_owner_select_send_email() {
        $db = $this->GetModel();
        $db->join("tbl_erf", "tbl_erf.id=tbl_owner.erf_id");
        $db->join('tbl_zoning', "tbl_erf.zoning_id = tbl_zoning.id", "LEFT");
        $db->join('tbl_extension', "tbl_erf.extension_id = tbl_extension.id", "LEFT");
        $db->where("email_addresses IS NOT NULL");
        
        $fields = array(
            "tbl_owner.id",
            "tbl_owner.first_name",
            "tbl_owner.last_name",
            "tbl_owner.email_addresses",
            "tbl_erf.erf_number",
            "tbl_erf.street_address",
            "tbl_erf.erf_size",
            "tbl_zoning.name as zoning",
            "tbl_extension.name as extension"
        );
        
        $records = $db->get('tbl_owner', null, $fields);
        $data = new stdClass;
        $data->records = $records;
        $data->record_count = count($records);
        $data->selected = array();
        $this->view->render('ajax/comm_email_select_owner.php', $data, 'ajax_layout.php');
    }
    
    function delete_files($rec_ids) {
        $db = $this->GetModel();
        $arr_id = explode(',', $rec_ids);
        $errors = array();

        $db->startTransaction();

        foreach ($arr_id as $rec_id) {
            $db->where('id', $rec_id, "=", 'OR');
        }

        if (!$db->delete('tbl_file')) {
            if ($db->getLastError()) {
                $errors[] = $db->getLastError();
            } else {
                $errors[] = DELETE_RECORD_MSG;
            }
        }

        if (empty($errors)) {
            $db->commit();
            set_flash_msg('Files deleted.', '');
        } else {
            $db->rollback();

            $error_msg = "The following errors were encountered while deleting files: <ul>";

            foreach ($errors as $value) {
                $error_msg .= "<li>" . $value . "</li>";
            }

            $error_msg .= "</ul>";
            set_flash_msg($error_msg, 'danger');
        }
        
        redirect_to_page();
    }
}
