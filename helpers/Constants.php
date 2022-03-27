<?php

final class SqlTables {

    const tbl_app_logs = "tbl_app_logs";
    const tbl_field_options = "tbl_field_options";
    const tbl_permissions = "tbl_permissions";
    const tbl_role_permissions = "tbl_role_permissions";
    const tbl_roles = "tbl_roles";
    const tbl_users = "tbl_users";
    const tbl_file_uploads = "tbl_file_uploads";
    const tbl_core = "tbl_core";
    const tbl_subjects = "tbl_subjects";
    const tbl_schools = "tbl_schools";
    const tbl_learners = "tbl_learners";
    const tbl_user_subjects = "tbl_user_subjects";
    const tbl_subject_notes = "tbl_subject_notes";
    const tbl_subject_quizzes = "tbl_subject_quizzes";
    const tbl_quiz_questions = "tbl_quiz_questions";
    const tbl_quiz_question_options = "tbl_quiz_question_options";
}

final class InputType {

    const text = 1;
    const password = 2;
    const submit = 3;
    const hidden = 4;
    const button = 5;
    const checkbox = 6;
    const date = 7;
    const number = 8;
    const radio = 9;
    const select = 10;
    const textarea = 11;
    const datetime = 12;
    const datemonth = 13;
    const color = 14;
    const checkgroup = 15;
    const radiogroup = 16;
    const file = 17;
    const filter_date_from_to = 18;
    const filter_year_from_to = 19;

}

final class FieldOptions {
    const market_status = 1;
    const product_status = 2;
    const bidding_result = 3;
    const user_status = 3;
    const yes_no = 4;
}

final class FileType {

    const cover_photo = 1;
    const pop = 2;

}

final class AccountStatus {

    const active = 1;
    const inactive = 2;
    const pending = 9;

}

final class UserAccountType {

    const backoffice = 1;
    const bidder = 2;

}

final class EmailStatus {

    const verified = 1;
    const unverified = 2;

}

final class YesNo {

    const yes = 1;
    const no = 2;

}

final class PaymentStatus {

    const verified = 1;
    const unverified = 2;

}

final class ProductStatus {
    
    const draft = 1;
    const published = 2;
    const on_auction = 3;
    const sold = 4;
    const retracted = 4;

}

final class MarketStatus {

    const open = 1;
    const closed = 2;
    const draft = 3;

}

final class BiddingResult {
    const sold = 1;
    const not_sold = 2;
}

final class UserStatus {
    const active = 1;
    const inactive = 2;
}

final class UserRole {
    const admin = 1;
    const teacher = 2;
}

class Getters {

    public static $allowed_extensions = array(
        'jpeg',
        'jpg',
        'png',
        'pdf',
        'doc',
        'docx',
        'xlsx',
        'txt',
        'ppt',
        'pptx',
    );
    
    public static $default_upload_config = array(
        'maxSize' => CUSTOM_MAX_UPLOAD_SIZE,
        'limit' => 1,
        'extensions' => array(
            'jpeg',
            'jpg',
            'png',
            'pdf',
            'doc',
            'docx',
            'xlsx',
            'txt',
            'ppt',
            'pptx',
        ),
        'uploadDir' => UPLOAD_FILE_DIR,
        'required' => false,
        'returnfullpath' => true,
        'removeFiles' => true
    );
    
    public static $grades = [
        ['value' => 1, 'label' =>'1'],
        ['value' => 2, 'label' =>'2'],
        ['value' => 3, 'label' =>'3'],
        ['value' => 4, 'label' =>'4'],
        ['value' => 5, 'label' =>'5'],
        ['value' => 6, 'label' =>'6'],
        ['value' => 7, 'label' =>'7'],
        ['value' => 8, 'label' =>'8'],
        ['value' => 9, 'label' =>'9'],
        ['value' => 10, 'label' =>'10'],
        ['value' => 11, 'label' =>'11'],
        ['value' => 12, 'label' =>'12'],
    ];
}
