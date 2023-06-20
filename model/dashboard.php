<?php
    //check corporate data
    $tblName = '_tbl_sch_corporate_data';
    $conditions = [
        'where' => [
            'sch_code' => $_SESSION['active'],
        ],
        'return_type'=> 'single'
    ];
    $check_corporate = $model->getRows($tblName, $conditions);

    // check contact data

        //check Phone number
        $tblName = '_tbl_phone_number';
        $conditions = [
            'where' => [
                'sch_code' => $_SESSION['active'],
            ],
            'return_type'=> 'single'
        ];
        $check_phone = $model->getRows($tblName, $conditions);

        //check Email Address
        $tblName = '_tbl_email_address';
        $conditions = [
            'where' => [
                'sch_code' => $_SESSION['active'],
            ],
            'return_type'=> 'single'
        ];
        $check_email = $model->getRows($tblName, $conditions);

        //check Physical Address
        $tblName = '_tbl_sch_address';
        $conditions = [
            'where' => [
                'sch_code' => $_SESSION['active'],
            ],
            'return_type'=> 'single'
        ];
        $check_address = $model->getRows($tblName, $conditions);

                //check approval records
                $tblName = '_tbl_approval_record';
                $conditions = [
                    'where' => [
                        'sch_code' => $_SESSION['active'],
                    ],
                    'return_type'=> 'count'
                ];
                $condition = [
                    'where' => [
                        'sch_code' => $_SESSION['active'],
                        'vetted' => 1,
                    ],
                    'return_type'=> 'count'
                ];
                $count_approvals = $model->getRows($tblName, $conditions);
                $vetted_approvals = $model->getRows($tblName, $condition);

                    //check Facility records
                $tblName = '_sch_facility_record';
                $conditions = [
                    'where' => [
                        'sch_code' => $_SESSION['active'],
                    ],
                    'return_type'=> 'count'
                ];
                $condition = [
                    'where' => [
                        'sch_code' => $_SESSION['active'],
                        'vetted' => 1,
                    ],
                    'return_type'=> 'count'
                ];
                $count_facility = $model->getRows($tblName, $conditions);
                $vetted_facility = $model->getRows($tblName, $condition);
                   
                //check Personnel records
                $tblName = 'tbl_personnel_record';
                $conditions = [
                    'where' => [
                        'schCode' => $_SESSION['active'],
                    ],
                    'return_type'=> 'count'
                ];
                $condition = [
                    'where' => [
                        'schCode' => $_SESSION['active'],
                        'vetted' => 1,
                    ],
                    'return_type'=> 'count'
                ];
                $count_personnel = $model->getRows($tblName, $conditions);
                $vetted_personnel = $model->getRows($tblName, $condition);
?>