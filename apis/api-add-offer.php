<?php
///////////////////////////////////////
// Api to save offer are sent
///////////////////////////////////////


//connection DB 
require 'config-DB.php';


if (isset($_POST['user'], $_POST['offer'], $_POST['inters'])) {
  //define variables 
  $user_id   = $_POST['user'];
  $offer_id  = $_POST['offer'];
  $inters_id  = $_POST['inters'];


  //query sql to insert offer information 
  $query  = "INSERT INTO user_offer (offer_id, user_id, inters_id) 
                    VALUES ('$offer_id', '$user_id', '$inters_id') ";

  $result = mysqli_query($con, $query);

  //handel query command
  if ($result) {
    //get last offer id added 
    $last_id = mysqli_insert_id($con);
    $response['success'] = true;
    echo json_encode($response);
  } else {
    //handle request error
    echo $response['success'] = false;
  }
}
