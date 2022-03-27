<?php

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends SecureController {

    public function getInput(
            $name,
            $input_type,
            $value = '',
            $css_class = '',
            $style = '',
            $other_attr = '',
            $source = null,
            $default = null,
            $num_decimal = 2,
            $add_value_to_string = false,
            $label = null
    ) {
        $echo_js = '';
        is_null($default) && $default = ' -- ' . get_lang('please_select') . ' --';

        if (!in_array($input_type, array(InputType::select, InputType::textarea))) {
            $echo = '<input type=';

            switch ($input_type) {
                case InputType::date:
                    $echo .= '"date"';
                    break;
                case InputType::text:
                    $echo .= '"text"';
                    break;
                case InputType::number:
                    $echo .= '"text"';
                    break;
                case InputType::password:
                    $echo .= '"password"';
                    break;
                case InputType::submit:
                    $echo .= '"submit"';
                    break;
                case InputType::hidden:
                    $echo .= '"hidden"';
                    break;
                case InputType::button:
                    $echo .= '"button"';
                    break;
                case InputType::checkbox:
                    $echo .= '"checkbox"';
                    break;
                case InputType::radio:
                    $echo .= '"radio"';
                    break;
            }

            $echo .= " name=\"$name\" id=\"$name\" ng-model=\"$name\"";

            if (!in_array($input_type, array(InputType::date, InputType::datetime))) {
                $echo .= (trim($value) != '' ? ' ng-init="' . $name . ' = \'' . $value . '\'"' : '');
            } else {
                $echo .= (trim($value) != '' ? ' ng-init="' . $name . ' = mysqlDateToJSDate(\'' . $value . '\')"' : '');
            }

            $echo .= (trim($css_class) != '' ? ' class="' . $css_class . ($input_type == InputType::number ? " currency" : "") . '"' : '');
            $echo .= (trim($style) != '' ? ' style="' . $style . '"' : '');
            $echo .= (trim($other_attr) != '' ? ' ' . $other_attr : '');

            if ($input_type == InputType::date) {
                $echo .= ' data-date="" data-date-format="DD/MM/YYYY" ';
            }

            $echo .= ' />';
        } else {  //Create select (combobox) or textarea
            if ($input_type == InputType::select) {
                $echo = '<select';
                $echo .= " name=\"$name\" id=\"$name\" ng-model=\"$name\"";
                $echo .= ($value != '' ? ' value="' . $value . '"' : '');
                $echo .= (trim($value) != '' ? ' ng-init="' . $name . ' = \'' . $value . '\'"' : '');
                $echo .= ($css_class != '' ? ' class="' . $css_class . '"' : '');
                $echo .= ($style != '' ? ' style="' . $style . '"' : '');
                $echo .= ($other_attr != '' ? ' ' . $other_attr : '');
                $echo .= '>';

                if (!is_null($default)) {
                    $echo .= '<option value="">';
                    $echo .= $default;
                    $echo .= '</option>';
                }

                if (!is_null($source)) {
                    foreach ($source as $option) {
                        $echo .= '<option value="' . (string) $option['value'] . '"' . ($option['value'] != $value ? '' : ' selected') . '>';
                        $echo .= (!empty($add_value_to_string) ? ($option['value'] . ' - ') : '') . $option['label'];
                        $echo .= '</option>';
                    }
                }

                $echo .= '</select>';
            } else {
                $echo = '<textarea';
                $echo .= " name=\"$name\" id=\"$name\" ng-model=\"$name\"";
                $echo .= ($css_class != '' ? ' class="' . $css_class . '"' : '');
                $echo .= (trim($value) != '' ? ' ng-init="' . $name . ' = \'' . $value . '\'"' : '');
                $echo .= ($style != '' ? ' style="' . $style . '"' : '');
                $echo .= ($other_attr != '' ? ' ' . $other_attr : '');
                $echo .= '>';
                $echo .= (trim($value) != '' ? $value : '');
                $echo .= '</textarea>';
            }
        }

        if (!empty($label)) {
            $return = '<div class="form-group">';
            $return .= '<label>';
            $return .= $label;
            $return .= '</label>';
            $return .= $echo;
            $return .= $echo_js;
            $return .= '</div>';
        } else {
            $return = $echo;
            $return .= $echo_js;
        }

        return $return;
    }

    function addInput(array $field) {
        echo '<div class="form-group row">';
        echo '<label for="',
        $field['name'],
        '" class="col-sm-4 col-form-label">',
        $field['label'],
        (array_key_exists('required', $field) && $field['required'] ? ' <span class="text-danger">*</span>' : ''),
        '</label>';
        echo '<div class="col-sm-8">';

        $other_str = '';

//        if ($field['type'] == InputType::date) {
//            $other_str .= ' data-enable-time="false"   data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single"';
//        }

        if ($field['type'] == InputType::text) {
            $other_str .= ' placeholder="' . $field['label'] . '"';
        }

        if (array_key_exists('required', $field) && $field['required']) {
            $other_str .= ' required="required"';
        }

        if (array_key_exists('ngrequired', $field) && $field['ngrequired']) {
            $other_str .= ' ng-required="' . $field['ngrequired'] . '"';
        }

        if (array_key_exists('other', $field) && $field['other']) {
            $other_str .= $field['other'];
        }
        
        
        $css_class = 'form-control' . ($field['type'] == InputType::date ? ' datepicker' : '');
        
        if (array_key_exists('class', $field) && $field['class']) {
            $css_class .= ' ' . $field['class'];
        }

        echo $this->getInput(
                $field['name'],
                $field['type'],
                (array_key_exists('value', $field) ? $field['value'] : ''),
                $css_class,
                '',
                $other_str,
                ($field['type'] == InputType::select && !empty($field['options']) ? $field['options'] : null),
                (array_key_exists('default_label', $field) ? $field['default_label'] : '--select value--')
        );
        echo '</div>';
        echo '</div>';
    }

    function addFileInput($name) {
        echo '<a class="btn btn-primary" href="javascript:void(0)">
                Choose File...
                <input name="' . $name . '" type="file" style=\'z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;\' size="40"  onchange=\'$("#' . $name . '-info").html($(this).val());\'>
            </a>
            &nbsp;
            <span class="label label-info" id="' . $name . '-info"></span>';
    }

    /**
     * getcount_employees Model Action
     * @return Value
     */
    function getcount_products() {
        $db = $this->GetModel();
        $sqltext = "SELECT COUNT(*) AS num FROM products";
        $arr = $db->rawQueryValue($sqltext);
        return $arr[0];
    }

    /**
     * clients_main_contact_id_option_list Model Action
     * @return array
     */
    function clients_main_contact_id_option_list() {
        $db = $this->GetModel();
        $sqltext = "SELECT  DISTINCT id AS value,concat(firstname, ' ', lastname) AS label FROM contacts";
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }

    function developers_id_option_list($type = null) {
        $db = $this->GetModel();
        $sqltext = "SELECT id AS value , name AS label FROM tbl_developer " . (!empty($type) ? "WHERE type = $type" : "") . " ORDER BY label ASC";
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }

    function regions_option_list() {
        $db = $this->GetModel();
        $sqltext = "SELECT id AS value , name AS label FROM tbl_regions ORDER BY label ASC";
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }
    
    function regions_value_name() {
        $db = $this->GetModel();
        $sqltext = "SELECT id AS value , name AS label FROM tbl_regions ORDER BY label ASC";
        $arr = $db->rawQuery($sqltext);
        $return = array();
        foreach ($arr as $r) {
            $return[$r['value']] = $r['label'];
        }

        return $return;
    }
    
    function schools_option_list() {
        $db = $this->GetModel();
        $sqltext = "SELECT id AS value , name AS label FROM tbl_schools ORDER BY label ASC";
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }
    
    function schools_value_name() {
        $db = $this->GetModel();
        $sqltext = "SELECT id AS value , name AS label FROM tbl_schools ORDER BY label ASC";
        $arr = $db->rawQuery($sqltext);
        $return = array();
        foreach ($arr as $r) {
            $return[$r['value']] = $r['label'];
        }

        return $return;
    }

    function extension_id_option_list() {
        $db = $this->GetModel();
        $sqltext = "SELECT id AS value , name AS label FROM tbl_extension ORDER BY label ASC";
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }

    function get_field_options($options_enum) {
        $db = $this->GetModel();
        $sqltext = "SELECT  value, name AS label FROM tbl_field_options where enum_id = " . $options_enum;
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }

    function get_field_options_value_name($options_enum) {
        $db = $this->GetModel();
        $sqltext = "SELECT  value, name AS label FROM tbl_field_options where enum_id = " . $options_enum;
        $arr = $db->rawQuery($sqltext);

        $return = array();
        foreach ($arr as $r) {
            $return[$r['value']] = $r['label'];
        }

        return $return;
    }

    function get_developer_sc_options($dev_id) {
        $db = PDODb::getInstance();
        $sqltext = "SELECT id as value, sc_number AS label FROM tbl_sale_contract where developer_id = " . $dev_id;
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }
    
    function get_bank_options() {
        $db = PDODb::getInstance();
        $sqltext = "SELECT id as value, name AS label FROM tbl_bank";
        $arr = $db->rawQuery($sqltext);
        return $arr;
    }

    static function AlertDiv($text, $type) {
        echo "<div class='alert alert-$type'>", $text, "</div>";
    }

    static function getDeveloperDetails($rec_id) {
        $db = PDODb::getInstance();
        $db->where('id', $rec_id);
        $record = $db->getOne('tbl_developer');

        if ($record) {
            $data = new stdClass;
            $data->main_record = $record;

            $db->whereClear();
            $db->where("developer_id", $rec_id);
            $db->where("company_owner", 1);

            $owners = $db->get("tbl_contact");
            $data->owners = $owners;

            $db->whereClear();
            $db->where("developer_id", $rec_id);
            $db->where("company_owner", 'NULL');

            $contacts = $db->get("tbl_contact");
            $data->contacts = $contacts;

            return $data;
        }


        return null;
    }

    static function getErfFullRecords($id) {
        $db = PDODb::getInstance();
        $db->join('tbl_zoning', "tbl_erf.zoning_id = tbl_zoning.id", "LEFT");
        $db->join('tbl_extension', "tbl_erf.extension_id = tbl_extension.id", "LEFT");
        $db->where('tbl_erf.id', $id);

        $fields = array(
            "tbl_erf.id",
            "erf_number",
            "street_address",
            "erf_size",
            "tbl_erf.created",
            "tbl_erf.modified",
            "tbl_erf.gr_subdivided",
            "zoning_id",
            "extension_id",
            "developer_id",
            "dev_cell_id",
            "sales_contract_id",
            "construction_id",
            "tbl_zoning.name as zoning",
            "tbl_extension.name as extension"
        );

        $record = $db->getOne('tbl_erf', $fields);

        if ($record) {
            $data = new stdClass;
            $data->main_record = $record;

            $db->whereClear();
            $db->joinsClear();
            $db->join('tbl_developer', "tbl_development_cell.developer_id = tbl_developer.id");
            $fields = "tbl_development_cell.id, developer_id, vo_number, water_status, electricity_status, sewage_status,";
            $fields .= "storm_water_status, prov_roads_status, tbl_development_cell.created,";
            $fields .= "tbl_developer.name developer, tbl_developer.registration_number as developer_registration_number,";
            $fields .= "(select count(*) from tbl_erf where dev_cell_id = tbl_development_cell.id) as erven_count";

            $db->where("tbl_development_cell.id", $record['dev_cell_id']);
            $devll_cell = $db->getOne('tbl_development_cell', $fields);
            $data->dev_cell = $devll_cell;


            $db->whereClear();
            $db->joinsClear();
            $db->join('tbl_developer', "tbl_sale_contract.developer_id = tbl_developer.id");
            $db->where("tbl_sale_contract.id", $record['sales_contract_id']);
            $fields = array(
                "tbl_sale_contract.id",
                "sc_number",
                "status",
                "setup_date",
                "signed_date",
                "expiry_date",
                "sales_amount",
                "payment_terms",
                "developer_id",
                "tbl_developer.name as developer",
                "tbl_developer.registration_number as developer_registration_number",
                "tbl_sale_contract.created",
                "tbl_sale_contract.modified"
            );
            $sale_contract = $db->getOne('tbl_sale_contract', $fields);
            $data->sales_contract = $sale_contract;


            $db->whereClear();
            $db->joinsClear();
            $db->where("id", $record['developer_id']);
            $developer = $db->getOne("tbl_developer");
            $data->developer = $developer;

            $db->whereClear();
            $db->joinsClear();
            $db->join("tbl_erf", "tbl_erf.id=tbl_sale_contract_payment.erf_id");
            $db->where("erf_id", $id);
            $payments = $db->get("tbl_sale_contract_payment", null, array("tbl_sale_contract_payment.*", "tbl_erf.erf_number"));
            $data->payments = $payments;
            
            $db->whereClear();
            $db->joinsClear();
            $db->where("erf_id", $id);
            $construction = $db->getOne("tbl_construction");
            $data->construction = $construction;

            $data->documents = self::getEntityFiles(FileLinkingEntity::erf, $id);

            $db->where("erf_id", $id);
            $completed = array();
            $checks = $db->get("tbl_construction_check_done");
            foreach ($checks as $check) {
                $completed[] = $check['check_enum_id'];
            }

            $data->completed_checks = $completed;
            
            
            $db->whereClear();
            $db->joinsClear();
            $db->where("erf_id", $id);
            $owners = $db->get("tbl_owner");
            $data->owners = $owners;
            
            
            if ($record['zoning_id'] == Zoning::general_residential && $record['gr_subdivided'] == YesNo::yes) {
                $db->where("st_parent_erf_id", $record['id']);
                $db->orderBy("id", "ASC");
                $subdivided_erven = $db->get("tbl_erf");
                $data->subdivided_erven = $subdivided_erven;
            }
            
            return $data;
        }

        return null;
    }

    public static function toNumber($value, $to_sql = false, $decimal = null, $zero_desc = '-') {
        $value = str_replace(
                array(',', ' '),
                '',
                self::trimSpace($value, '')
        );
        if ($to_sql) {
            return $value;
        }
        if (trim((string) $value) == '') {
            return '';
        }
        is_null($decimal) && $decimal = 2;
        $value = round($value, $decimal);
        $values = explode('.', $value);
        $value = number_format($values[0]);
        if ($value == '0' && substr($values[0], 0, 1) == '-') {
            $value = '-' . $value;
        }
        if ($decimal != 0) {
            $value .= '.';
        }
        if (count($values) == 2) {
            $value .= str_pad($values[1], $decimal, '0', STR_PAD_RIGHT);
        } else {
            $value .= str_pad('', $decimal, '0', STR_PAD_RIGHT);
        }
        $value == '0.' . str_pad('', $decimal, '0', STR_PAD_RIGHT) && $value = $zero_desc;
        return $value;
    }

    public static function trimSpace($value, $replace = ' ') {
        return trim(preg_replace(
                        '/\s{3,}/',
                        $replace,
                        $value
                ));
    }

    public static function htmlDateToMysql($date_str) {
        if (!empty($date_str)) {
            $date = DateTime::createFromFormat('D M d Y H:i:s e+', $date_str);

            if ($date) {
                return $date->format("Y-m-d");
            }
        }

        return null;
    }
    
    
    static function getEntityFiles($entity_type, $link_id) {
        $db = PDODb::getInstance();
        $db->where("link_id", $link_id);
        $db->where("linking_entity_type", $entity_type);
        $db->join("tbl_document_type", "tbl_document_type.enum_id=tbl_file.document_type_id");
        $documents = $db->get("tbl_file", null, array("tbl_file.id", "tbl_document_type.name as doc_type", "path", "original_name", "document_type_id"));
        
        return $documents;
    }
    
    function getUserSubjects($user_id = USER_ID) {
        $db = $this->GetModel();
        
        $db->join(SqlTables::tbl_user_subjects, "tbl_user_subjects.subject_id = tbl_subjects.id");
        $db->where("user_id", $user_id);
        $subjects = $db->get(SqlTables::tbl_subjects, null, "tbl_subjects.id, tbl_subjects.name");
        return $subjects;
    }
}
