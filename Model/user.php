<?php
require_once __DIR__.'/../db/db.php';


class User{

    public function establishConnection(){
        $db=new DBConnection();
        $conn=$db->connect();
        return $conn;
    }

    //signin.php
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
                
                return $row; // contains userRole, userName
            }
        }
        return false;
    }

    //signup.php
    public function emailExists($email){
        $conn=$this->establishConnection();
        $sql="select userID from users where userEmail=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result=$stmt->get_result();

        return $result->num_rows>0;
    }

    //signup.php
    public function createUser($fullname,$email,$pass,$phone,$address,$userRole){
        $conn=$this->establishConnection();
        $sql="insert into users(userName,userEmail,userPassword,phone,address,userRole) values(?,?,?,?,?,?)";
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
        $sql="update users set userPassword=? where userEmail=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('ss',$newPass,$email);
        return $stmt->execute();
    }


    //SHEMA

    public function getUserByEmail($email)
    {
        $conn=$this->establishConnection();
        $sql = "SELECT * FROM users WHERE userEmail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function updatePassword($email, $password)
    {
        $conn=$this->establishConnection();
        $sql = "UPDATE users SET userPassword = ? WHERE userEmail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $password, $email);

        return $stmt->execute();
    }

    public function getClients()
    {
        $conn=$this->establishConnection();
        $sql = "SELECT userID, userName, userEmail
                FROM users
                WHERE userRole = 'CLIENT'
                ORDER BY userName";

        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}


?>