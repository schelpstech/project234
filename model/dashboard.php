<?php
//check corporate data
$tblName = '_tbl_sch_corporate_data';
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['active'],
    ],
    'return_type' => 'single'
];
$check_corporate = $model->getRows($tblName, $conditions);

// check contact data

//check Phone number
$tblName = '_tbl_phone_number';
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['active'],
    ],
    'return_type' => 'single'
];
$check_phone = $model->getRows($tblName, $conditions);

//check Email Address
$tblName = '_tbl_email_address';
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['active'],
    ],
    'return_type' => 'single'
];
$check_email = $model->getRows($tblName, $conditions);

//check Physical Address
$tblName = '_tbl_sch_address';
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['active'],
    ],
    'return_type' => 'single'
];
$check_address = $model->getRows($tblName, $conditions);

//check approval records
$tblName = '_tbl_approval_record';
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['active'],
    ],
    'return_type' => 'count'
];
$condition = [
    'where' => [
        'sch_code' => $_SESSION['active'],
        'vetted' => 1,
    ],
    'return_type' => 'count'
];
$count_approvals = $model->getRows($tblName, $conditions);
$vetted_approvals = $model->getRows($tblName, $condition);

//check Facility records
$tblName = '_sch_facility_record';
$conditions = [
    'where' => [
        'sch_code' => $_SESSION['active'],
    ],
    'return_type' => 'count'
];
$condition = [
    'where' => [
        'sch_code' => $_SESSION['active'],
        'vetted' => 1,
    ],
    'return_type' => 'count'
];
$count_facility = $model->getRows($tblName, $conditions);
$vetted_facility = $model->getRows($tblName, $condition);

//check Personnel records
$tblName = 'tbl_personnel_record';
$conditions = [
    'where' => [
        'schCode' => $_SESSION['active'],
    ],
    'return_type' => 'count'
];
$condition = [
    'where' => [
        'schCode' => $_SESSION['active'],
        'vetted' => 1,
    ],
    'return_type' => 'count'
];
$count_personnel = $model->getRows($tblName, $conditions);
$vetted_personnel = $model->getRows($tblName, $condition);

$tblName = 'tblcurrent_term';
$conditions = [
    'return_type' => 'single',
    'where' => [
        'termStatus' => 1,
    ]
];
$currentTerm = $model->getRows($tblName, $conditions);

//check Jesus Time Report for Current Term termRef
$tblName = '_termly_report_jesustime';
$conditions = [
    'where' => [
        'schCode' => $_SESSION['active'],
        'termRef' => $currentTerm['termID']
    ],
    'return_type' => 'count'
];
$JTreport_status = $model->getRows($tblName, $conditions);


//Count  Available Classes in School
$tblName = 'tbl_classes';
$conditions = [
    'where' => [
        'schCode' => $_SESSION['active'],
    ],
    'return_type' => 'count'
];
$countClasses = $model->getRows($tblName, $conditions);

//check Termly Enrolment for Current Term termRef
$tblName = '_tbl_termly_enrolment';
$conditions = [
    'where' => [
        'schCode' => $_SESSION['active'],
        'termID' => $currentTerm['termID']
    ],
    'return_type' => 'count'
];
$enrolmentReport_status = $model->getRows($tblName, $conditions);


//check Acacemic Reports
$tblName = 'academicreport';
$conditions = [
    'where' => [
        'schCode' => $_SESSION['active'],
    ],
    'return_type' => 'count'
];
$condition = [
    'where' => [
        'schCode' => $_SESSION['active'],
        'vetted' => 1,
    ],
    'return_type' => 'count'
];
$count_acad_report = $model->getRows($tblName, $conditions);
$vetted_acad_report = $model->getRows($tblName, $condition);