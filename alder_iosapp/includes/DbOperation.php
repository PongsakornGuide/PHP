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


    public function userLogin($tel){
        $stmt = $this->conn->prepare("SELECT id FROM user_apps WHERE tel = ? ");
        $stmt->bind_param("i",  $tel);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function getUserByUsername($tel)
    {
        $stmt = $this->conn->prepare("SELECT id, name , surname, nickname, birthday , gender , tel ,evaluated_id FROM user_apps WHERE tel = ?");
        $stmt->bind_param("i", $tel);
        $stmt->execute();
        $stmt->bind_result($id, $name , $surname, $nickname, $birthday, $gender, $tel, $evaluated_id);
        $stmt->fetch();
        $user = array();
        $_SESSION['id'] = $id;
        $user['id'] = $id;
        $user['name'] = $name;
        $user['surname'] = $surname;
        $user['nickname'] = $nickname;
        $user['birthday'] = $birthday;
        $user['gender'] = $gender;
        $user['tel'] = $tel;
        $user['evaluated_id'] = $evaluated_id;
        return $user;
    }


//    public function updateStatus(){
//        $stmt = $this->conn->prepare("UPDATE otp SET status = '0' WHERE otp . id = id");
//        $stmt->bind_param("i",$id);
//        $stmt->execute();
//        $stmt->store_result();
//        return $stmt->num_rows > 0;
//    }


//UPDATE `otp` SET `status` = 'Unvariables' WHERE `otp`.`id` = 1;
//INSERT INTO `otp` (`id`, `otp`, `status`, `created_at`, `update_at`) VALUES (NULL, 'sds', 'sds', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000');
//    public function getOtpByBackend($status){
//        $stmt = $this->conn->prepare("UPDATE otp SET status = 'Variables' WHERE id = ?");
//        $stmt->bind_param("s", $status);
//        $stmt->execute();
//        $stmt->fetch();
//        $check = array();
//        $check['status'] = $status;
//        return $check;
//    }


    public function checkOtp($otp){
        $stmt = $this->conn->prepare("SELECT * FROM otp WHERE otp = ?");
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

}