<?php
require_once '../includes/DbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['tel'])) {
        $db = new DbOperation();
        if ($db->userLogin( $_POST['tel'])) {
            $response['error'] = false;
            $response['user'] = $db->getUserByUsername($_POST['tel']);
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