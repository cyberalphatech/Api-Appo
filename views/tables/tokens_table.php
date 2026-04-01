<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['id', 'token_name', 'token_value', 'status'];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'appapi_tokens';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id', 'token_name', 'token_value', 'description', 'status', 'expires_at']);
$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['id'];
    $row[] = $aRow['token_name'];
    $row[] = $aRow['token_value'];
    $row[] = ($aRow['status'] == 1) ? '<span class="label label-success">' . _l('active') . '</span>' : '<span class="label label-danger">' . _l('inactive') . '</span>';

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', [
        'onclick' => 'edit_token(this,' . $aRow['id'] . '); return false;',
        'data-token_name' => $aRow['token_name'],
        'data-token_value' => $aRow['token_value'],
        'data-description' => $aRow['description'],
        'data-status' => $aRow['status'],
        'data-expires_at' => $aRow['expires_at'],
    ]);
    $options .= icon_btn('api_x_apps/tokens/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $row[] = $options;
    $output['aaData'][] = $row;
}
