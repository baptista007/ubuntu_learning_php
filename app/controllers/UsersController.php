<?php

/**
 * Users Page Controller
 * @category  Controller
 */
class UsersController extends SecureController {
    function __construct() {
        parent::__construct();
        $this->tablename = SqlTables::tbl_users;
        $this->fields = [
            'id', 'name', 'surname', 'user_name', 'user_email', 'user_password_hash', 'user_account_status', 'role', 'user_failed_logins', 'user_last_failed_login', 'created', 'modified'
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
            $db->orWhere('name', "%$text%", 'LIKE');
            $db->orWhere('surname', "%$text%", 'LIKE');
            $db->orWhere('user_name', "%$text%", 'LIKE');
            $db->orWhere('user_email', "%$text%", 'LIKE');
            $db->orWhere('user_password_hash', "%$text%", 'LIKE');
            $db->orWhere('user_account_status', "%$text%", 'LIKE');
            $db->orWhere('role', "%$text%", 'LIKE');
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
        $this->view->page_title = get_lang('users');
        $this->view->render('users/list.php', $data, 'main_layout.php');
    }


    /**
     * View Record Action 
     * @return View
     */
    function view($rec_id = null, $value = null) {
        $db = $this->GetModel();
        if (!empty($value)) {
            $db->where($rec_id, urldecode($value));
        } else {
            $db->where('id', $rec_id);
        }
        $record = $db->getOne($this->tablename, $this->fields);
        if (!empty($record)) {
            $this->view->page_title = get_lang('view_users');
            $this->view->render('users/view.php', $record, 'main_layout.php');
        } else {
            if ($db->getLastError()) {
                $this->view->page_error = $db->getLastError();
            } else {
                $this->view->page_error = get_lang('record_not_found');
            }
            $this->view->render('users/view.php', $record, 'main_layout.php');
        }
    }

    /**
     * Add New Record Action 
     * If Not $_POST Request, Display Add Record Form View
     * @return View
     */
    function add() {
        if (is_post_request()) {
            $modeldata = transform_request_data($_POST);
            $rules_array = array(
                'name' => 'required',
                'surname' => 'required',
                'user_name' => 'required',
                'user_email' => 'required|valid_email',
                'user_password_hash' => 'required',
                'role' => 'required'
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
            $cpassword = $modeldata['confirm_password'];
            $password = $modeldata['user_password_hash'];
            if ($cpassword != $password) {
                $this->view->page_error[] = get_lang('your_password_confirmation_is_not_consistent');
            }
            unset($modeldata['confirm_password']);
            $password_text = $modeldata['user_password_hash'];
            $modeldata['user_password_hash'] = password_hash($password_text, PASSWORD_DEFAULT);
            if (empty($this->view->page_error)) {
                $db = $this->GetModel();
                $rec_id = $db->insert('users', $modeldata);
                if (!empty($rec_id)) {
                    set_flash_msg('', '');
                    redirect_to_page("users");
                    return;
                } else {
                    if ($db->getLastError()) {
                        $this->view->page_error[] = $db->getLastError();
                    } else {
                        $this->view->page_error[] = get_lang('error_inserting_record');
                    }
                }
            }
        }
        $this->view->page_title = get_lang('add_new_users');
        $this->view->render('users/add.php', null, 'main_layout.php');
    }

    /**
     * Edit Record Action 
     * If Not $_POST Request, Display Edit Record Form View
     * @return View
     */
    function edit($rec_id = null) {
        $db = $this->GetModel();
        if (is_post_request()) {
            $modeldata = transform_request_data($_POST);
            $rules_array = array(
                'name' => 'required',
                'surname' => 'required',
                'user_name' => 'required',
                'user_email' => 'required|valid_email',
                'user_password_hash' => 'required',
                'user_account_status' => 'required|numeric',
                'role' => 'required|numeric',
                'user_failed_logins' => 'required|numeric',
                'user_last_failed_login' => 'required|numeric',
                'created' => 'required',
                'modified' => 'required',
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
                $db->where('id', $rec_id);
                $bool = $db->update('users', $modeldata);
                if ($bool) {
                    set_flash_msg('', '');
                    redirect_to_page("users");
                    return;
                } else {
                    $this->view->page_error[] = $db->getLastError();
                }
            }
        }

        $db->where('id', $rec_id);
        $data = $db->getOne($this->tablename, $this->fields);
        $this->view->page_title = get_lang('edit_users');
        if (!empty($data)) {
            $this->view->render('users/edit.php', $data, 'main_layout.php');
        } else {
            if ($db->getLastError()) {
                $this->view->page_error[] = $db->getLastError();
            } else {
                $this->view->page_error[] = get_lang('record_not_found');
            }
            $this->view->render('users/edit.php', $data, 'main_layout.php');
        }
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
        $bool = $db->delete('users');
        if ($bool) {
            set_flash_msg('', '');
        } else {
            if ($db->getLastError()) {
                set_flash_msg($db->getLastError(), 'danger');
            } else {
                set_flash_msg(get_lang('error_deleting_the_record_please_make_sure_that_the_record_exit'), 'danger');
            }
        }
        redirect_to_page("users");
    }
}
