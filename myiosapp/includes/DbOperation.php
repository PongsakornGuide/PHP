<?php

class DbOperation
{
    private $conn;

    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/Constants.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function userLogin($username, $pass){
        //random gen pass
        $password = md5($pass);
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }


    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT id, username , email, phone, disease_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $uname ,$email, $phone, $disease_id);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['username'] = $uname;
        $user['email'] = $email;
        $user['phone'] = $phone;
        $user['disease_id'] = $disease_id;
        return $user;
    }
    public function showActivity(){
        $stmt = $this->conn->prepare("SELECT * FROM post_timeline CROSS JOIN exception_disease_activity ON post_timeline.id = exception_disease_activity.act_id WHERE exception_disease_activity.disease_id NOT IN (1)");
    }

////
//    public function showActivity(){
//     $stmt = $this->conn->prepare("SELECT * FROM post_timeline");
//     //กำหนดค่าที่ออกมาก bind_param
////     $stmt->bind_param("s", $name);
//     $stmt->execute();
//     $stmt->bind_result($id, $name, $act_id, $disease_id);
//     $stmt->fetch();
//     $content = array();
//     $content['id'] = $id;
//     $content['name'] = $name;
//     $content['act_id'] = $act_id;
//     $content['disease_id'] = $disease_id;
//     return $content;
//    }

    //Function to create a new user
    public function createUser($username, $pass, $email, $name, $phone)
    {
        if (!$this->isUserExist($username, $email, $phone)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, name, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $username, $password, $email, $name, $phone);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }
    //เช็ค
    private function isUserExist($username, $email, $phone)
    {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? OR phone = ?");
        $stmt->bind_param("sss", $username, $email, $phone);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}