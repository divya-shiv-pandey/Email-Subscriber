<?php
//$serverName = "127.0.0.1";
//set_time_limit (120);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

$conn = mysqli_connect('localhost', 'databaseId', 'databasePAssword', 'databaseName');
mysqli_query($conn, "SET @@session.wait_timeout=28800");
if (!mysqli_ping($conn)) {
    $conn = mysqli_connect('localhost', 'databaseId', 'databasePAssword', 'databaseName');
}
if (!$conn) {
    echo 'failed to connect';
}

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com'; //smtp server used here
$mail->SMTPAuth   = true;
$mail->Username   = 'emailId'; //put email here for phpmailer
$mail->Password   = 'emailPassword'; //put pasdword here for php mailer
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
$mail->setFrom('Your mail Address here', 'XKCD Comic Subscription');
$mail->addReplyTo('Your email Address here', 'XKCD subscriber');
