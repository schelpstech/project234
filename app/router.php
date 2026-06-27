<?php
include '../model/query.php';

if (empty($_SESSION['active'])) {
  $utility->notifier('danger', 'Access Denied! Please sign in again.');
  $model->redirect('../login/school.php');
}

$pageId = isset($_GET['pageid']) ? base64_decode((string) $_GET['pageid'], true) : false;

$routes = [
  'corporate_form' => ['current_page' => 'corporate_form', 'include' => './forms/corporate.php'],
  'availableClasses' => ['current_page' => 'availableClasses', 'include' => './forms/availableClasses.php'],
  'contact_form' => ['current_page' => 'contact_form', 'include' => './forms/contact.php'],
  'approval_record' => ['current_page' => 'approval_record', 'include' => './forms/approval.php'],
  'facility_record' => ['current_page' => 'facility_record', 'include' => './forms/facilities.php'],
  'add_personnel' => ['current_page' => 'add_personnel', 'include' => './forms/add_personnel.php'],
  'editPersonnel' => ['current_page' => 'add_personnel', 'include' => './forms/editPersonnel.php', 'params' => ['personnelRef']],
  'Personneldocs' => ['current_page' => 'add_personnel', 'include' => './forms/personnelDocs.php', 'params' => ['personnelRef']],
  'post_vacancy' => ['current_page' => 'post_vacancy', 'include' => './forms/post_vacancy.php'],
  'activity_log' => ['current_page' => 'activity_log', 'include' => './report/activityLog.php'],
  'newTicket' => ['current_page' => 'newTicket', 'include' => './forms/ticket.php'],
  'ticketLog' => ['current_page' => 'newTicket', 'include' => './report/myTickets.php'],
  'conversation' => ['current_page' => 'newTicket', 'include' => './forms/conversation.php', 'params' => ['ticketid']],
  'accesscode' => ['current_page' => 'Authentication', 'include' => './forms/accesscode.php'],
  'userProfile' => ['current_page' => 'Authentication', 'include' => './forms/userprofile.php'],
  'academic' => ['current_page' => 'Termly Academic Report', 'include' => './forms/academicReport.php'],
  'editAcademic' => ['current_page' => 'Termly Academic Report', 'include' => './forms/modifyAcademicReport.php', 'params' => ['reportRef']],
  'enrolment' => ['current_page' => 'availableClasses', 'include' => './forms/enrolment.php'],
  'reBate' => ['current_page' => 'availableClasses', 'include' => './forms/rebate.php'],
  'jesusTime' => ['current_page' => 'JT Termly Report', 'include' => './forms/jesusTime.php'],
  'editJTreport' => ['current_page' => 'JT Termly Report', 'include' => './forms/editJTreport.php', 'params' => ['reportRef']],
  'editEnrolment' => ['current_page' => 'availableClasses', 'include' => './forms/editEnrolment.php', 'params' => ['enrolmentRef', 'action']],
  'billGenerator' => ['current_page' => 'availableClasses', 'include' => './forms/billgenerator.php'],
  'transaction' => ['current_page' => 'Finance', 'include' => './report/transaction.php'],
  'uploadEvidenceofPayment' => ['current_page' => 'Finance', 'include' => './forms/uploadpayment.php', 'params' => ['invoiceNum']],
];

unset(
  $_SESSION['personnelRef'],
  $_SESSION['ticketid'],
  $_SESSION['reportRef'],
  $_SESSION['enrolmentRef'],
  $_SESSION['action'],
  $_SESSION['invoiceNum']
);

if ($pageId === 'school_dashboard') {
  $_SESSION['pageid'] = 'school_dashboard';
  $_SESSION['page_name'] = 'Dashboard';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/index.php');
}

if (!is_string($pageId) || !isset($routes[$pageId])) {
  $utility->notifier('danger', 'The requested page is not available.');
  $model->redirect('../pages/school/index.php');
}

$route = $routes[$pageId];
foreach ($route['params'] ?? [] as $param) {
  if (!isset($_GET[$param])) {
    $utility->notifier('danger', 'The requested page is missing required information.');
    $model->redirect('../pages/school/index.php');
  }
  $_SESSION[$param] = sanitizeRouteValue($_GET[$param]);
}

$_SESSION['current_page'] = $route['current_page'];
$_SESSION['include'] = $route['include'];
$_SESSION['module'] = 'school';

$model->redirect('../pages/school/formviewer.php');

function sanitizeRouteValue($value)
{
  return preg_replace('/[^A-Za-z0-9_.-]/', '', trim((string) $value));
}
