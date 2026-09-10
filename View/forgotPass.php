<html>

<head>
    <!-- <link rel="stylesheet" href="fpass.css"> -->
</head>
    <body>

    <style>
body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 50%;
}

.fpass{
    border: 2px solid #1749c7;
    border-radius: 10px;
    width: 300px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.sbmt{
    padding:10px 10px;
    width: 100%;
    color: white;
    background-color: #1749c7;
    border-radius: 10px;
    border: 1px solid #1749c7;
    cursor: pointer;
}

.back{
    display: block;
    margin: 20px auto 0;
    padding:10px 10px;
    width: 100px;
    color: white;
    background-color: #f10707;
    border-radius: 10px;
    border: 1px solid #f10707;
    cursor: pointer;

}

.email,.pass{
    height: 35px;
    border: 2px solid black;
    border-radius: 5px;
    width: 100%;
}

.rp{
   color: #1749c7;
   font-family: Arial, Helvetica, sans-serif;
}
    </style>

    
    <div class="fpass">
        <form action="forgotPassHandler.php" method="post">
            <h1 class="rp">Reset Password</h1>
            Email:
            <br>
            <input type="text" name="email" id="" class="email">
            <br><br>
            Password:
            <br>
            <input type="password" name="pass" id="" class="pass" required>
            <br><br>

            <input type="submit" name="sbmt" id="" class="sbmt" >

            
            
        </form>

        <form action="index.php" method="post">               
            <input type="submit" name="sbmt" id="" value="Back" class="back" >
            </form>
    </div>
    </body>
</html>