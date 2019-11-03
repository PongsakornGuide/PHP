<?php
require_once '../includes/Constants.php';
require_once '../includes/DbOperation.php';
$conn = new mysqli(DB_HOST,DB_USERNAME, DB_PASSWORD, DB_NAME);
//$sql = "SELECT disease_id FROM users_dise";
$sql = "SELECT * FROM post_timeline CROSS JOIN exception_disease_activity ON post_timeline.id = exception_disease_activity.act_id WHERE exception_disease_activity.disease_id NOT IN (1)";
if($result = mysqli_query($conn,$sql)) {
    echo "YES";
    $resultArray = array();
    $tempArray = array();
    while($row = $result->fetch_object()){
        $tempArray = $row;
        array_push($resultArray, $tempArray);
    }
    echo json_encode($resultArray);
}
echo "completed";

