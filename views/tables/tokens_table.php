<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['id', 'new_column_1', 'new_column_2'];
$sIndexColumn = 'id';
$sTable = db_prefix() . 'appapi_tokens';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['id']);
$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        $row[] = $_data;
    }

    $options = icon_btn('#', 'pencil-square-o', 'btn-default', [
        'onclick' => 'edit_token(this,' . $aRow['id'] . '); return false;',
        'data-col1' => $aRow['new_column_1'],
        'data-col2' => $aRow['new_column_2'],
    ]);
    $options .= icon_btn('tokens/delete/' . $aRow['id'], 'remove', 'btn-danger _delete');

    $row[] = $options;
    $output['aaData'][] = $row;
}
