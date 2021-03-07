<?php
////////////////////////////
//this Api for fetch all the data for the user and send email 
////////////////////////////
//connection DB 

require 'config-DB.php';

// API Return Value
include('../smtp/PHPMailerAutoload.php');
header("Content-Type: Application/json");
if (isset($_POST['id'])) {
  $id = $_POST['id'];

  //query command fetch data from database

  $query  = " SELECT * FROM user_offer 
  INNER JOIN users ON user_offer.user_id=users.user_id 
  INNER JOIN offers ON user_offer.offer_id=offers.offer_id 
  INNER JOIN inters ON user_offer.inters_id=inters.inters_id 
  WHERE user_offer.user_id = '$id' ";

  $result = mysqli_query($con, $query);

  //handle query command
  if ($result) {

    $resultArr = array();
    while ($rowData = mysqli_fetch_assoc($result)) {
      $resultArr[count($resultArr)] = $rowData;
    }

    $response['success'] = true;

    //define globale variable to send data out of scope
    $GLOBALS['info'] = $resultArr[0];
  }
} else {
  //handle request error
  echo json_encode("missing parmaters");
}


//format the email and add information
$html = 'welcome ' . $info['user_name'] . '<br>you are registered for offer success <br> Offer ID: ' . $info['id'] . '<br>mobile number: ' . $info['user_mobile'] . '<br>The_offer : '  . $info['offer_name'] . '<br> interested: ' . $info['inters_time'];


//function send email (to , the subject , body of email)
echo smtp_mailer($info['user_email'], 'Your Offer', $html);
function smtp_mailer($to, $subject, $msg)
{
  $mail = new PHPMailer();
  $mail->SMTPDebug  = 3;
  $mail->IsSMTP();
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'tls';
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 587;
  $mail->IsHTML(true);
  $mail->CharSet = 'UTF-8';
  $mail->Username = "The email"; //enter email here 
  $mail->Password = "The password"; //enter password here 
  $mail->SetFrom("The email"); //enter email here 
  $mail->Subject = $subject;
  $mail->Body = $msg;
  $mail->AddAddress($to);
  $mail->SMTPOptions = array('ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => false
  ));
  if (!$mail->Send()) {
    echo $mail->ErrorInfo;
  } else {
    return 'Sent';
  }
}
