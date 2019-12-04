<?php
require_once '../includes/DbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyRequiredParams(array('user_app_id','caption', 'img'))) {

        //getting values
        $user_app_id = $_POST['user_app_id'];
        $caption = $_POST['caption'];
        $img = $_POST['img'];

        //creating db operation object
        $db = new DbOperation();
        //adding user to database
        $result = $db->createPost($user_app_id,$caption, $img);
        if ($result == 0) {
            //สำเร็จ
            $response['error'] = false;
            $response['message'] = 'User created successfully';
//            $response['user'] = $db->getUserByUsername($_POST['username']);
        }
    }
    else{
        $response['error'] = true;
        $response['message'] = 'Required parameters are missing';
    }
} else {
    //error
    $response['error'] = true;
    $response['message'] = 'Invalid request';
}

//function to validate the required parameter in request
//กำนหดพารามิเตอร์
function verifyRequiredParams($required_fields)
{
    //Getting the request parameters
    $request_params = $_REQUEST;

    //Looping through all the parameters
    foreach ($required_fields as $field) {
        //if any requred parameter is missing
        // ถ้าพารามิเตอร์ที่กำหนดไม่ครบหรือหายไป
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {

            //returning true;
            return true;
        }
    }
    return false;
}

echo json_encode($response);
