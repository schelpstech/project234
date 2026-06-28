<?php
    include '../model/query.php';

$ticketActionRequested = isset($_POST['submit_Ticket_form']) || isset($_POST['replyTicketForm']) || isset($_POST['closeTicketForm']);
if ($ticketActionRequested) {
    $postedCsrf = (string) ($_POST['ticketCsrf'] ?? '');
    if (empty($_SESSION['ticket_csrf']) || !hash_equals($_SESSION['ticket_csrf'], $postedCsrf)) {
        $utility->notifier('danger', 'Security check failed. Please reload the support page and try again.');
        if (!empty($_SESSION['activeAdmin'])) {
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('ticketLog'));
        }
        $model->redirect('./router.php?pageid=' . base64_encode('ticketLog'));
    }
}

//Add Ticket
if (isset($_POST['submit_Ticket_form']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'newTicket') {
    $reference = $utility->generateRandomDigits(8);
    $schoolName = $sch_corporate_data['sch_name'] ?? ($_SESSION['active'] ?? 'School');
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
            $user->recordLog($_SESSION['active'], 'New Support Ticket', 'A new support ticket has been submitted for school with code : ' . $_SESSION['active']);
            $utility->notifier('success', 'You have successfully submitted a new support ticket for ' . $schoolName . '.');
            $model->redirect('./router.php?pageid=' . base64_encode('ticketLog'));
        } else {
            $utility->notifier('dark', 'There was an error submitting your support ticket for ' . $schoolName . '.');
            $model->redirect('./router.php?pageid=' . base64_encode('newTicket'));
        }
    } else {
        $utility->notifier('danger', 'There are some missing fields. Ensure all fields are inputed.');
        $model->redirect('./router.php?pageid=' . base64_encode('newTicket'));
    }

}
//Close Ticket
elseif (isset($_POST['closeTicketForm']) && (!empty($_SESSION['active']) || !empty($_SESSION['activeAdmin']))) {
    $ticketId = preg_replace('/[^A-Za-z0-9_.@-]/', '', (string) ($_POST['ticketid'] ?? $_SESSION['ticketid'] ?? ''));
    $schoolCode = !empty($_SESSION['active'])
        ? $_SESSION['active']
        : preg_replace('/[^A-Za-z0-9_.@-]/', '', (string) ($_POST['sch_code'] ?? $_SESSION['schCode'] ?? ''));
    $actor = !empty($_SESSION['activeAdmin']) ? $_SESSION['activeAdmin'] : $_SESSION['active'];

    if ($ticketId === '' || $schoolCode === '') {
        $utility->notifier('danger', 'Ticket could not be verified.');
        if (!empty($_SESSION['activeAdmin'])) {
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('ticketLog'));
        }
        $model->redirect('./router.php?pageid=' . base64_encode('ticketLog'));
    }

    try {
        $stmt = $db_conn->prepare("
            UPDATE _tbl_ticket
            SET ticketStatus = 0,
                RecordTime = ?
            WHERE ticketRefNumber = ? AND schCode = ?
        ");
        $stmt->execute([date('Y-m-d H:i:s'), $ticketId, $schoolCode]);
        if ($stmt->rowCount() < 1) {
            throw new RuntimeException('Ticket close update did not match any record.');
        }

        $conversation = $db_conn->prepare("
            INSERT INTO _tbl_conversation (schCode, ticketID, message, sent_by)
            VALUES (?, ?, ?, ?)
        ");
        $conversation->execute([$schoolCode, $ticketId, 'Ticket closed by ' . $actor . '.', $actor]);

        $user->recordLog($schoolCode, 'Support Ticket Closed', 'Support ticket #' . $ticketId . ' was closed by ' . $actor);
        $utility->notifier('success', 'Ticket has been closed.');
    } catch (Throwable $e) {
        error_log('Close support ticket failed: ' . $e->getMessage());
        $utility->notifier('danger', 'Unable to close the ticket. Please try again.');
    }

    if (!empty($_SESSION['activeAdmin'])) {
        $model->redirect('./adminRouter.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $ticketId . '&schCode=' . $schoolCode);
    }
    $model->redirect('./router.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $ticketId);
}
//Reply Ticket
elseif (isset($_POST['replyTicketForm']) && empty($_SESSION['activeAdmin']) && isset($_SESSION['current_page']) && ($_SESSION['current_page']) == 'newTicket') {
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
                $user->recordLog( $_POST['sch_code'], 'Support Ticket Reply', 'A new reply has been updated on support ticket #' . $_SESSION['ticketid'] . ' for school with code : ' . $_POST['sch_code']);
                $utility->notifier('success', 'Your reply has been submitted for school with code: ' . $_POST['sch_code']);
                $model->redirect('./adminRouter.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid'].'&schCode='.$_POST['sch_code']);
            } else {
                $utility->notifier('dark', 'There was an error submitting the reply to your support ticket for school with code: ' . $_POST['sch_code']);
                $model->redirect('./adminRouter.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid'].'&schCode='.$_POST['sch_code']);
            }
        } else {
            $utility->notifier('danger', 'There are some missing fields. Ensure all fields are inputed.');
            $model->redirect('./adminRouter.php?pageid=' . base64_encode('conversation') . '&ticketid=' . $_SESSION['ticketid'].'&schCode='.$_POST['sch_code']);
        }
    
}
else {
    $utility->notifier('dark', 'Sorry we can not understand your request');
    if (!empty($_SESSION['activeAdmin'])) {
        $model->redirect('./adminRouter.php?pageid=' . base64_encode('ticketLog'));
    }
    $model->redirect('./router.php?pageid=' . base64_encode('school_dashboard'));
}
?>
