<?php
require_once __DIR__.'/../db/db.php';

class ManagerModel{

    public function establishConnection(){
        $db=new DBConnection();
        $conn=$db->connect();
        return $conn;
    }

    public function getAllManagers(){
        $conn=$this->establishConnection();
        $sql="select * from users where userRole='manager' order by userID desc ";
        $result=$conn->query($sql);

        $managers=[];
        if($result && $result->num_rows>0){
            while($row=$result->fetch_assoc()){
                array_push($managers,$row);
            }
        }
        return $managers;
    }

    public function getManagerById($id){
        $conn=$this->establishConnection();
        $sql="select * from users where userID=?";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result=$stmt->get_result();

        if($result->num_rows>0){
            return $result->fetch_assoc();
        }
        return null;
    }

    public function insertManager($name,$email,$phone,$salary,$joiningDate){
        $conn=$this->establishConnection();
        $sql="insert into users(userName,userEmail,userPassword,userRole,phone,salary,joiningDate) values(?,?,?,?,?,?,?)";
        $stmt=$conn->prepare($sql);
        $role='manager';
        $password='12345';
        $stmt->bind_param('sssssds',$name,$email,$password,$role,$phone,$salary,$joiningDate);
        $success=$stmt->execute();

        if($success) return $conn->insert_id;
        else return $conn->error;
    }

    public function updateManager($id,$name,$email,$phone,$salary,$joiningDate){
        $conn=$this->establishConnection();
        $sql="update users set userName=?, userEmail=?, phone=?, salary=?, joiningDate=? where userID=? AND userRole='manager'";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('sssdsi',$name,$email,$phone,$salary,$joiningDate,$id);
        return $stmt->execute();
    }

    public function deleteManager($id){
        $conn=$this->establishConnection();
        $sql="delete from users where userID=? AND userRole='manager'";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('i',$id);
        return $stmt->execute();
    }
}
?>