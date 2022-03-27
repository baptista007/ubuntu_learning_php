<?php

class FormHelper {
    function GetModel($arg = null) {
        //Initialse New Database Connection
        return new PDODb(DB_TYPE, DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_CHARSET);
    }
    
    public static function addInput(
            $name,
            $input_type,
            $value = '',
            $label = '',
            $required = false,
            array $other_attr = array(),
            $source = null,
            $ng_show = null,
            $css_class = 'form-control',
            $style = '',
            $num_decimal = 2,
            $num_right_align = false,
            $default = '-- please select --',
            $echo = true
    ) {
        $html = self::getInput(
                        $name,
                        $input_type,
                        $value,
                        $label,
                        $required,
                        $other_attr,
                        $source,
                        $ng_show,
                        $css_class,
                        $style,
                        $num_decimal,
                        $num_right_align,
                        $default
        );

        if ($echo) {
            echo $html;
            return;
        }

        return $html;
    }

    public static function getInput(
            $name,
            $input_type,
            $value = '',
            $label = '',
            $required = false,
            array $other_attr = array(),
            $source = null,
            $ng_show = null,
            $css_class = 'form-control',
            $style = '',
            $num_decimal = 2,
            $num_right_align = false,
            $default = '-- please select --'
    ) {
        $css_class = " form-control $css_class";

        if ($required && !array_key_exists('required', $other_attr)) {
            $other_attr['required'] = true;
        }
        
        if (in_array($input_type, array(InputType::date, InputType::datetime))) {
//            $other_attr['data-mode'] = "single";
//            $other_attr['data-date-format'] = "Y-m-d";
//            $other_attr['data-alt-format'] = "F j, Y";
//            $other_attr['data-inline'] = false;
//            $other_attr['data-no-calendar'] = false;
        }
        
        if (!empty($value)) {
            $ng_value = "";
            
            switch ($input_type) {
                case InputType::checkbox:
                case InputType::radio:
                    $other_attr['ng-checked'] = "$name == " . YesNo::yes;
                    $ng_value = "$value";
                    break;
                case InputType::date:
                case InputType::datetime:
                    $ng_value = "mysqlDateToJSDate('$value')";
                    break;
                default :
                    $ng_value = "'$value'";
                    break;
            }
            
            $other_attr['ng-init'] = "$name = $ng_value";
        }

        $echo = '<div class="form-group elem-' . $name . '" ' . (!empty($ng_show) ? 'ng-show="' . $ng_show . '"' : '') . '> ';

        if (in_array($input_type, array(InputType::checkbox, InputType::radio))) {
            $echo .= '<div class="checkbox"> ';
            $echo .= '<label>';
            $echo .= self::getSimpleInput(
                            $name,
                            $input_type,
                            YesNo::yes,
                            $other_attr,
                            $css_class,
                            $style,
                            $num_decimal,
                            $num_right_align
            );

            $echo .= " " . $label;
            $echo .= '</label>';
            $echo .= '</div>';
        } else {
            if (array_key_exists('label', $other_attr)) {
                $label = $other_attr['label'];
            }
            
            if (!empty($label)) {
                $echo .= ' <label for="' . $name . '">';
                $echo .= $label;

                if ($required) {
                    $echo .= ' <span class="required text-danger"> *</span>';
                }

                $echo .= '</label>';
            }

            $echo .= '<div ' . (in_array($input_type, array(InputType::date, InputType::datetime)) ? "class='input-group'" : "") . '>';
            switch ($input_type) {
                case InputType::select:
                case InputType::checkgroup:
                case InputType::radiogroup:
                    $echo .= self::getOptionsInput(
                                    $name,
                                    $input_type,
                                    $value,
                                    $other_attr,
                                    $source,
                                    $css_class,
                                    $style,
                                    $default
                    );
                    break;
                case InputType::filter_date_from_to:
                    $echo .= self::getSimpleInput(
                                    $name . "_st",
                                    InputType::date,
                                    Common::getSubmitValue($name . "_st"),
                                    $other_attr,
                                    $css_class,
                                    $style,
                                    $num_decimal,
                                    $num_right_align
                            );  
                    $echo .= ' - ';
                    $echo .= self::getSimpleInput(
                                    $name . "_en",
                                    InputType::date,
                                    Common::getSubmitValue($name . "_en"),
                                    $other_attr,
                                    $css_class,
                                    $style,
                                    $num_decimal,
                                    $num_right_align
                            );
                    break;
                case InputType::filter_year_from_to:
                    $echo .= self::getSimpleInput(
                                    $name . "_st",
                                    InputType::number,
                                    Common::getSubmitValue($name . "_st"),
                                    $other_attr,
                                    $css_class,
                                    $style,
                                    $num_decimal,
                                    $num_right_align
                            );  
                    $echo .= ' - ';
                    $echo .= self::getSimpleInput(
                                    $name . "_en",
                                    InputType::number,
                                    Common::getSubmitValue($name . "_en"),
                                    $other_attr,
                                    $css_class,
                                    $style,
                                    $num_decimal,
                                    $num_right_align
                            );
                    break;
                default :
                    $echo .= self::getSimpleInput(
                                    $name,
                                    $input_type,
                                    $value,
                                    $other_attr,
                                    $css_class,
                                    $style,
                                    $num_decimal,
                                    $num_right_align
                    );
                    break;
            }

            $echo .= '</div>';
        }

        $echo .= '</div>';

        return $echo;
    }

