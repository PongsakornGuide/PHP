<?php
require_once '../includes/DbOperation.php';

$response = array();
//$status = $_POST['status'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {




    if (isset($_POST['otp'])) {

        $db = new DbOperation();
        if ($db->checkOtp( $_POST['otp'])) {
            $response['error'] = false;
            $response['message'] = "HELLO";
//            $result = $db->updateStatus();
//            $response = $db->updateStatus($_POST['id']);

        } else {
            $response['error'] = true;
            $response['message'] = 'Invalid username or password';
        }

    } else {
        $response['error'] = true;
        $response['message'] = 'Parameters are missing';
    }

}


else {
    $response['error'] = true;
    $response['message'] = "Request not allowed";
}

echo json_encode($response);