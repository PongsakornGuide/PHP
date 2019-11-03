<?php
require_once '../includes/DbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyRequiredParams(array('username', 'password', 'email', 'name', 'phone'))) {
        //getting values
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        //creating db operation object
        $db = new DbOperation();
        //adding user to database
        $result = $db->createUser($username, $password, $email, $name, $phone);

        //making the response accordingly
        if ($result == USER_CREATED) {
            //สำเร็จ
            $response['error'] = false;
            $response['message'] = 'User created successfully';
        } elseif ($result == USER_ALREADY_EXIST) {
            //ซ้ำ
            $response['error'] = true;
            $response['message'] = 'User already exist';

        } elseif ($result == USER_NOT_CREATED) {
            //error
            $response['error'] = true;
            $response['message'] = 'Some error occurred';
        }
    } else {
        //กรณีเป็นค่าว่าง หรือลืมกรอก
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