<?php
if (file_exists('../../controller/start.inc.php')) {
    include '../../controller/start.inc.php';
} elseif (file_exists('../controller/start.inc.php')) {
    include '../controller/start.inc.php';
} elseif (file_exists('../../../controller/start.inc.php')) {
    include '../../../controller/start.inc.php';
} else {
    include './controller/start.inc.php';
}
;


if (isset($_SESSION['activeAdmin'])) {
    //Active Term
    $tblName = 'tblcurrent_term';
    $conditions = [
        'return_type' => 'single',
        'where' => [
            'termStatus' => 1,
        ]
    ];
    $currentTerm = $model->getRows($tblName, $conditions);

    //Select Corporate Data    
    $tblName = '_tbl_sch_corporate_data';
    $return = [
        'return_type' => 'count'
    ];
    $primary = [
        'return_type' => 'count',
        'where_not' => [
            'available_classes' => 2,
        ],
    ];
    $secondary = [
        'return_type' => 'count',
        'where_not' => [
            'available_classes' => 1,
        ],
    ];

    $sch_details = $model->select_all($tblName);
    $sch_count = $model->getRows($tblName, $return);
    $sch_count_primary = $model->getRows($tblName, $primary);
    $sch_count_secondary = $model->getRows($tblName, $secondary);

    //Populate Log
    $tblName = 'log';
    $conditions = [
        'where' => [
            'object' => $_SESSION['activeAdmin'],
        ],
        'order_by' => 'rectime DESC',
        'limit' => '5',
    ];
    $condition = [
        'where' => [
            'object' => $_SESSION['activeAdmin'],
        ],
        'order_by' => 'rectime DESC'
    ];
    $conditioned = [
        'order_by' => 'rectime DESC'
    ];
    $notification_alert = $model->getRows($tblName, $conditions);

    $activityLog = $model->getRows($tblName, $condition);
    $getallLog = $model->getRows($tblName, $conditioned);


    //My Support Tickets
    $tblName = '_tbl_ticket';
    $conditions = [
        'order_by' => 'RecordTime DESC',
    ];
    $ticketlog = $model->getRows($tblName, $conditions);

    //Personnel Profile Page
    $tableName = 'tbl_personnel_record';
    $conditions = [
        'select' => 'DISTINCT tbl_personnel_record.schCode AS sch,
                _tbl_sch_corporate_data.sch_code,
                 _tbl_sch_corporate_data.sch_name,
                 _tbl_sch_corporate_data.schLogo,
                 COUNT(tbl_personnel_record.schCode) AS num,
                 SUM(CASE WHEN tbl_personnel_record.vetted = 0 THEN 1 ELSE 0 END) AS unvetted,
                 SUM(CASE WHEN tbl_personnel_record.vetted = 1 THEN 1 ELSE 0 END) AS vetted',
        'joinl' => [
            '_tbl_sch_corporate_data' => ' on _tbl_sch_corporate_data.sch_code = tbl_personnel_record.schCode'
        ],
        'group_by' => 'tbl_personnel_record.schCode'
    ];
    $personnelReport = $model->getRows($tableName, $conditions);
}