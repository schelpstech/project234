<?php
    include '../model/query.php';

//Add Ticket
if (isset($_POST['submit_Ticket_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'newTicket') {
    $reference = $utility->generateRandomDigits(8);
    //Create New Support Ticket
    if (
        (!empty($_POST['ticketType']))
        && (!empty($_POST['ticketSubject']))
        && (!empty($_POST['ticketDetails']))
    ) {
        $ticket_data = [
            'schCode' => $_SESSION['active'],
            'ticketRefNumber' => $reference,
            'ticketType' => htmlspecialchars($_POST['ticketType']),
            'ticketSubject' => htmlspecialchars($_POST['ticketSubject']),
        ];
        $conversation_data = [
            'schCode' => $_SESSION['active'],
            'ticketID' => $reference,
            'message' => htmlspecialchars($_POST['ticketDetails']),
            'sent_by' => $_SESSION['active'],
        ];
        if ($model->insert_data('_tbl_ticket', $ticket_data) == true && $model->insert_data('_tbl_conversation', $conversation_data) == true) {
            $user->recordLog($_SESSION['active'], 'New Support Ticket', 'A new support ticket has been submitted for school with code : ' . $_POST['sch_name']);
            $utility->notifier('success', 'You have Successfully submitted a new support for school with code: ' . $_POST['sch_name']);
            $model->redirect('./router.php?pageid=' . base64_encode('ticketLog'));
        } else {
            $utility->notifier('dark', 'There was an error submitting your support ticket for school with code: ' . $_POST['sch_name']);
            $model->redirect('./router.php?pageid=' . base64_encode('newTicket'));
        }
    } else {
        $utility->notifier('danger', 'There are some missing fields. Ensure all fields are inputed.');
        $model->redirect('./router.php?pageid=' . base64_encode('newTicket'));
    }

}
//Reply Ticket
elseif (isset($_POST['replyTicketForm']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'newTicket') {
    //Support Ticket
    if (
        (!empty($_POST['sch_code']))
        && (!empty($_POST['ticketid']))
        && (!empty($_POST['ticketDetails']))
    ) {

        $ticket_data = [
            'lastReply' => 11,
            'ticketStatus' => 1,
            'RecordTime' => date("Y-m-d h:i:sa"),
        ];

        $condition = [
            'ticketRefNumber' => $_SESSION['ticketid']
        ];

        $conversation_data = [
            'schCode' => $_SESSION['active'],
            'ticketID' => $_SESSION['ticketid'],
            'message' => htmlspecialchars($_POST['ticketDetails']),
            'sent_by' => $_SESSION['active']
        ];

        if ($model->upDate('_tbl_ticket', $ticket_data, $condition) == true && $model->insert_data('_tbl_conversation', $conversation_data) == true) {
            $user->recordLog($_SESSION['active'], 'Support Ticket Reply', 'A new reply has been updated on support ticket #' . $_SESSION['ticketid'] . ' for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'Your reply has been submitted for school with code: ' . $_SESSION['active']);
            $model->redirect('./router.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid']);
        } else {
            $utility->notifier('dark', 'There was an error submitting the reply to your support ticket for school with code: ' . $_SESSION['active']);
            $model->redirect('./router.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid']);
        }
    } else {
        $utility->notifier('danger', 'There are some missing fields. Ensure all fields are inputed.');
        $model->redirect('./router.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid']);
    }

} 
//Admin Reply

elseif (isset($_POST['replyTicketForm']) && isset($_SESSION['activeAdmin']) ) {
        //Reply Support Ticket
        if (
            (!empty($_POST['sch_code']))
            && (!empty($_POST['ticketid']))
            && (!empty($_POST['ticketDetails']))
        ) {
    
            $ticket_data = [
                'lastReply' => 22,
                'ticketStatus' => 1,
                'RecordTime' =>  date('Y-m-d H:i:s'),
            ];
    
            $condition = [
                'ticketRefNumber' => $_SESSION['ticketid']
            ];
    
            $conversation_data = [
                'schCode' => $_POST['sch_code'],
                'ticketID' => $_SESSION['ticketid'],
                'message' => htmlspecialchars($_POST['ticketDetails']),
                'sent_by' => $_SESSION['activeAdmin']
            ];
    
            if ($model->upDate('_tbl_ticket', $ticket_data, $condition) == true && $model->insert_data('_tbl_conversation', $conversation_data) == true) {
                $user->recordLog( $_POST['sch_code'], 'Support Ticket Reply', 'A new reply has been updated on support ticket #' . $_SESSION['ticketid'] . ' for school with code : ' . $_SESSION['active']);
                $utility->notifier('success', 'Your reply has been submitted for school with code: ' . $_POST['sch_code']);
                $model->redirect('../app/adminRouter.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid'].'&schCode='.$data['schCode']);
            } else {
                $utility->notifier('dark', 'There was an error submitting the reply to your support ticket for school with code: ' . $_POST['sch_code']);
                $model->redirect('../app/adminRouter.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid'].'&schCode='.$data['schCode']);
            }
        } else {
            $utility->notifier('danger', 'There are some missing fields. Ensure all fields are inputed.');
            $model->redirect('../app/adminRouter.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid'].'&schCode='.$data['schCode']);
        }
    
}
else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}
?>