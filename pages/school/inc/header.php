<?php
include '../../model/query.php';

if (!isset($_SESSION['active']) || empty($_SESSION['active'])) {
    $utility->notifier('danger', 'Access Denied! You are attempting login from an unsecured page!');
    $model->redirect('../../login/school.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <title>
        CRSM Portal - School
    </title>
    <meta name="keywords" content="CRSM Portal - School, CRSM, CRSM Schools, RCCG Schools">
    <meta name="description" content="Christ The Redeemers School Management Online Portal - School Users">
    <link href="../../assets/fonts/googlefont.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/autocomplete-theme-classic.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../../assets/fontawesome/css/all.min.css" />
    <link href="../../assets/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="../../assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link id="pagestyle" href="../../assets/css/corporate-ui-dashboard.min.css?v=1.0.0" rel="stylesheet" />
    <link href="../../assets/css/portal-modern.css" rel="stylesheet" />
    <script src="../../assets/js/ckeditor.js"></script>
    <style>
        .async-hide {
            opacity: 0 !important
        }
    </style>

</head>
