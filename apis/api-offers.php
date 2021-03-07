<?php
///////////////////////////////////////
// Api to fetch offers are available
///////////////////////////////////////
//connection DB 
require 'config-DB.php';
header("Content-Type: Application/json");


if (isset($_POST['offers'])) {
  $sql = "SELECT * FROM offers";


  $result = mysqli_query($con, $sql);

  if ($result) {
    $resultArr = array();

    while ($rowData = mysqli_fetch_assoc($result)) {
      $resultArr[count($resultArr)] = $rowData;
    }


    echo $x = json_encode($resultArr);
  }
} else {
  //handle request error
  echo json_encode("missing parmaters");
}
