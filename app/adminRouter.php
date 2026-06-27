<?php
include '../model/query.php';

if (empty($_SESSION['activeAdmin'])) {
    $utility->notifier('danger', 'Access Denied! Please sign in again.');
    $model->redirect('../login/manager.php');
}

$pageId = isset($_GET['pageid']) ? base64_decode((string) $_GET['pageid'], true) : 'dashboard';

$routes = [
    'schoolProfile' => [
        'pageName' => 'School Profile',
        'pageDescription' => 'School Profile information',
    ],
    'schoolCreate' => [
        'pageName' => 'Create New CRSM School Profile',
        'pageDescription' => 'Create New CRSM School Profile on the CRSM Portal',
    ],
    'personnelProfile' => [
        'pageName' => 'School Personnel Report',
        'pageDescription' => 'School Personnel Profile information',
    ],
    'schPersonnelList' => [
        'pageName' => 'School Personnel List',
        'pageDescription' => 'School Personnel Profile information',
        'params' => ['schCode' => 'schCode'],
    ],
    'personnelInfoPage' => [
        'pageName' => 'School Personnel Information Page',
        'pageDescription' => 'View all the information about the selected staff in a CRSM School',
        'params' => ['personnelRef' => 'personnelRef'],
    ],
    'userProfile' => [
        'pageName' => 'Admin Profile',
        'pageDescription' => 'Update profile information',
    ],
    'activity_log' => [
        'pageName' => 'Activity Log',
        'pageDescription' => 'See information about all the activities that you have done on the portal',
        'identifier' => true,
    ],
    'ticketLog' => [
        'pageName' => 'Support Ticket Log',
        'pageDescription' => 'See all inquiries and complain ticket request of schools on the portal',
        'identifier' => true,
    ],
    'conversation' => [
        'pageName' => 'Support Ticket',
        'pageDescription' => 'Working on inquiries and complain ticket request',
        'params' => ['ticketid' => 'ticketid', 'schCode' => 'schCode'],
    ],
    'Corporate' => [
        'pageName' => 'School Corporate Details',
        'pageDescription' => 'View and Validate Corporate Details of Selected School',
        'params' => ['schCode' => 'schCode'],
        'identifier' => true,
    ],
    'Contact' => [
        'pageName' => 'School Contact Details',
        'pageDescription' => 'View and Validate Contact Details of Selected School',
        'params' => ['schCode' => 'schCode'],
        'identifier' => true,
    ],
    'Classes' => [
        'pageName' => 'School Class Details',
        'pageDescription' => 'View and Validate Class Details of Selected School',
        'params' => ['schCode' => 'schCode'],
        'identifier' => true,
    ],
    'Approval' => [
        'pageName' => 'School Approval Details',
        'pageDescription' => 'View and Validate Approval Details of Selected School',
        'params' => ['schCode' => 'schCode'],
        'identifier' => true,
    ],
    'Facility' => [
        'pageName' => 'School Facility Details',
        'pageDescription' => 'View and Validate Facility Available in the Selected School',
        'params' => ['schCode' => 'schCode'],
        'identifier' => true,
    ],
    'ResetPassword' => [
        'pageName' => 'School Password Reset',
        'pageDescription' => 'Reset Password in the Selected School',
        'identifierText' => 'Working on Resetting School Portal Access Password',
    ],
    'enrolmentTable' => [
        'pageName' => 'School Enrolment Records',
        'pageDescription' => 'School Finance Portal',
    ],
    'enrolmentbyTerm' => [
        'pageName' => 'Termly School Enrolment Record',
        'pageDescription' => 'Termly Enrolment Record',
        'params' => ['schCode' => 'schCode'],
    ],
    'schEnrolmentDetails' => [
        'pageName' => 'School Enrolment Record - Class -Tuition Breakdown',
        'pageDescription' => 'Termly Enrolment Record',
        'params' => ['termRef' => 'termRef', 'schoolcode' => 'schCode'],
    ],
    'rebateManager' => [
        'pageName' => 'School Rebate Application',
        'pageDescription' => 'School Finance Portal',
    ],
    'rebateDetails' => [
        'pageName' => 'School Rebate Application Details',
        'pageDescription' => 'View and Validate Rebate Application Details',
        'params' => ['rebateRef' => 'rebateRef', 'schCode' => 'schCode'],
    ],
    'financeProfile' => [
        'pageName' => 'School Invoice List',
        'pageDescription' => 'School Finance Portal',
    ],
    'schInvoicePage' => [
        'pageName' => 'School Termly Invoice',
        'pageDescription' => 'View and Validate Invoices of Selected School',
        'params' => ['schCode' => 'schCode'],
    ],
    'termlyRemittanceInvoice' => [
        'pageName' => 'School Termly Remittance Invoice',
        'pageDescription' => 'View and Validate the invoice of Selected Term in the School',
        'params' => ['termRef' => 'termRef', 'schCode' => 'schCode'],
    ],
    'conferenceReport' => [
        'pageName' => 'Conference Registration Report',
        'pageDescription' => 'View the registration details for Conference',
    ],
];

unset($_SESSION['personnelRef'], $_SESSION['ticketid'], $_SESSION['termRef'], $_SESSION['rebateRef']);

if (!is_string($pageId) || !isset($routes[$pageId])) {
    $_SESSION['pageName'] = 'Admin Dashboard';
    $_SESSION['identifier'] = '<h6 class="font-weight-semibold text-lg mb-0">signed in as :: ' . safeRouteValue($_SESSION['activeAdmin']) . '</h6>';
    $_SESSION['pageDescription'] = 'CRSM Admin portal';
    $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('dashboard'));
}

$route = $routes[$pageId];
foreach ($route['params'] ?? [] as $source => $destination) {
    if (!isset($_GET[$source])) {
        $utility->notifier('danger', 'The requested page is missing required information.');
        $model->redirect('../pages/admin/index.php?pageid=' . base64_encode('dashboard'));
    }

    $_SESSION[$destination] = safeRouteValue($_GET[$source]);
}

$_SESSION['pageName'] = $route['pageName'];
$_SESSION['pageDescription'] = $route['pageDescription'];

if (!empty($route['identifierText'])) {
    $_SESSION['identifier'] = '<h6 class="font-weight-semibold text-lg mb-0">' . $route['identifierText'] . '</h6>';
} elseif (!empty($route['identifier']) || isset($_SESSION['schCode'])) {
    $_SESSION['identifier'] = '<h6 class="font-weight-semibold text-lg mb-0">Working on School with Code :: ' . ($_SESSION['schCode'] ?? '') . '</h6>';
} else {
    unset($_SESSION['identifier']);
}

if ($pageId === 'conversation') {
    $_SESSION['pageName'] = 'Support Ticket :: ' . ($_SESSION['ticketid'] ?? '');
    $_SESSION['pageDescription'] = 'Working on inquiries and complain ticket request of School with Code :: ' . ($_SESSION['schCode'] ?? '');
}

$model->redirect('../pages/admin/index.php?pageid=' . base64_encode($pageId));

function safeRouteValue($value)
{
    return preg_replace('/[^A-Za-z0-9_.@-]/', '', trim((string) $value));
}
