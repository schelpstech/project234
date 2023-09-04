<?php
include '../model/query.php';


//School Dashboard
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'school_dashboard') {
  $_SESSION['pageid'] = 'school_dashboard';
  $_SESSION['page_name'] = 'Dashboard';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/index.php');
}
//School Corporate Form
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'corporate_form') {
  $_SESSION['current_page'] = 'corporate_form';
  $_SESSION['include'] = './forms/corporate.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
//School Available Classes Form
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'availableClasses') {
  $_SESSION['current_page'] = 'availableClasses';
  $_SESSION['include'] = './forms/availableClasses.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
//School Contact Form
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'contact_form') {
  $_SESSION['current_page'] = 'contact_form';
  $_SESSION['include'] = './forms/contact.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
//School Approval Record Form
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'approval_record') {
  $_SESSION['current_page'] = 'approval_record';
  $_SESSION['include'] = './forms/approval.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//School Facility Record Form
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'facility_record') {
  $_SESSION['current_page'] = 'facility_record';
  $_SESSION['include'] = './forms/facilities.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//Add Personnel Record
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'add_personnel') {
  $_SESSION['current_page'] = 'add_personnel';
  $_SESSION['include'] = './forms/add_personnel.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//Edit Personnel Record
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'editPersonnel' ) {
  $_SESSION['current_page'] = 'add_personnel';
  $_SESSION['personnelRef'] = $_GET['personnelRef'];
  $_SESSION['include'] = './forms/editPersonnel.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
//Reupload Personnel Document Record
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'Personneldocs' ) {
  $_SESSION['current_page'] = 'add_personnel';
  $_SESSION['personnelRef'] = $_GET['personnelRef'];
  $_SESSION['include'] = './forms/personnelDocs.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//Post Job Vacancy
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'post_vacancy') {
  $_SESSION['current_page'] = 'post_vacancy';
  $_SESSION['include'] = './forms/post_vacancy.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//View Activity Log
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'activity_log') {
  $_SESSION['current_page'] = 'activity_log';
  $_SESSION['include'] = './report/activityLog.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//Support Ticket
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'newTicket') {
  $_SESSION['current_page'] = 'newTicket';
  $_SESSION['include'] = './forms/ticket.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'ticketLog') {
  $_SESSION['current_page'] = 'newTicket';
  $_SESSION['include'] = './report/myTickets.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'conversation' && isset($_GET['ticketid'])) {
  $_SESSION['current_page'] = 'newTicket';
  $_SESSION['include'] = './forms/conversation.php';
  $_SESSION['ticketid'] = $_GET['ticketid'];
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
//Authentication
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'accesscode') {
  $_SESSION['current_page'] = 'Authentication';
  $_SESSION['include'] = './forms/accesscode.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'userProfile') {
  $_SESSION['current_page'] = 'Authentication';
  $_SESSION['include'] = './forms/userprofile.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'academic') {
  $_SESSION['current_page'] = 'Termly Report';
  $_SESSION['include'] = './forms/academicReport.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'editAcademic') {
  $_SESSION['current_page'] = 'Termly Report';
  $_SESSION['reportRef'] =  $_GET['reportRef'];
  $_SESSION['include'] = './forms/modifyAcademicReport.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}


//Report - Enrolment
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'enrolment') {
  $_SESSION['current_page'] = 'availableClasses';
  $_SESSION['include'] = './forms/enrolment.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

if (isset($_GET['pageid']) && isset($_GET['enrolmentRef']) && base64_decode($_GET['pageid']) == 'editEnrolment') {
  $_SESSION['enrolmentRef'] = $_GET['enrolmentRef'];
  $_SESSION['action'] = $_GET['action'];
  $_SESSION['current_page'] = 'availableClasses';
  $_SESSION['include'] = './forms/editEnrolment.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}


//Report - Invoice Generator
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'billGenerator') {
  $_SESSION['current_page'] = 'availableClasses';
  $_SESSION['include'] = './forms/billgenerator.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//Report - Transaction Table
if (isset($_GET['pageid']) && base64_decode($_GET['pageid']) == 'transaction') {
  $_SESSION['current_page'] = 'Finance';
  $_SESSION['include'] = './report/transaction.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}

//Get Invoice Details
if (isset($_GET['pageid']) && isset($_GET['invoiceNum']) && base64_decode($_GET['pageid']) == 'uploadEvidenceofPayment') {
  $_SESSION['invoiceNum'] = $_GET['invoiceNum'];
  $_SESSION['current_page'] = 'Finance';
  $_SESSION['include'] = './forms/uploadpayment.php';
  $_SESSION['module'] = 'school';
  $model->redirect('../pages/school/formviewer.php');
}
?>