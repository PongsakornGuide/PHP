<?php
require_once '../includes/DbOperation.php';

$response = array();

    if (isset($_POST['disease_id'])) {
        $db = new DbOperation();
        if ($db->userByDisease($_POST['disease_id'])) {
            $response['error'] = false;
            $response['act'] = $db->getUserByDisease($_POST['disease_id']);
        } else {
            $response['error'] = true;
            $response['message'] = 'Invalid username or password';
        }

    } else {
        $response['error'] = true;
        $response['message'] = 'Parameters are missing';
    }
echo json_encode($response);