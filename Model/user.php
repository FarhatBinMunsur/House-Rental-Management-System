<?php
require_once __DIR__.'/../db/db.php';

class User{

    public function establishConnection(){
        $db=new DBConnection();
        $conn=$db->connect();
        return $conn;
    }

    // Used by signin.php
    public function loginCheck($email,$pass){
        $conn=$this->establishConnection();

        $sql="select * from users where userEmail=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result=$stmt->get_result();

        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            if($row['userPassword']==$pass){
                
                return $row; // contains userRole, fullname, id, etc.
            }
        }
        return false;
    }

    public function emailExists($email){
        $conn=$this->establishConnection();

        $sql="select id from users where userEmail=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result=$stmt->get_result();

        return $result->num_rows>0;
    }

    // Used by signup.php
    public function createUser($fullname,$email,$pass,$phone,$address,$userRole){
        $conn=$this->establishConnection();

        $sql="insert into users(fullname,email,pass,phone,address,userRole) values(?,?,?,?,?,?)";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('ssssss',$fullname,$email,$pass,$phone,$address,$userRole);
        $success=$stmt->execute();

        if($success){
            return $conn->insert_id;
        }else{
            return $conn->error;
        }
    }

    // Used by forgotPass.php
    public function resetPassword($email,$newPass){
        $conn=$this->establishConnection();

        $sql="update users set pass=? where email=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('ss',$newPass,$email);
        return $stmt->execute();
    }
}
?>