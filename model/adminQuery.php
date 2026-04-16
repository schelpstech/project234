<?php

// ================= START FILE =================
if (file_exists('../../controller/start.inc.php')) {
    include '../../controller/start.inc.php';
} elseif (file_exists('../controller/start.inc.php')) {
    include '../controller/start.inc.php';
} elseif (file_exists('../../../controller/start.inc.php')) {
    include '../../../controller/start.inc.php';
} else {
    include './controller/start.inc.php';
}

// ================= GUARD =================
if (!isset($_SESSION['activeAdmin'])) return;

// ================= PAGE DETECTION =================
$pageId = isset($_GET['pageid']) ? base64_decode($_GET['pageid']) : 'dashboard';

// ================= GLOBAL CACHE HELPERS =================
function cacheSession($key, $callback)
{
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = $callback();
    }
    return $_SESSION[$key];
}

// ================= GLOBAL DATA (LIGHT ONLY) =================

// 🔹 Active Term (cached across pages)
$currentTerm = cacheSession('currentTerm', function () use ($model) {
    return $model->getRows('tblcurrent_term', [
        'return_type' => 'single',
        'where' => ['termStatus' => 1]
    ]);
});
// 🔥 FULL logs (only for dashboard)
$getallLog = cacheSession('log', function () use ($model) {
    return $model->getRows('log', [
        'order_by' => 'rectime ASC',
        'limit' => 50
    ]);
});


if (isset($_SESSION['schCode'])) {
    $sch_corporate_data = $model->getRows('_tbl_sch_corporate_data', [
        'return_type' => 'single',
        'where' => ['sch_code' => $_SESSION['schCode']]
    ]);
}
// ================= PAGE-BASED LOADING =================

