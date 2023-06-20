<?php
include '../model/query.php';
//Job Vacancy Module
if (isset($_POST['submitVacancyPost']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'post_vacancy') {
        //Create Job Vacancy Post 
        if ( (!empty($_POST['positionId']))
         && (!empty($_POST['modeEmployment']))
          && (!empty($_POST['dateEmployment']))
           && (!empty($_POST['title']))
            && (!empty($_POST['qualification']))
             && (!empty($_POST['jobDescription']))
         ) {
            $tblName = '_tbl_job_vacancy';
            $vacancy_post_data = [
                'sch_code' => $_SESSION['active'],
                'position_id' => htmlspecialchars($_POST['positionId']),
                'mode_of_emp' => htmlspecialchars($_POST['modeEmployment']),
                'vac_app_deadline' => htmlspecialchars($_POST['dateEmployment']),
                'vac_post_date' => (date('Y-m-d')),
                'vac_job_title' => htmlspecialchars($_POST['title']),
                'vac_min_credential' => htmlspecialchars($_POST['qualification']),
                'job_description' => htmlspecialchars($_POST['jobDescription'])
            ];
            if ($model->insert_data($tblName, $vacancy_post_data) == true) {
                $user->recordLog($_SESSION['active'], 'Job Vacancy Post Submission', 'A new job vacancy post has been submitted for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'You have Successfully submitted a new job vacancy post for school with code: ' . $_POST['sch_name']);
                $model->redirect('./router.php?pageid=' . base64_encode('post_vacancy'));
            } else {
                $utility->notifier('dark', 'There was an error submitting your job vacancy post for school with code: ' . $_POST['sch_name']);
                $model->redirect('./router.php?pageid=' . base64_encode('post_vacancy'));
            }
        } else {
            $utility->notifier('danger', 'There are some missing fields. Ensure all fields are inputed.');
            $model->redirect('./router.php?pageid=' . base64_encode('post_vacancy'));
        }
} else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}