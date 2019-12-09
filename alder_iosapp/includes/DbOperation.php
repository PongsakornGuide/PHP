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

    //Function Login
    public function userLogin($tel){
        $stmt = $this->conn->prepare("SELECT id FROM user_apps WHERE tel = ? ");
        $stmt->bind_param("i",  $tel);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }



    //Function to create a new user
    public function createUser($username, $sername, $photo, $birthday, $gender, $tel, $address, $religion, $relative_name, $relative_phone, $relative_type, $disease_user_apps, $disease_id, $disease_detail, $activity_user_apps, $activity_name)
    {
        if(!$this->isUserExist($username, $sername, $photo, $birthday, $gender, $tel, $address, $religion, $relative_name, $relative_phone, $relative_type)){
            $stmt = $this->conn->prepare("INSERT INTO user_apps (username, sername, photo, birthday, gender, tel, address, religion, relative_name, relative_phone, relative_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,)");
            $stmt->bind_param("sssssisssss", $username, $sername, $photo, $birthday, $gender, $tel, $address, $religion, $relative_name, $relative_phone, $relative_type);


            $stmt = $this->conn->prepare("INSERT INTO exception_disease (disease_user_apps,disease_id,disease_detail) VALUES (?,?,?)");
            $stmt->bind_param("iis",$disease_user_apps,$disease_id,$disease_detail);


            $stmt = $this->conn->prepare("INSERT INTO exception_activity (activity_user_apps,activity_name) VALUES (?,?)");
            $stmt->bind_param("ii",$activity_user_apps,$activity_name);


            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


//    //Function to create a new user
//    public function createUserss($username, $pass, $email, $name, $phone)
//    {
//        if (!$this->isUserExist($username, $email,$phone)) {
//            $password = md5($pass);
//            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, name, phone) VALUES (?, ?, ?, ?, ?)");
//            $stmt->bind_param("sssss", $username, $password, $email, $name, $phone);
//            if ($stmt->execute()) {
//                return USER_CREATED;
//            } else {
//                return USER_NOT_CREATED;
//            }
//        } else {
//            return USER_ALREADY_EXIST;
//        }
//    }


    //    //เช็ค
    private function isUserExist($username, $sername, $photo, $birthday, $gender, $tel, $address, $religion, $relative_name, $relative_phone, $relative_type, $disease_user_apps, $disease_id, $disease_detail, $activity_user_apps, $activity_name)
    {
        $stmt = $this->conn->prepare("SELECT id FROM user_apps WHERE username = ? OR sername = ? OR photo = ? OR birthday = ? OR gender = ? OR tel = ? OR address = ? OR religion = ? OR relative_name = ? OR relative_phone = ? OR relative_type = ?");
        $stmt->bind_param("sssssisssss", $username, $sername, $photo, $birthday, $gender, $tel, $address, $religion, $relative_name, $relative_phone, $relative_type);

        $stmt = $this->conn->prepare("INSERT INTO exception_disease (disease_user_apps,disease_id,disease_detail) VALUES (?,?,?)");
        $stmt->bind_param("iis",$disease_user_apps,$disease_id,$disease_detail);


        $stmt = $this->conn->prepare("INSERT INTO exception_activity (activity_user_apps,activity_name) VALUES (?,?)");
        $stmt->bind_param("ii",$activity_user_apps,$activity_name);


        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }


//    //เช็ค
//    private function isUserExist($username, $email, $phone)
//    {
//        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? OR phone = ? ");
//        $stmt->bind_param("sss", $username, $email, $phone);
//        $stmt->execute();
//        $stmt->store_result();
//        return $stmt->num_rows > 0;
//    }


    //Function Show data
    public function getUserByUsername($tel)
    {
        $stmt = $this->conn->prepare("SELECT id, name , surname,  birthday , gender , tel  FROM user_apps WHERE tel = ?");
        $stmt->bind_param("i", $tel);
        $stmt->execute();
        $stmt->bind_result($id, $name , $surname , $birthday, $gender, $tel);
        $stmt->fetch();
        $user = array();
        $_SESSION['id'] = $id;
        $user['id'] = $id;
        $user['name'] = $name;
        $user['surname'] = $surname;

        $user['birthday'] = $birthday;
        $user['gender'] = $gender;
        $user['tel'] = $tel;

        return $user;
    }

    //Function update status
    public function updateStatus($otp){
        $stmt = $this->conn->prepare("UPDATE otp SET status = '1' WHERE otp = ?");
        $stmt->bind_param("s",$otp);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }



    //Function Check status otp
    public function checkOtp($otp){
        $stmt = $this->conn->prepare("SELECT id FROM otp WHERE otp = ?");
        $stmt->bind_param("s",$otp);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    //Function Post
    public function createPost($user_app_id,$caption,$img){
        $stmt = $this->conn->prepare("INSERT INTO ad_post_timeline (user_app_id,caption,img) VALUES (?,?,?)");
        $stmt->bind_param("iss", $user_app_id,$caption, $img);
        $stmt->execute();
    }




//    //Function to create a new user
//    public function createUser($username, $pass, $email, $name, $phone)
//    {
//        if (!$this->isUserExist($username, $email,$phone)) {
//            $password = md5($pass);
//            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, name, phone) VALUES (?, ?, ?, ?, ?)");
//
//            $stmt->bind_param("sssss", $username, $password, $email, $name, $phone);
//            if ($stmt->execute()) {
//                return USER_CREATED;
//            } else {
//                return USER_NOT_CREATED;
//            }
//        } else {
//            return USER_ALREADY_EXIST;
//        }
//    }
}