switch ($pageId) {

    // ================= DASHBOARD =================
    case 'dashboard':

        $schoolCounts = cacheSession('schoolCounts', function () use ($model) {
            return [
                'total' => $model->getRows('_tbl_sch_corporate_data', ['return_type' => 'count']),
                'primary' => $model->getRows('_tbl_sch_corporate_data', [
                    'return_type' => 'count',
                    'where_not' => ['available_classes' => 2]
                ]),
                'secondary' => $model->getRows('_tbl_sch_corporate_data', [
                    'return_type' => 'count',
                    'where_not' => ['available_classes' => 1]
                ])
            ];
        });
        break;

    // ================= SCHOOL PROFILE =================
    case 'schoolProfile':

        //Portal Information Compliance
        $complianceReport = cacheSession('_tbl_sch_corporate_data as scd', function () use ($model) {
            return $model->getRows('_tbl_sch_corporate_data as scd', [
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
            ) AS rebate_entries'
            ]);
        });

        break;

    // ================= PERSONNEL =================
    case 'personnelProfile':

        $personnelReport = $model->getRows('tbl_personnel_record', [
            'select' => 'DISTINCT tbl_personnel_record.schCode AS sch,
                         _tbl_sch_corporate_data.sch_name,
                         COUNT(tbl_personnel_record.schCode) AS num,
                         SUM(CASE WHEN tbl_personnel_record.vetted = 0 THEN 1 ELSE 0 END) AS unvetted,
                         SUM(CASE WHEN tbl_personnel_record.vetted = 1 THEN 1 ELSE 0 END) AS vetted',
            'joinl' => [
                '_tbl_sch_corporate_data' => ' on _tbl_sch_corporate_data.sch_code = tbl_personnel_record.schCode'
            ],
            'group_by' => 'tbl_personnel_record.schCode'
        ]);

        break;

    case 'schPersonnelList':

        if (isset($_SESSION['schCode'])) {
            $schPersonnelList = $model->getRows('tbl_personnel_record', [
                'where' => ['schCode' => $_SESSION['schCode']],
                'joinl' => [
                    'job_position_tbl' => ' on job_position_tbl.pos_id = tbl_personnel_record.positionRef',
                    'qualification_tbl' => ' on qualification_tbl.id = tbl_personnel_record.credentialType',
                ]
            ]);
        }

        break;

    case 'personnelInfoPage':

        if (isset($_SESSION['schCode'], $_SESSION['personnelRef'])) {
            $schPersonnelInfo = $model->getRows('tbl_personnel_record', [
                'return_type' => 'single',
                'where' => [
                    'schCode' => $_SESSION['schCode'],
                    'record_id' => $_SESSION['personnelRef']
                ],
                'joinl' => [
                    'job_position_tbl' => ' on job_position_tbl.pos_id = tbl_personnel_record.positionRef',
                    'qualification_tbl' => ' on qualification_tbl.id = tbl_personnel_record.credentialType',
                ]
            ]);
        }

        break;

    // ================= ENROLMENT =================
    case 'enrolmentTable':

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

        break;

    case 'enrolmentbyTerm':

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

        break;

    case 'schEnrolmentDetails':
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
        break;

    // ================= FINANCE =================
    case 'financeProfile':

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

        break;

    case 'schInvoicePage':

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

        break;

    case 'termlyRemittanceInvoice':

        if (isset($_SESSION['schCode']) && isset($_SESSION['termRef'])) {
            $tableName = '_tbl_termlyinvoice';
            $conditions = [
                'where' => [
                    '_tbl_termlyinvoice.schCode' => $_SESSION['schCode'],
                    '_tbl_termlyinvoice.termRef' => $_SESSION['termRef'],
                ],
                'joinl' => [
                    'tblcurrent_term' => ' on _tbl_termlyinvoice.termRef = tblcurrent_term.id'
                ],
                'return_type' => 'single',
            ];
            $termlyRemittance = $model->getRows($tableName, $conditions);
        }

        break;

    // ================= REBATE =================
    case 'rebateManager':

        $tblName = '_tbl_rebate_record';
        $conditions = [
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_rebate_record.rebateTerm = tblcurrent_term.id',
            ]
        ];
        $rebateRecords = $model->getRows($tblName, $conditions);

        break;

    case 'rebateDetails':

        if (isset($_SESSION['schCode']) && isset($_SESSION['rebateRef'])) {
            $tblName = '_tbl_rebate_record';
            $conditions = [
                'where' => [
                    'rebateRef' => $_SESSION['rebateRef'],
                    'schCode' => $_SESSION['schCode']
                ],
                'return_type' => 'single',
                'joinl' => [
                    'tblcurrent_term' => ' on _tbl_rebate_record.rebateTerm = tblcurrent_term.id',
                ]
            ];
            $rebateView = $model->getRows($tblName, $conditions);
        }

        break;

    // ================= LOGS =================
    case 'activity_log':

        $activityLog = $model->getRows('log', [
            'order_by' => 'rectime DESC',
            'limit' => 100
        ]);

        break;

    // ================= TICKETS =================
    case 'ticketLog':

        $tblName = '_tbl_ticket';
        $conditions = [
            'joinl' => [
                '_tbl_sch_corporate_data' => ' on _tbl_sch_corporate_data.sch_code = _tbl_ticket.schCode'
            ],
            'order_by' => 'RecordTime DESC',
        ];
        $ticketlog = $model->getRows($tblName, $conditions);

        break;

    case 'conversation':

        if (isset($_SESSION['ticketid'])) {
            $tblName = '_tbl_conversation';
            $conditions = [
                'where' => [
                    '_tbl_conversation.ticketID' => $_SESSION['ticketid'],
                ],
                'joinl' => [
                    '_tbl_ticket' => ' on _tbl_ticket.ticketRefNumber = _tbl_conversation.ticketID',
                ],
                'order_by' => '_tbl_conversation.rec_time DESC',
            ];
            $chatHistory = $model->getRows($tblName, $conditions);

            $tblName = '_tbl_ticket';
            $conditions = [
                'where' => [
                    'ticketRefNumber' => $_SESSION['ticketid'],
                ],
                'return_type' => 'single',
            ];
            $chatDetails = $model->getRows($tblName, $conditions);
        }

        break;
}
