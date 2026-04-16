<?php
include '../../model/adminQuery.php';

if (!isset($_SESSION['activeAdmin']) || empty($_SESSION['activeAdmin'])) {
    $utility->notifier('danger', 'Access Denied! You are attempting login from an unsecured page!');
    $model->redirect('../../login/manager.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">

    <title>CRSM Portal - School</title>

    <meta name="keywords" content="CRSM Portal - School, CRSM, CRSM Schools, RCCG Schools">
    <meta name="description" content="Christ The Redeemers School Management Online Portal - School Users">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />

    <!-- Icons -->
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/fontawesome/css/all.min.css" />

    <!-- Core CSS -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link id="pagestyle" href="../../assets/css/corporate-ui-dashboard.min.css?v=1.0.0" rel="stylesheet" />

    <!-- Plugins CSS -->
    <link href="../../assets/css/autocomplete-theme-classic.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/buttons.bootstrap4.min.css">

    <!-- JS -->
    <script src="../../assets/js/jquery-3.7.0.js"></script>
    <script src="../../assets/js/ckeditor.js"></script>
    <script src="../../assets/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/dataTables.buttons.min.js"></script>
    <script src="../../assets/js/jszip.min.js"></script>
    <script src="../../assets/js/buttons.html5.min.js"></script>
    <script src="../../assets/js/buttons.print.min.js"></script>

    <style>
        .async-hide {
            opacity: 0 !important;
        }
    </style>
</head>