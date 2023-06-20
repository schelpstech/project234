<?php
include './query.php';

if (isset($_POST['variable']) && $_POST['requested'] == 'fetch_region_data') {
    $tblName = 'region_tbl';
    $condition = [
        'where' => array(
            'country_id' => $_POST['variable'],
        )
    ];
    $response = $model->getRows($tblName, $condition);
    echo '<option value="">select</option>';
    foreach ($response as $data) {
        echo '<option value="' . $data['region_id'] . '">' . $data['region'] . '</option>';
    }
}

if (isset($_POST['variable']) && $_POST['requested'] == 'fetch_state_data') {
    $tblName = 'state_tb';
    $condition = [
        'where' => array(
            'region_id' => $_POST['variable'],
        )
    ];
    $response = $model->getRows($tblName, $condition);
    echo '<option value="">select</option>';
    foreach ($response as $data) {
        echo '<option value="' . $data['state_id'] . '">' . $data['state'] . '</option>';
    }
}

if (isset($_POST['variable']) && $_POST['requested'] == 'fetch_lga_data') {
    $tblName = 'lga_tbl';
    $condition = [
        'where' => array(
            'state_id' => $_POST['variable'],
        )
    ];
    $response = $model->getRows($tblName, $condition);
    echo '<option value="">select</option>';
    foreach ($response as $data) {
        echo '<option value="' . $data['lga_id'] . '">' . $data['lga'] . '</option>';
    }
}