    static function getSimpleInput(
            $name,
            $input_type,
            $value = '',
            array $other_attr = array(),
            $css_class = 'form-control',
            $style = '',
            $num_decimal = 2,
            $num_right_align = false
    ) {

        if ($input_type == InputType::textarea) {
            $echo = '<textarea';
            $echo .= " name=\"$name\" id=\"$name\" ng-model=\"$name\"";
            $echo .= (!empty($css_class) ? ' class="' . $css_class . '"' : '');
            $echo .= (!empty($style) ? ' style="' . $style . '"' : '');
            $echo .= self::getOtherAttrString($other_attr);
            $echo .= '>';
            $echo .= '</textarea>';
            return $echo;
        }

        if ($input_type == InputType::file) {
            $echo = '<input type="file"';
            $echo .= " name=\"$name\" id=\"$name\"";
            $echo .= (!empty($css_class) ? ' class="' . $css_class . '"' : '');
            $echo .= (!empty($style) ? ' style="' . $style . '"' : '');
            $echo .= self::getOtherAttrString($other_attr);
            $echo .= ' />';
            return $echo;
        }

        $echo = '<input type=';
        $echo_js = '';

        switch ($input_type) {
            case InputType::text:
                $echo .= '"text"';
                break;
            case InputType::date:
                $echo .= '"date"';
                break;
            case InputType::datetime:
                $echo .= '"datetime"';
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
            case InputType::color:
                $echo .= '"color"';
                break;
        }

        $echo .= " name=\"$name\" id=\"$name\" ng-model=\"$name\"";
        $echo .= (!empty($value) ? ' value="' . $value . '"' : '');
        $echo .= (!empty($css_class) && !in_array($input_type, array(InputType::checkbox, InputType::radio)) ? ' class="' . $css_class . '"' : '');
        $echo .= (!empty($style) ? ' style="' . $style . '"' : '');
        $echo .= self::getOtherAttrString($other_attr);
        $echo .= ' />';
        
        

        return $echo . $echo_js;
    }

    static function getOptionsInput(
            $name,
            $input_type,
            $value = '',
            array $other_attr = array(),
            $source = null,
            $css_class = 'form-control',
            $style = '',
            $default = '-- please select --'
    ) {
        $echo = '';

        switch ($input_type) {
            case InputType::select:
                $echo .= '<select';
                $echo .= " name=\"$name\" id=\"$name\" ng-model=\"$name\"";
                $echo .= (!empty($value) ? ' value="' . $value . '"' : '');
                $echo .= (!empty($css_class) ? ' class="' . $css_class . '"' : '');
                $echo .= (!empty($style) ? ' style="' . $style . '"' : '');
                $echo .= self::getOtherAttrString($other_attr);
                $echo .= '>';

                if (!is_null($default)) {
                    $echo .= '<option value="">';
                    $echo .= $default;
                    $echo .= '</option>';
                }

                if (!empty($source)) {
                    foreach ($source as $option) {
                        $echo .= '<option value="' . (string) $option['value'] . '">';
                        $echo .= $option['label'];
                        $echo .= '</option>';
                    }
                }

                $echo .= '</select>';
                break;
            case InputType::checkgroup:
            case InputType::radiogroup:
                if (!empty($source)) {
                    foreach ($source as $value) {
                        $echo .= '<div class="form-check">
                                <input class="form-check-input" type="' . ($input_type == InputType::checkgroup ? 'checkbox' : 'radio') . '" name="' . $name . '" id="' . $name . '" ng-model="' . $name . '" value="' . $value['value'] . '" ' . self::getOtherAttrString($other_attr) . '>
                                <label class="form-check-label" for="' . $name . '">
                                  ' . $value['name'] . '
                                </label>
                              </div>';
                    }
                }
                break;
        }

        return $echo;
    }

    static function getOtherAttrString(array $other_attrs) {
        $return = "";
        if (!empty($other_attrs)) {
            $options_string = "";

            foreach ($other_attrs as $key => $value) {
                $options_string .= $key . '="' . $value . '"';
            }

            $return = $options_string;
        }

        return $return;
    }
    
    static public function getFieldOptions($enum_id, $values_in = array()) {
        $query = "select
                    fo.value,
                    fo.name
                from tbl_field_options fo
                where fo.enum_id = " . $enum_id;

        if (!empty($values_in)) {
            $query .= " AND fo.value in (" . implode(",", $values_in) . ")";
        }

        $query .= " order by fo.value ";

        return $this->GetModel()->get_rows($query);
    }
    
    static public function getFieldOptionsValueName($enum_id, $values_in = array()) {
        $query = "select
                    fo.value,
                    fo.name
                from tbl_field_options fo
                where fo.enum_id = " . $enum_id;

        if (!empty($values_in)) {
            $query .= " AND fo.value in (" . implode(",", $values_in) . ")";
        }

        $query .= " order by fo.value ";

        return $this->GetModel()->get_value_name_results($query);
    }
}
