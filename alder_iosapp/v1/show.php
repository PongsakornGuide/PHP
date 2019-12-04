<?php
require_once '../includes/Constants.php';
require_once '../includes/DbOperation.php';

$conn = new mysqli(DB_HOST,DB_USERNAME, DB_PASSWORD, DB_NAME);
$sql = "SELECT * FROM ad_post_timeline ";
if($result = mysqli_query($conn,$sql)) {
    $resultArray = array();
    $tempArray = array();
    while($row = $result->fetch_object()){
        $tempArray = $row;
        array_push($resultArray, $tempArray);
    }
    echo json_encode($resultArray);
    echo "completed";
}



