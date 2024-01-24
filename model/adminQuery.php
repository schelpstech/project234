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


    //Finance Profile Page
    $tableName = '_tbl_termlyinvoice';
    $conditions = [
        'select' => 'DISTINCT _tbl_termlyinvoice.schCode AS sch,
                 _tbl_sch_corporate_data.sch_name,
                 _tbl_sch_corporate_data.schLogo,
                 COUNT(_tbl_termlyinvoice.schCode) AS num,
                 SUM(CASE WHEN _tbl_termlyinvoice.vetting = 0 THEN 1 ELSE 0 END) AS unvetted,
                 SUM(CASE WHEN _tbl_termlyinvoice.vetting = 1 THEN 1 ELSE 0 END) AS vetted',
        'joinl' => [
            '_tbl_sch_corporate_data' => ' on _tbl_sch_corporate_data.sch_code = _tbl_termlyinvoice.schCode'
        ],
        'group_by' => '_tbl_termlyinvoice.schCode'
    ];
    $invoiceReport = $model->getRows($tableName, $conditions);

    //Enrolment Report Page
    $tableName = '_tbl_termly_enrolment';
    $conditions = [
        'select' => 'DISTINCT _tbl_termly_enrolment.schCode AS sch,
                 _tbl_sch_corporate_data.sch_name,
                 _tbl_sch_corporate_data.schLogo,
                 COUNT(DISTINCT _tbl_termly_enrolment.termID) AS num',
        'joinl' => [
            '_tbl_sch_corporate_data' => ' on _tbl_sch_corporate_data.sch_code = _tbl_termly_enrolment.schCode'
        ],
        'group_by' => '_tbl_termly_enrolment.schCode'
    ];
    $enrolmentReport = $model->getRows($tableName, $conditions);

    if (isset($_SESSION['schCode'])) {
        $tblName = '_tbl_termlyinvoice';
        $conditions = [
            'where' => [
                'schCode' => $_SESSION['schCode'],
            ],
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_termlyinvoice.termRef = tblcurrent_term.id',
            ],
        ];
        $invoiceList = $model->getRows($tblName, $conditions);
    }

    if (isset($_SESSION['schCode']) && isset($_SESSION['termRef'])) {

        $tblName = '_tbl_termly_enrolment';
        $conditions = [
            'where' => [
                '_tbl_termly_enrolment.schCode' => $_SESSION['schCode'],
                '_tbl_termly_enrolment.termID' => $_SESSION['termRef'],
            ],
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_termly_enrolment.termID = tblcurrent_term.id',
                'tbl_classes' => ' on _tbl_termly_enrolment.classID = tbl_classes.id',
            ]
        ];
        $enrolmentRecord = $model->getRows($tblName, $conditions);
    }

    if (isset($_SESSION['schCode'])) {

        $tblName = '_tbl_termly_enrolment';
        $conditions = [
            'where' => [
                '_tbl_termly_enrolment.schCode' => $_SESSION['schCode'],
            ],
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_termly_enrolment.termID = tblcurrent_term.id',
                'tbl_classes' => ' on _tbl_termly_enrolment.classID = tbl_classes.id',
            ]
        ];
        $allEnrolmentRecord = $model->getRows($tblName, $conditions);
    }

    //Select All Rebate Applications of School
    $tblName = '_tbl_rebate_record';
    $conditions = [
        'joinl' => [
            'tblcurrent_term' => ' on _tbl_rebate_record.rebateTerm = tblcurrent_term.id',
        ]
    ];
    $rebateRecords = $model->getRows($tblName, $conditions);

   
   
}