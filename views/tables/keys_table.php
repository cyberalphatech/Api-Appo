<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['id', 'key_name', 'key_value', 'status'];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'appapi_keys';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id', 'key_name', 'key_value', 'description', 'status']);
$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['id'];
    $row[] = $aRow['key_name'];
    $row[] = $aRow['key_value'];
    $row[] = ($aRow['status'] == 1) ? '<span class="label label-success">' . _l('active') . '</span>' : '<span class="label label-danger">' . _l('inactive') . '</span>';

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', [
        'onclick' => 'edit_key(this,' . $aRow['id'] . '); return false;',
        'data-key_name' => $aRow['key_name'],
        'data-key_value' => $aRow['key_value'],
        'data-description' => $aRow['description'],
        'data-status' => $aRow['status'],
    ]);
    $options .= icon_btn('api_x_apps/keys/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $row[] = $options;
    $output['aaData'][] = $row;
}
