<?php
require_once '../includes/Constants.php';
require_once '../includes/DbOperation.php';
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conn, "utf8");
header('Content-Type: application/json; charset=utf-8');
//$sql = "SELECT disease_id FROM users_dise";
$sql = "SELECT * FROM post_timeline CROSS JOIN exception_disease_activity ON post_timeline.id = exception_disease_activity.act_id WHERE exception_disease_activity.disease_id NOT IN (1)";
$result = $conn->query($sql);
$datas = array();
//Fetch into associative array
while ($row = $result->fetch_assoc()) {
    $datas[] = $row;
}
echo json_encode($datas, JSON_NUMERIC_CHECK);
$conn->close();

