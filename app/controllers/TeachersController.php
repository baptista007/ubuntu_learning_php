<?php

/**
 * Users Page Controller
 * @category  Controller
 */
class TeachersController extends SecureController {

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

        $db->where("role", UserRole::teacher);
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
        $this->view->page_title = 'Teachers';
        $this->view->render('teachers/list.php', $data, 'main_layout.php');
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
            $this->view->render('teachers/view.php', $record, 'main_layout.php');
        } else {
            if ($db->getLastError()) {
                $this->view->page_error = $db->getLastError();
            } else {
                $this->view->page_error = get_lang('record_not_found');
            }
            $this->view->render('teachers/view.php', $record, 'main_layout.php');
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
    function edit($rec_id = null) {
        $this->manage($rec_id);
    }

    function manage($rec_id = null) {
        $db = $this->GetModel();

        if (is_post_request()) {
            $modeldata = $_POST;
            $rules_array = array(
                'name' => 'required',
                'surname' => 'required',
                'user_name' => 'required',
                'user_email' => 'required|valid_email'
            );

            if (empty($rec_id)) {
                $rules_array['user_password_hash'] = 'required';
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

            if (!empty($modeldata['confirm_password']) && !empty($modeldata['user_password_hash'])) {
                if ($modeldata['user_password_hash'] != $modeldata['confirm_password']) {
                    $errors[] = 'Your password confirmation is not consistent';
                }
            }
            
            $db->where("user_email", $modeldata['user_email']);
            
            if (!empty($rec_id)) {
                $db->where("id", $rec_id, "!=");
            }
            
            if ($db->has($this->tablename)) {
                $errors[] = $modeldata['user_email'] . " is already associated with another teacher.";
            }

            $subjects = $db->get(SqlTables::tbl_subjects);
            $at_least_one = false;

            foreach ($subjects as $subject) {
                if (isset($modeldata['subj_' . $subject['id']])) {
                    $at_least_one = true;
                    break;
                }
            }

            if (!$at_least_one) {
                $errors[] = 'At least one subject needs to be granted.';
            }

            if (empty($errors)) {
                $db->startTransaction();
                $teacher_data = [
                    'name' => $modeldata['name'],
                    'surname' => $modeldata['surname'],
                    'user_name' => $modeldata['user_name'],
                    'user_email' => $modeldata['user_email']
                ];

                if (!empty($modeldata['confirm_password']) && !empty($modeldata['user_password_hash'])) {
                    $teacher_data['user_password_hash'] = password_hash($modeldata['user_password_hash'], PASSWORD_DEFAULT);
                }

                if (empty($rec_id)) {
                    $teacher_data['role'] = UserRole::teacher;
                    $teacher_data['user_account_status'] = AccountStatus::active;
                    $teacher_data['email_status'] = EmailStatus::verified;
                    
                    $rec_id = $db->insert($this->tablename, $teacher_data);
                } else {
                    $db->where('id', $rec_id);
                    if (!$db->update($this->tablename, $teacher_data)) {
                        $rec_id = null;
                    }
                }

                if (!empty($rec_id)) {
                    $db->where("user_id", $rec_id);
                    $db->delete(SqlTables::tbl_user_subjects);

                    foreach ($subjects as $subject) {
                        if (isset($modeldata['subj_' . $subject['id']])) {
                            $idata = array(
                                'subject_id' => $subject['id'],
                                'user_id' => $rec_id
                            );

                            if (!$db->insert(SqlTables::tbl_user_subjects, $idata)) {
                                $errors[] = $db->getLastError();
                            }
                        }
                    }
                } else {
                    if ($db->getLastError()) {
                        $errors[] = $db->getLastError();
                    } else {
                        $errors[] = INSERT_ERROR_MSG;
                    }
                }

                if (empty($errors)) {
                    $db->commit();
                } else {
                    $db->rollback();
                }
            }

            ajaxFormPostOutcome($errors, get_link("teachers"));
            return;
        }

        if (!empty($rec_id)) {
            $db->where('id', $rec_id);
            $data = $db->getOne($this->tablename);

            if ($data) {
                $this->view->page_props = $data;
                $this->view->page_title = "Edit Teacher: " . $data['name'];
            } else {
                if ($db->getLastError()) {
                    $this->view->page_error[] = $db->getLastError();
                } else {
                    $this->view->page_error[] = RECORD_NOT_FOUND_MSG;
                }
            }
        } else {
            $data = null;
            $this->view->page_title = "Add Teacher";
        }

        $this->view->render('teachers/add.php', $data, 'main_layout.php');
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
        $bool = $db->delete($this->tablename);
        if ($bool) {
            set_flash_msg('', '');
        } else {
            if ($db->getLastError()) {
                set_flash_msg($db->getLastError(), 'danger');
            } else {
                set_flash_msg(get_lang('error_deleting_the_record_please_make_sure_that_the_record_exit'), 'danger');
            }
        }

        redirect_to_page("teachers");
    }

}
