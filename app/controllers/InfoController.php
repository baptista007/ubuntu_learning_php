<?php

/**
 * Info Contoller Class
 * @category  Controller
 */
class InfoController extends BaseController {
    function __construct() {
        parent::__construct();
        $this->tablename = SqlTables::tbl_users;
    }
    
    /**
     * Display About us page
     * @return Html View
     */
    function index() {
        $this->view->render("info/welcome.php", null, "welcome_layout.php");
    }
    
    function login() {
        if (is_post_request()) {
            $modeldata = $this->modeldata = $_POST;
            $username = trim($modeldata['username']);
            $password = $modeldata['password'];
            $rememberme = (!empty($modeldata['rememberme']) ? $modeldata['rememberme'] : false);
            $this->login_user($username, $password, $rememberme);
        } else {
            $this->render_view("info/login.php", null, "login_layout.php");
        }
    }

    private function login_user($username, $password_text, $rememberme = false) {
        $db = $this->GetModel();
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $db->where("user_name", $username)->orWhere("user_email", $username);
        $tablename = $this->tablename;
        $user = $db->getOne($tablename);
        $errors = array();
        $redirect_url = null;

        if (!empty($user)) {
            // Check If User Email Is Verified
            if (strtolower($user['email_status']) != EmailStatus::verified) {
                $errors[] = "Your email address is not verified.";
            }

            if ($user['user_account_status'] != AccountStatus::active) {
                $errors[] = "Your account is inactive. Please contact support.";
            }

            //Verify User Password Text With DB Password Hash Value.
            //Uses PHP password_verify() function with default options
            $user_password_hash = $user['user_password_hash'];

            if (empty($errors)) {
                if (password_verify($password_text, $user_password_hash)) {
                    unset($user['user_password_hash']); //Remove user password. No need to store it in the session
                    set_session("user_data", $user); // Set active user data in a sessions
                    $this->write_to_log("userlogin", "true");

                    //if Remeber Me, Set Cookie
                    if ($rememberme == true) {
                        $sessionkey = time() . random_str(20); // Generate a session key for the user
                        //Update user session info in database with the session key
                        $db->where("id", $user['id']);
                        $res = $db->update($tablename, array("login_session_key" => hash_value($sessionkey)));

                        if (!empty($res)) {
                            set_cookie("login_session_key", $sessionkey); // save user login_session_key in a Cookie
                        }
                    } else {
                        clear_cookie("login_session_key"); // Clear any previous set cookie
                    }

                    $redirect_url = get_session("login_redirect_url"); // Redirect to user active page

                    if (!empty($redirect_url)) {
                        clear_session("login_redirect_url");
                        $redirect_url = $redirect_url;
                    } else {
                        $redirect_url = get_link("index");
                    }
                } else {
                    //password is not correct
                    $errors[] = "Password incorrect.";
                }
            }
        } else {
            //user is not registered
            $errors[] = "Account does not exist.";
        }

        ajaxFormPostOutcome($errors, $redirect_url, "Welcome to Ubuntu Learning.");
        return;
    }

    function logout() {
        session_destroy();
        $this->redirect();
    }
    
    /**
     * Display About us page
     * @return Html View
     */
    function about() {
        $this->view->render("info/about.php", null, "welcome_layout.php");
    }

    /**
     * Display Help Page
     * @return Html View
     */
    function help() {
        $this->view->render("info/help.php", null, "welcome_layout.php");
    }

    /**
     * Display Features Page
     * @return Html View
     */
    function features() {
        $this->view->render("info/features.php", null, "welcome_layout.php");
    }

    /**
     * Display Privacy Policy Page
     * @return Html View
     */
    function privacy_policy() {
        $this->view->render("info/privacy_policy.php", null, "welcome_layout.php");
    }

    /**
     * Display Terms And Conditions Page
     * @return Html View
     */
    function terms_and_conditions() {
        $this->view->render("info/terms_and_conditions.php", null, "welcome_layout.php");
    }

    /**
     * Display Contact us Page
     * @return Html View
     */
    function contact() {
        if (!empty($_POST)) {
            $email = $_POST['email'];
            $name = $_POST['name'];
            $msg = $_POST['msg'];
            $title = "New Contact us Message From $name";

            $mailer = new Mailer;

            $mailer->From = $email;
            $mailer->FromName = $name;

            $mailer->send_mail(DEFAULT_EMAIL, $title, $msg);

            redirect_to_action("contact_sent");
        } else {
            $this->view->render("info/contact.php", null, "welcome_layout.php");
        }
    }

    /**
     * Display Contact Success Page After Sending Form
     * @return Html View
     */
    function contact_sent() {
        $this->view->render("info/contact_sent.php", null, "welcome_layout.php");
    }

    /**
     * Display Change default language page
     * @return Html View
     */
    function change_language($lang = null) {
        if (!empty($lang)) {
            set_cookie('lang', $lang);
            redirect_to_page(DEFAULT_PAGE);
        } else {
            $this->view->render("info/change_language.php", null, "welcome_layout.php");
        }
    }

}
