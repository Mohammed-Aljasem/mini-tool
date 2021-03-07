<?php
///////////////////////////////////////
// Api to fetch times are available
///////////////////////////////////////
//connection DB 
require 'config-DB.php';

header("Content-Type: Application/json");


if (isset($_POST['interested'])) {
  //query fetch interested 
  $sql = "SELECT * FROM inters";
  $result = mysqli_query($con, $sql);

  //handel query command
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
