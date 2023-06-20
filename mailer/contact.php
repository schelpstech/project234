<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require '../controller/start.inc.php';


$tblName = 'enabler';
$conditions = [
  'return_type' => 'single',
  'where' => [
    'id' => 1,
  ]
];
$credential = $model->getRows($tblName, $conditions);


// Send email
if (isset($_POST["emailAddress"])) {
  $user_Email = filter_var($_POST["emailAddress"], FILTER_SANITIZE_EMAIL);
}
if (isset($_POST["token"])) {
  $user_Message = htmlspecialchars($_POST["token"]);
  $_SESSION['email_token'] = $user_Message;
}

// Recipients
$fromEmail = $credential['public']; // Email address that will be in the from field of the message.
$fromName = 'CRSM Portal'; // Name that will be in the from field of the message.
$sendToEmail = $user_Email; // Email address that will receive the message with the output of the form
$sendToName = 'CRSM School Portal Admin'; // Name that will receive the message with the output of the form

// Subject
$subject = 'Email Verification Token';

// SMTP settings
$smtpUse = true; // Set to true to enable SMTP authentication
$smtpHost = $credential['platform']; // Enter SMTP host ie. smtp.gmail.com
$smtpUsername = $credential['public']; // SMTP username ie. gmail address
$smtpPassword = $credential['secret']; // SMTP password ie gmail password
$smtpSecure = 'ssl'; // Enable TLS or SSL encryption
$smtpAutoTLS = false; // Enable Auto TLS
$smtpPort = 465; // TCP port to connect to

// Success and error alerts
$okMessage = 'We have sent a verification token to your email address to be sure it is valid, kindly enter the token in your profile!';
$errorMessage = 'There was an error reaching you via email. Please try again later';


/*
   *  LET'S DO THE SENDING
   */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);
try {
  if (count($_POST) == 0)
    throw new \Exception('Form is empty');
  $emailTextHtml = '
  <p>Hi School Admin : ' . $_SESSION['active'] . ',</p>
                        <p>This is an Email Verification Token for ' . $user_Email . '. Token will be valid for this session from issuance. 

                        <br><br><strong>Your Verification token is: ' . $user_Message . ' </strong><br><br>
                        
                        Sincerely, <br>
                        CRSM Portal 
                         </p>
                        
  ';
  $mail = new PHPMailer;
  $mail->setFrom($fromEmail, $fromName);
  $mail->addAddress($sendToEmail, $sendToName);
  $mail->addReplyTo($fromEmail);
  $mail->isHTML(true);
  $mail->CharSet = 'UTF-8';
  $mail->Subject = $subject;
  $mail->Body = $emailTextHtml;
  $mail->msgHTML($emailTextHtml);
  if ($smtpUse == true) {
    // Tell PHPMailer to use SMTP
    $mail->isSMTP();
    // Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->Debugoutput = function ($str, $level) use (&$mailerErrors) {
      $mailerErrors[] = ['str' => $str, 'level' => $level];
    };
    $mail->SMTPDebug = 3;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = $smtpSecure;
    $mail->SMTPAutoTLS = $smtpAutoTLS;
    $mail->Host = $smtpHost;
    $mail->Port = $smtpPort;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
  }
  if (!$mail->send()) {
    throw new \Exception('I could not send the email.' . $mail->ErrorInfo);
  }
  $responseArray = array('type' => 'success', 'message' => $okMessage);
} catch (\Exception $e) {
  $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
}

  echo $responseArray['message'];
