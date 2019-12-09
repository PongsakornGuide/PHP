<?php
require_once '../includes/DbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyRequiredParams(array('username', 'sername' , 'photo', 'birthday', 'gender', 'tel','address', 'religion', 'relative_name', 'relative_phone', 'relative_type','disease_user_apps','disease_id','disease_detail','activity_user_apps','activity_name'))) {

        //getting values
        //data ข้อมูลทั่วไป
        $username = $_POST['username'];
        $sername = $_POST['sername'];
        $photo = $_POST['photo'];
        $birthday= $_POST['birthday'];
        $gender = $_POST['gender'];
        $tel = $_POST['tel'];
        $address= $_POST['address'];
        $religion = $_POST['religion'];

        //ญาติ
        $relative_name= $_POST['relative_name'];
        $relative_phone = $_POST['relative_phone'];
        $relative_type = $_POST['relative_type'];

        //disease อาการ
        $disease_user_apps= $_POST['disease_user_apps'];
        $disease_id = $_POST['disease_id'];
        $disease_detail = $_POST['disease_detail'];

        //activity
        $activity_user_apps = $_POST['activity_user_apps'];
        $activity_name = $_POST['activity_name'];

        $db = new DbOperation();
        $response['message'] = 'User created successfully';

        //adding user to database
//        $result = $db->createUser($username, $password, $email, $name, $phone);
//        making the response accordingly
//        if ($result == USER_CREATED) {
//            //สำเร็จ
//            $response['error'] = false;
//            $response['message'] = 'User created successfully';
//
//        } elseif ($result == USER_ALREADY_EXIST) {
//            //ซ้ำ
//            $response['error'] = true;
//            $response['message'] = 'User already exist';
//
//        } elseif ($result == USER_NOT_CREATED) {
//            //error
//            $response['error'] = true;
//            $response['message'] = 'Some error occurred';
//        }

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