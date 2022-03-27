<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require('config.php');
require_once 'helpers/Functions.php';
require_once 'app/models/PDODb.php';

$db = new PDODb(DB_TYPE, DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT, DB_CHARSET);

$array = array();
$array[] = array(
    'enum_id' => FieldOptions::yes_no,
    'value' => YesNo::none,
    'name' => 'None',
);

$array[] = array(
    'enum_id' => FieldOptions::yes_no,
    'value' => YesNo::yes,
    'name' => 'Yes',
);

$array[] = array(
    'enum_id' => FieldOptions::yes_no,
    'value' => YesNo::no,
    'name' => 'No',
);

$array[] = array(
    'enum_id' => FieldOptions::service_type,
    'value' => ServiceType::water,
    'name' => 'Water',
);

$array[] = array(
    'enum_id' => FieldOptions::service_type,
    'value' => ServiceType::electricity,
    'name' => 'Electricity',
);

$array[] = array(
    'enum_id' => FieldOptions::service_type,
    'value' => ServiceType::sewage,
    'name' => 'Sewage',
);

$array[] = array(
    'enum_id' => FieldOptions::service_type,
    'value' => ServiceType::storm_water,
    'name' => 'Storm Water',
);

$array[] = array(
    'enum_id' => FieldOptions::service_type,
    'value' => ServiceType::provisional_roads,
    'name' => 'Provisional Roads',
);


$array[] = array(
    'enum_id' => FieldOptions::service_status,
    'value' => ServiceStatus::not_serviced,
    'name' => 'Not serviced',
);

$array[] = array(
    'enum_id' => FieldOptions::service_status,
    'value' => ServiceStatus::partially_serviced,
    'name' => 'Partially serviced',
);

$array[] = array(
    'enum_id' => FieldOptions::service_status,
    'value' => ServiceStatus::completed,
    'name' => 'Completed',
);

$array[] = array(
    'enum_id' => FieldOptions::service_status,
    'value' => ServiceStatus::handed_over,
    'name' => 'Handed over',
);

$array[] = array(
    'enum_id' => FieldOptions::pldh_status,
    'value' => PldhStatus::pending,
    'name' => 'Pending',
);

$array[] = array(
    'enum_id' => FieldOptions::pldh_status,
    'value' => PldhStatus::revised,
    'name' => 'Revised',
);

$array[] = array(
    'enum_id' => FieldOptions::pldh_status,
    'value' => PldhStatus::cancel_expired,
    'name' => 'Cancelled\/Expired',
);

$array[] = array(
    'enum_id' => FieldOptions::pldh_status,
    'value' => PldhStatus::approved,
    'name' => 'Approved',
);

$array[] = array(
    'enum_id' => FieldOptions::geyser_type,
    'value' => GeyserType::gas,
    'name' => 'Gas',
);

$array[] = array(
    'enum_id' => FieldOptions::geyser_type,
    'value' => GeyserType::solar,
    'name' => 'Solar',
);

$array[] = array(
    'enum_id' => FieldOptions::geyser_type,
    'value' => GeyserType::other,
    'name' => 'Other',
);

$array[] = array(
    'enum_id' => FieldOptions::developer_type,
    'value' => DeveloperType::house,
    'name' => 'House',
);

$array[] = array(
    'enum_id' => FieldOptions::developer_type,
    'value' => DeveloperType::bulk,
    'name' => 'Bulk',
);

//Pass/Fail
$array[] = array(
    'enum_id' => FieldOptions::pass_fail,
    'value' => PassFail::pass,
    'name' => 'Pass',
);

$array[] = array(
    'enum_id' => FieldOptions::pass_fail,
    'value' => PassFail::fail,
    'name' => 'Fail',
);

foreach ($array as $array_item) {
    $query = "select id
        from tbl_field_options
        where enum_id = " . $array_item['enum_id'] . "
        and value = " . $array_item['value'];
    $row = $db->rawQueryOne($query);

    if ($row) {
        $values = array(
            'name' => $array_item['name']
        );

        $db->whereClear();
        $db->where("id", $row['id']);
        $db->update('tbl_field_options', $values);
    } else {
        $values = array(
            'enum_id' => $array_item['enum_id'],
            'value' => $array_item['value'],
            'name' => $array_item['name']
        );

        $db->insert('tbl_field_options', $values);
    }
}

$array = array();
$array[] = array(
    'enum_id' => Documents::concept_houseplan,
    'name' => 'Concept House Plans'
);

$array[] = array(
    'enum_id' => Documents::three_dimen_drawing,
    'name' => 'Three Dimensional Drawings'
);

$array[] = array(
    'enum_id' => Documents::finishing_schedule_color_scheme,
    'name' => 'Proposed Finishing Schedule and Color Scheme with Color Cards'
);

$array[] = array(
    'enum_id' => Documents::pricing_model,
    'name' => 'Pricing Model'
);

$array[] = array(
    'enum_id' => Documents::quality_control_plan,
    'name' => 'Quality Control Plan'
);

$array[] = array(
    'enum_id' => Documents::three_dimen_drawing,
    'name' => 'Sectional Title/Body Corporate Registration Method Statement'
);

$array[] = array(
    'enum_id' => Documents::sales_agreement,
    'name' => 'Sales Agreement'
);

foreach ($array as $array_item) {
    $query = "select id
        from tbl_document_type
        where enum_id = " . $array_item['enum_id'];
    $row = $db->rawQueryOne($query);

    if ($row) {
        $values = array(
            'name' => $array_item['name']
        );

        $db->whereClear();
        $db->where("id", $row['id']);
        $db->update('tbl_document_type', $values);
    } else {
        $values = array(
            'enum_id' => $array_item['enum_id'],
            'name' => $array_item['name'],
        );

        $db->insert('tbl_document_type', $values);
    }
}


//Zoning Categories
$array = array();
$array[] = array(
    'enum_id' => Zoning::general_business,
    'name' => 'General business'
);

$array[] = array(
    'enum_id' => Zoning::general_residential,
    'name' => 'General residential'
);

$array[] = array(
    'enum_id' => Zoning::institutional,
    'name' => 'Institutional'
);

$array[] = array(
    'enum_id' => Zoning::light_industrial,
    'name' => 'Light industrial'
);

$array[] = array(
    'enum_id' => Zoning::private_open_space,
    'name' => 'Private open space'
);

$array[] = array(
    'enum_id' => Zoning::private_street,
    'name' => 'Private street'
);

$array[] = array(
    'enum_id' => Zoning::residential,
    'name' => 'Residential'
);

$array[] = array(
    'enum_id' => Zoning::undetermined,
    'name' => 'Undetermined'
);

$array[] = array(
    'enum_id' => Zoning::sectional_title,
    'name' => 'Sectional Title'
);

foreach ($array as $array_item) {
    $query = "select id
        from tbl_zoning
        where enum_id = " . $array_item['enum_id'];
    $row = $db->rawQueryOne($query);

    if ($row) {
        $values = array(
            'name' => $array_item['name']
        );

        $db->whereClear();
        $db->where("id", $row['id']);
        $db->update('tbl_zoning', $values);
    } else {
        $values = array(
            'enum_id' => $array_item['enum_id'],
            'name' => $array_item['name'],
        );

        $db->insert('tbl_zoning', $values);
    }
}
