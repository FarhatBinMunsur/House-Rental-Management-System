<?php

require_once __DIR__ . '/../db/db.php';

class OwnerModel{
    function establishConnection(){
        $db=new DBconnection();
        $conn=$db->connect();
        return $conn;
    }

    public function getAllOwners(){
        $conn=$this->establishConnection();
        $sql="select * from users where userRole='owner'";
        $result=$conn->query($sql);

        $Owners=[];

        if($result && $result->num_rows>0){
            while($row=$result->fetch_assoc()){
                array_push($Owners,$row);
            }
        }
        return $Owners;
    }

    public function insertOwner($name,$email,$phone,$address){
        $conn=$this->establishConnection();
        $sql="insert into users(userName,userEmail,userPassword,userRole,phone,address) values(?,?,?,?,?,?)";
        $stmt=$conn->prepare($sql);

        $role='owner';
        $password='12345';

        $stmt->bind_param('ssssss',$name,$email,$password,$role,$phone,$address);
        $success=$stmt->execute();

        if($success) return $conn->insert_id;
        else return $conn->error;
    }

    public function updateOwner($id,$name,$email,$phone,$address){
        $conn=$this->establishConnection();
        $sql="update users set userName=? , userEmail=? , phone = ? , address =? where userID=? and userRole='owner'";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('ssssi',$name,$email,$phone,$address,$id);
        
        return $stmt->execute();
    }

    public function deleteOwner($id){
        $conn=$this->establishConnection();
        $sql="delete from users where userID=? and userRole='owner'";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();

    }

    
    public function getOwnerById($id){
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

}

?>
