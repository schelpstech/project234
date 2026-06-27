<?PHP
include '../model/query.php';
if(isset($_SESSION['active']) && !empty($_SESSION['active'])){
  $utility->notifier('success', 'Welcome! You have an active login session!');
  $model->redirect('../pages/school/index.php');
}elseif(isset($_SESSION['activeAdmin']) && !empty($_SESSION['activeAdmin'])){
  $utility->notifier('success', 'Welcome! You have an active login session!');
  $model->redirect('../pages/admin/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Login - CRSM Portal
  </title>
  <!--     Fonts and icons     -->
  <link href="../assets/fonts/googlefont.css" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="../assets/fontawesome/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0" rel="stylesheet" />
  
</head>
