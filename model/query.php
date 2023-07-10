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


if (isset($_SESSION['current_page'])) {
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
    $conditions = array(
        'return_type' => 'single',
        'where' => array(
            'sch_code' => $_SESSION['active'],
        )
    );
    $sch_corporate_data = $model->getRows($tblName, $conditions);

    //Select School Phonenumbers
    $tblName = '_tbl_phone_number';
    $conditions = array(
        'where' => array(
            'sch_code' => $_SESSION['active'],
        )
    );
    $sch_phone_numbers = $model->getRows($tblName, $conditions);

    //Select School Email Address
    $tblName = '_tbl_email_address';
    $conditions = [
        'where' => array(
            'sch_code' => $_SESSION['active'],
        )
    ];
    $sch_email_address = $model->getRows($tblName, $conditions);

    //Select School Physical Address
    $tblName = '_tbl_sch_address';
    $conditions = [
        'where' => [
            'sch_code' => $_SESSION['active'],
        ],
        'joinl' => array(
            'lga_tbl' => ' on lga_tbl.lga_id = _tbl_sch_address.lga_id',
            'state_tb' => ' on state_tb.state_id = lga_tbl.state_id',
            'region_tbl' => ' on region_tbl.region_id = state_tb.region_id',
            'country_tbl' => ' on country_tbl.country_id = region_tbl.country_id',
        )
    ];
    $sch_phy_address = $model->getRows($tblName, $conditions);

    //Select Available Classes Only
    $tblName = 'tbl_classes';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
        ]
    ];
    $availableClass = $model->getRows($tblName, $conditions);


    //Select Available Classes with Sections
    $tblName = 'tbl_classes';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
        ],
        'joinl' => [
            'approval_type_tbl' => ' on tbl_classes.classSection = approval_type_tbl.id ',
        ]
    ];
    $createdClass = $model->getRows($tblName, $conditions);

    //Set Termly Class Enrolment List
    $tblName = '_tbl_termly_enrolment';
    $conditions = [
        'where' => [
            '_tbl_termly_enrolment.schCode' => $_SESSION['active'],
        ],
        'joinl' => [
            'tbl_classes' => ' on tbl_classes.id = _tbl_termly_enrolment.classID ',
            'tblcurrent_term' => ' on tblcurrent_term.id = _tbl_termly_enrolment.termID',
        ]
    ];
    $enrolmentList = $model->getRows($tblName, $conditions);


    //Select School Approval Address
    $tblName = '_tbl_approval_record';
    $conditions = [
        'where' => [
            'sch_code' => $_SESSION['active'],
        ],
        'joinl' => array(
            'approval_type_tbl' => ' on _tbl_approval_record.approval_id = approval_type_tbl.id',
        )
    ];
    $sch_approval_data = $model->getRows($tblName, $conditions);

    if ($_SESSION['current_page'] == 'facility_record') {

        //Select unselected facilities
        $tblName = 'facility_list';
        $conditions = [
            'null_check' => [
                '_sch_facility_record.sch_code' => "is null",
                '_sch_facility_record.facility_id' => "is Null"
            ],
            'order_by' => 'facility ASC',
            'joinl' => [
                '_sch_facility_record' => ' on facility_list.fac_id = _sch_facility_record.facility_id',
            ]
        ];
        $unselected_facility_list = $model->getRows($tblName, $conditions);

    }

    //Select School Physical Address
    $tblName = '_sch_facility_record';
    $conditions = [
        'where' => [
            'sch_code' => $_SESSION['active'],
        ],
        'joinl' => [
            'facility_list' => ' on _sch_facility_record.facility_id = facility_list.fac_id',
        ]
    ];
    $facility_data = $model->getRows($tblName, $conditions);

    //Select School Personnel Data
    $tblName = 'tbl_personnel_record';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
        ],
        'joinl' => [
            'job_position_tbl' => ' on job_position_tbl.pos_id = tbl_personnel_record.positionRef',
            'qualification_tbl' => ' on qualification_tbl.id = tbl_personnel_record.credentialType',
        ]
    ];
    $personnel_data = $model->getRows($tblName, $conditions);

    if (isset($_SESSION['personnelRef'])) {
        //Select Individual Personnel Data
        $tblName = 'tbl_personnel_record';
        $conditions = [
            'where' => [
                'tbl_personnel_record.schCode' => $_SESSION['active'],
                'tbl_personnel_record.record_id' => $_SESSION['personnelRef'],
            ],
            'joinl' => [
                'job_position_tbl' => ' on job_position_tbl.pos_id = tbl_personnel_record.positionRef',
                'qualification_tbl' => ' on qualification_tbl.id = tbl_personnel_record.credentialType',
            ],
            'return_type' => 'single',
        ];
        $ind_personnel_data = $model->getRows($tblName, $conditions);
    }
    // Select Job Vacancy(s)
    $tblName = '_tbl_job_vacancy';
    $conditions = [
        'where' => [
            'sch_code' => $_SESSION['active'],
        ],
        'joinl' => [
            'job_position_tbl' => ' on job_position_tbl.pos_id = _tbl_job_vacancy.position_id',
            'qualification_tbl' => ' on qualification_tbl.id = _tbl_job_vacancy.vac_min_credential',
        ]
    ];
    $vacancy_data = $model->getRows($tblName, $conditions);

    //Populate Log
    $tblName = 'log';
    $conditions = [
        'where' => [
            'object' => $_SESSION['active'],
        ],
        'order_by' => 'rectime DESC',
        'limit' => '5',
    ];
    $condition = [
        'where' => [
            'object' => $_SESSION['active'],
        ],
        'order_by' => 'rectime DESC'
    ];
    $notification_alert = $model->getRows($tblName, $conditions);
    
    $activityLog = $model->getRows($tblName, $condition);

    //My Support Tickets
    $tblName = '_tbl_ticket';
    $conditions = [
        'where' => [
            'schCode' => $_SESSION['active'],
        ],
        'order_by' => 'RecordTime DESC',
    ];
    $ticketlog = $model->getRows($tblName, $conditions);

    if (isset($_SESSION['ticketid'])) {
        $tblName = '_tbl_conversation';
        $conditions = [
            'where' => [
                '_tbl_conversation.schCode' => $_SESSION['active'],
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
                'schCode' => $_SESSION['active'],
                'ticketRefNumber' => $_SESSION['ticketid'],
            ],
            'return_type' => 'single',
        ];
        $chatDetails = $model->getRows($tblName, $conditions);

    }

    if (isset($_SESSION['current_page']) && $_SESSION['current_page'] == 'Authentication') {

        $tblName = 'tbl_sch_portal_admin';
        $conditions = [
            'where' => [
                'schCode' => $_SESSION['active'],
            ],
            'return_type' => 'single',
        ];
        $adminDetails = $model->getRows($tblName, $conditions);
    }

    if (isset($_SESSION['enrolmentRef']) && $_SESSION['current_page'] == 'availableClasses') {

        $tblName = '_tbl_termly_enrolment';
        $conditions = [
            'where' => [
                '_tbl_termly_enrolment.schCode' => $_SESSION['active'],
                '_tbl_termly_enrolment.recordid' => $_SESSION['enrolmentRef'],
            ],
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_termly_enrolment.termID = tblcurrent_term.id',
                'tbl_classes' => ' on _tbl_termly_enrolment.classID = tbl_classes.id',
            ],
            'return_type' => 'single',
        ];
        $enrolmentRecord = $model->getRows($tblName, $conditions);
    }

    if (isset($_SESSION['current_page']) && $_SESSION['current_page'] == 'Finance') {
        $tblName = '_tbl_termlyinvoice';
        $conditions = [
            'where' => [
                'schCode' => $_SESSION['active'],
            ],
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_termlyinvoice.termRef = tblcurrent_term.id',
            ],
        ];
        $invoiceList = $model->getRows($tblName, $conditions);
    }

    if (isset($_SESSION['invoiceNum']) && isset($_SESSION['current_page']) && $_SESSION['current_page'] == 'Finance') {

        $tblName = '_tbl_termlyinvoice';
        $conditions = [
            'where' => [
                'schCode' => $_SESSION['active'],
                'invReference' => $_SESSION['invoiceNum'],
            ],
            'joinl' => [
                'tblcurrent_term' => ' on _tbl_termlyinvoice.termRef = tblcurrent_term.id',
            ],
            'return_type' => 'single',

        ];
        $invoiceDetails = $model->getRows($tblName, $conditions);
    }

}



?>