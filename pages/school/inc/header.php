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
    <link rel="canonical" href="https://www.creative-tim.com/product/corporate-ui-dashboard-pro" />
    <meta name="keywords" content="CRSM Portal - School, CRSM, CRSM Schools, RCCG Schools">
    <meta name="description" content="Christ The Redeemers School Management Online Portal - School Users">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://demos.creative-tim.com/argon-design-system-pro/assets/css/nucleo-icons.css"
        type="text/css">
    <link href rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://demos.creative-tim.com/corporate-ui-dashboard-pro/assets/css/corporate-ui-dashboard.min.css"
        type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/@algolia/autocomplete-theme-classic" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700"
        rel="stylesheet" />
    <link
        href="https://demos.creative-tim.com/corporate-ui-dashboard-pro/assets/css/corporate-ui-dashboard.min.css?v=1.0.0"
        rel="stylesheet">
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link href="../../assets/css/jquery.dataTables.css" rel="stylesheet" />
    <link id="pagestyle" href="../../assets/css/corporate-ui-dashboard.min.css?v=1.0.0" rel="stylesheet" />
    <style>
        .async-hide {
            opacity: 0 !important
        }
    </style>

</head>