<?php

/**
 * Clients Page Controller
 * @category  Controller
 */
class SchoolsController extends SecureController {
    function __construct() {
        parent::__construct();
        $this->tablename = SqlTables::tbl_schools;
        $this->fields = [
            'id', 'name', 'region_id', 'created', 'modified'
        ];
    }

    /**
     * Load Record Action 
     * $arg1 Field Name
     * $arg2 Field Value 
     * $param $arg1 string
     * $param $arg1 string
     * @return View
     */
    function index($fieldname = null, $fieldvalue = null) {
        $db = $this->GetModel();
        $limit = $this->get_pagination(MAX_RECORD_COUNT); // return pagination from BaseModel Class e.g array(5,20)
        
        if (!empty($this->search)) {
            $text = $this->search;
            $db->orWhere('id', "%$text%", 'LIKE');
            $db->orWhere('name', "%$text%", 'LIKE');
            $db->orWhere('description', "%$text%", 'LIKE');
        }
        
        if (!empty($this->orderby)) { // when order by request fields (from $_GET param)
            $db->orderBy($this->orderby, $this->ordertype);
        } else {
            $db->orderBy('id', ORDER_TYPE);
        }
        
        if (!empty($fieldname)) {
            $db->where($fieldname, $fieldvalue);
        }
        //page filter command
        $tc = $db->withTotalCount();
        $records = $db->get($this->tablename, $limit, $this->fields);
        $data = new stdClass;
        $data->records = $records;
        $data->record_count = count($records);
        $data->total_records = intval($tc->totalCount);
        if ($db->getLastError()) {
            $this->view->page_error = $db->getLastError();
        }
        $this->view->page_title = 'Schools';
        $this->view->render('schools/list.php', $data, 'main_layout.php');
    }

    /**
     * View Record Action 
     * @return View
     */
    function view($rec_id) {
        $db = $this->GetModel();
        $db->where('id', $rec_id);
        $record = $db->getOne($this->tablename, $this->fields);
        if (!empty($record)) {
            $this->view->page_title = 'View School: ' . $record['name'];
            $this->view->render('schools/view.php', $record, 'main_layout.php');
        } else {
            if ($db->getLastError()) {
                $this->view->page_error = $db->getLastError();
            } else {
                $this->view->page_error = get_lang('record_not_found');
            }
            
            $this->view->render('error/record_not_found.php', $record, 'main_layout.php');
        }
    }

    /**
     * Add New Record Action 
     * If Not $_POST Request, Display Add Record Form View
     * @return View
     */
    function add() {
        $this->manage();
    }

    /**
     * Edit Record Action 
     * If Not $_POST Request, Display Edit Record Form View
     * @return View
     */
    function edit($rec_id) {
        $this->manage($rec_id);
    }
    
    function manage($rec_id = null) {
        $db = $this->GetModel();

        if (is_post_request()) {
            $modeldata = $_POST;
            $rules_array = array();
            $rules_array['name'] = 'required';
            $rules_array['region_id'] = 'required|numeric';

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
                if (empty($rec_id)) {
                    $rec_id = $db->insert($this->tablename, $modeldata);
                } else {
                    $db->where('id', $rec_id);
                    if (!$db->update($this->tablename, $modeldata)) {
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

            ajaxFormPostOutcome($errors, get_link("schools"));
            return;
        }

        if (!empty($rec_id)) {
            $db->where('id', $rec_id);
            $data = $db->getOne($this->tablename);

            if ($data) {
                $this->view->page_props = $data;
                $this->view->page_title = "Edit School: " . $data['name'];
            } else {
                if ($db->getLastError()) {
                    $this->view->page_error[] = $db->getLastError();
                } else {
                    $this->view->page_error[] = RECORD_NOT_FOUND_MSG;
                }
            }
        } else {
            $data = null;
            $this->view->page_title = "Add School";
        }

        $this->view->render('schools/add.php', $data, 'main_layout.php');
    }

    /**
     * Delete Record Action 
     * @return View
     */
    function delete($rec_ids = null) {
        $db = $this->GetModel();
        $arr_id = explode(',', $rec_ids);
        foreach ($arr_id as $rec_id) {
            $db->where('id', $rec_id, "=", 'OR');
        }
        $bool = $db->delete(SqlTables::tbl_schools);
        if ($bool) {
            set_flash_msg('', '');
        } else {
            if ($db->getLastError()) {
                set_flash_msg($db->getLastError(), 'danger');
            } else {
                set_flash_msg("An error occurred while deleting the record.", 'danger');
            }
        }
        redirect_to_page("schools");
    }
}
