<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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



    //Select School Name of Active School   
    if (isset($_SESSION['schCode'])) {

        $tblName = '_tbl_sch_corporate_data';
        $conditions = [
            'return_type' => 'single',
            'where' => [
                'sch_code' => $_SESSION['schCode'],
            ]
        ];
        $sch_corporate_data = $model->getRows($tblName, $conditions);
    }

    //Portal Information Compliance
    $tableName = '_tbl_sch_corporate_data as scd';
    $conditions = [
        'select' => 'scd.sch_code,
            scd.sch_name,
            scd.schLogo,
            
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _tbl_phone_number WHERE sch_code = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS phone_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _tbl_email_address WHERE sch_code = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS email_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _tbl_sch_address WHERE sch_code = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS address_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM log WHERE user_name = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS log_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM tbl_personnel_record WHERE schCode = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS personnel_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _tbl_approval_record WHERE sch_code = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS approval_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM tbl_classes WHERE schCode = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS classes_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _sch_facility_record WHERE sch_code = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS facility_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _termly_report_jesustime WHERE schCode = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS termly_report_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _tbl_termly_enrolment WHERE schCode = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS termly_enrolment_entries,
            (
                CASE
                    WHEN EXISTS (SELECT 1 FROM _tbl_rebate_record WHERE schCode = scd.sch_code) THEN "Yes"
                    ELSE "No"
                END
            ) AS rebate_entries',
    ];
    $complianceReport = $model->getRows($tableName, $conditions);

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

    if (isset($_SESSION['schCode']) && $_SESSION['pageName'] == "School Personnel List") {


        //Selected School Personnel List
        $condition = [
            'where' => [
                'tbl_personnel_record.schCode' => $_SESSION['schCode'],
            ],
            'joinl' => [
                'job_position_tbl' => ' on job_position_tbl.pos_id = tbl_personnel_record.positionRef',
                'qualification_tbl' => ' on qualification_tbl.id = tbl_personnel_record.credentialType',
            ]
        ];
        $schPersonnelList = $model->getRows($tableName, $condition);
    }


    if (isset($_SESSION['schCode']) && isset($_SESSION['personnelRef']) && $_SESSION['pageName'] == "School Personnel Information Page") {

        //Individual School Personnel Information 
        $condition = [
            'where' => [
                'tbl_personnel_record.schCode' => $_SESSION['schCode'],
                'tbl_personnel_record.record_id' => $_SESSION['personnelRef'],
            ],
            'return_type' => 'single',
            'joinl' => [
                'job_position_tbl' => ' on job_position_tbl.pos_id = tbl_personnel_record.positionRef',
                'qualification_tbl' => ' on qualification_tbl.id = tbl_personnel_record.credentialType',
            ]
        ];
        $schPersonnelInfo = $model->getRows($tableName, $condition);
    }


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


    //******** Enrolment Starts
    $tableName = '_tbl_termly_enrolment';
    $condition = [
        'select' => 'DISTINCT _tbl_termly_enrolment.schCode AS sch,
                 _tbl_sch_corporate_data.sch_name,
                 _tbl_sch_corporate_data.schLogo,
                 COUNT(DISTINCT _tbl_termly_enrolment.termID) AS num',
        'joinl' => [
            '_tbl_sch_corporate_data' => ' on _tbl_sch_corporate_data.sch_code = _tbl_termly_enrolment.schCode'
        ],
        'group_by' => '_tbl_termly_enrolment.schCode'
    ];
    $enrolmentReport = $model->getRows($tableName, $condition);

    if (isset($_SESSION['schCode'])) {
        $tableName = '_tbl_termly_enrolment';
        $conditioned = [
            'select' => '_tbl_termly_enrolment.termID, tblcurrent_term.termVariable,
                        COUNT(_tbl_termly_enrolment.termID) AS RecordCount, 
                        SUM(population) AS population,
                        SUM(0.02 * (population * tuition)) AS TotalAmount',
            'where' => [
                '_tbl_termly_enrolment.schCode' => $_SESSION['schCode'],
            ],
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_termly_enrolment.termID = tblcurrent_term.id',
                'tbl_classes' => ' on _tbl_termly_enrolment.classID = tbl_classes.id',
            ],
            'group_by' => '_tbl_termly_enrolment.termID'
        ];
        $enrolmentRecordbyTerm = $model->getRows($tableName, $conditioned);
    }

    if (isset($_SESSION['schCode']) && isset($_SESSION['termRef'])) {
        $tableName = '_tbl_termly_enrolment';
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
        $enrolmentRecord = $model->getRows($tableName, $conditions);
    }

    //******** Enrolment Ends


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



    //Select All Rebate Applications of School
    $tblName = '_tbl_rebate_record';
    $conditions = [
        'joinl' => [
            'tblcurrent_term' => ' on _tbl_rebate_record.rebateTerm = tblcurrent_term.id',
        ]
    ];
    $rebateRecords = $model->getRows($tblName, $conditions);
}