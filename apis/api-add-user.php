<?php
///////////////////////////////////////
// Api to save information of user 
///////////////////////////////////////

//connection DB 
require 'config-DB.php';


header("Content-Type: Application/json");


//save user in database
if (isset($_POST['name'], $_POST['mobile'], $_POST['email'])) {
  // define variables
  $name   = $_POST['name'];
  $mobile = $_POST['mobile'];
  $email  = $_POST['email'];


  //query add data user to database
  $query  = "INSERT INTO users (user_name, user_mobile,user_email) 
                    VALUES ('$name', '$mobile','$email') ";


  $result = mysqli_query($con, $query);

  if ($result) {

    //get last id user add 
    $last_id = mysqli_insert_id($con);

    //response 
    $response['success'] = true;
    $response['user_id'] = $last_id;
    echo json_encode($response);
  } else {
    //handle request error
    $response = array('success' => false);
    echo json_encode($response);
  }
} else {
  $response = array('success' => false);
}
