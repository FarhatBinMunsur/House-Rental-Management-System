<?php
require_once __DIR__.'/../db/db.php';

class EarningsModel{

    public function establishConnection(){
        $db=new DBConnection();
        $conn=$db->connect();
        return $conn;
    }

    public function getTotalEarnings(){
        $conn=$this->establishConnection();
        $sql="select sum(amount) as total from payment where status='paid'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }

    public function getMonthlyEarnings(){
        $conn=$this->establishConnection();
        $sql="select sum(amount) as total from payment 
              where status='completed' 
              and month(paymentDate)=month(curdate()) 
              and year(paymentDate)=year(curdate())";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }

    public function getPendingPayments(){
        $conn=$this->establishConnection();
        $sql="select sum(amount) as total from payment where status='pending'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }

    public function getRecentTransactions(){
        $conn=$this->establishConnection();

        $sql="select p.paymentID, p.paymentDate, prop.Title, u.userName as clientName, p.amount, p.status
              from payment p
              join booking b on p.bookingID = b.bookingID
              join property prop on b.propertyID = prop.propertyID
              join users u on b.clientID = u.userID
              order by p.paymentDate desc";

        $result=$conn->query($sql);

        $transactions=[];
        if($result && $result->num_rows>0){
            while($row=$result->fetch_assoc()){
                array_push($transactions,$row);
            }
        }
        return $transactions;
    }

    public function getEarningsData(){
        return [
            'summary'=>[
                'totalEarnings'=>$this->getTotalEarnings(),
                'monthlyEarnings'=>$this->getMonthlyEarnings(),
                'pendingPayments'=>$this->getPendingPayments(),
            ],
            'transactions'=>$this->getRecentTransactions()
        ];
    }
}
?>