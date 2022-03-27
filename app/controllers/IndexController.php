<?php

/**
 * Index Page Controller
 * @category  Controller
 */
class IndexController extends SecureController {

    /**
     * Index Action
     * Check If Current Page Is Home Page If Not Redirect to Home Page
     * @return View
     */
    function index() {
        $this->view->page_title = "Dashboard";
        $this->view->render("index/index.php", null, "main_layout.php");
    }

    function workspace($rec_id) {
        $db = $this->GetModel();
        $db->where("id", $rec_id);
        $subject = $db->getOne(SqlTables::tbl_subjects);

        if (!$subject) {
            $this->view->render("errors/record_not_found.php", null, "main_layout.php");
            return;
        }

        $this->view->page_title = 'Workspace: ' . $subject['name'];

        //Notes
        $db->where("subject_id", $rec_id);
        $db->where("user_id", USER_ID);
        $notes = $db->get(SqlTables::tbl_subject_notes);

        //Quizzes
        $db->where("subject_id", $rec_id);
        $db->where("user_id", USER_ID);
        $quizzes = $db->get(SqlTables::tbl_subject_quizzes);

        $data = new stdClass();
        $data->record = $subject;
        $data->notes = $notes;
        $data->quizzes = $quizzes;

        $this->view->render("index/workspace.php", $data, "main_layout.php");
    }

    function save_notes($subject_id) {
        $db = $this->GetModel();
        $db->where("id", $subject_id);
        $subject = $db->getOne(SqlTables::tbl_subjects);

        if (!$subject) {
            echo json_encode([
                'success' => false,
                'message' => "Could not find subject with ID " . $subject_id
            ]);

            return;
        }

        $modeldata = $_POST;
        $rules_array = array();
        $rules_array['date'] = 'required';
        $rules_array['grade'] = 'required|numeric';
        $rules_array['chapter'] = 'required';
        $rules_array['summary'] = 'required';

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
            $data = [
                'date' => $modeldata['date'],
                'grade' => $modeldata['grade'],
                'chapter' => $modeldata['chapter'],
                'summary' => $modeldata['summary'],
                'subject_id' => $subject_id,
                'user_id' => USER_ID
            ];

            if (!$db->insert(SqlTables::tbl_subject_notes, $data)) {
                if ($db->getLastError()) {
                    $errors[] = $db->getLastError();
                } else {
                    $errors[] = INSERT_ERROR_MSG;
                }
            }
        }

        ajaxFormPostOutcome($errors, get_link("index/workspace/" . $subject_id));
        return;
    }

    function quiz($subject_id, $quiz_id = null) {
        $db = $this->GetModel();
        $db->where("id", $subject_id);
        $subject = $db->getOne(SqlTables::tbl_subjects);

        if (!$subject) {
            echo json_encode([
                'success' => false,
                'message' => "Could not find subject with ID " . $subject_id
            ]);

            return;
        }

        if (is_post_request()) {
            $modeldata = $_POST;
            $rules_array = array();
            $rules_array['title'] = 'required';
            $rules_array['grade'] = 'required|numeric';
            $rules_array['duration'] = 'required|numeric';

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

            if (empty($modeldata["questions"])) {
                $errors[] = "At least one question is required for the quiz.";
            } else {
                foreach ($modeldata["questions"] as $ekey => $question) {
                    if (empty($question["question"])) {
                        $errors[] = "Question " . ($ekey + 1) . " does not have a valid value.";
                    }

                    if (empty($question["options"])) {
                        $errors[] = "Question " . ($ekey + 1) . " does not have valid answer options.";
                    }
                }
            }

            if (empty($errors)) {
                $db->startTransaction();

                $data = [
                    'title' => $modeldata['title'],
                    'grade' => $modeldata['grade'],
                    'duration' => $modeldata['duration'],
                ];
                
                //Reset existing questions/options if existing
                if (!empty($quiz_id)) {
                    $db->where("quiz_id", $quiz_id);
                    $questions = $db->get(SqlTables::tbl_quiz_questions);

                    foreach ($questions as $question) {
                        $db->where("quiz_question_id", $question['id']);
                        $db->delete(SqlTables::tbl_quiz_question_options);

                        $db->where("id", $question['id']);
                        $db->delete(SqlTables::tbl_quiz_questions);
                    }
                }

                if (empty($quiz_id)) {
                    $data['status'] = UserStatus::active;
                    $data['subject_id'] = $subject_id;
                    $data['user_id'] = USER_ID;

                    $quiz_id = $db->insert(SqlTables::tbl_subject_quizzes, $data);
                } else {
                    $db->where('id', $quiz_id);
                    if (!$db->update(SqlTables::tbl_subject_quizzes, $data)) {
                        $quiz_id = null;
                    }
                }

                

                if ($quiz_id) {
                    foreach ($modeldata["questions"] as $ekey => $question) {
                        $qdata = [
                            'quiz_id' => $quiz_id,
                            'question' => $question['question'],
                            'correct_value' => $question['correct_option']['value']
                        ];
                        
                        $qid = $db->insert(SqlTables::tbl_quiz_questions, $qdata);

                        if ($qid) {
                            foreach ($question["options"] as $okey => $option) {
                                if (empty($option['value'])) {
                                    continue;
                                }
                                
                                $odata = [
                                    'quiz_question_id' => $qid,
                                    'text' => $option['value'],
                                    'value' => $option['value'],
                                    'error_note' => $option['error_note'],
                                ];

                                if (!$db->insert(SqlTables::tbl_quiz_question_options, $odata)) {
                                    $errors[] = "Error inserting option " . ($okey + 1) . " of question " . ($ekey + 1) . ".";
                                }
                            }
                        } else {
                            $errors[] = "Error inserting question " . ($ekey + 1) . ".";
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
            
            ajaxFormPostOutcome($errors, get_link("index/workspace/" . $subject_id));
            return;
        }

        if ($quiz_id) {
            $db->where("id", $quiz_id);
            $data = $db->getOne(SqlTables::tbl_subject_quizzes);
            
            if (!$data) {
                $this->view->page_error = "Can not find quiz with ID $quiz_id.";
                $this->view->render("index/quiz.php", null, "main_layout.php");
                return;
            }
            
            $db->where("quiz_id", $quiz_id);
            $questions = $db->get(SqlTables::tbl_quiz_questions);

            foreach ($questions as $key => $question) {
                $db->where("quiz_question_id", $question['id']);
                $question_options = $db->get(SqlTables::tbl_quiz_question_options);
                $questions[$key]['options'] = $question_options;
            }
            
            $data['questions'] = $questions;
            $this->view->page_title = 'Edit Quiz: ' . $data['title'];
        } else {
            $this->view->page_title = 'New Quiz: ' . $subject['name'];
            $data = null;
        }
        
        $this->view->render("index/quiz.php", $data, "main_layout.php");
    }

    /**
     * Change User Language
     * @return null
     */
    function change_language($lang) {
        set_session('lang', $lang);
        redirect_to_page(DEFAULT_PAGE);
    }

}
