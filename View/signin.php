
<html>

<head>
    <!-- <link rel="stylesheet" href="signinStyle.css"> -->
</head>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 50%;
    }

    #signinPage {
        border: 2px solid #1749c7;
        border-radius: 10px;
        width: 300px;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    #signinPage form {
        width: 100%;
    }

    .top-buttons {
        display: flex;
        width: 100%;
        border: 1px solid #d9deea;
        border-radius: 7px;
        overflow: hidden;
        margin-bottom: 22px;


    }

    .top-buttons form {
        flex: 1;
        margin: 0;
    }

    .top-buttons input {
        width: 100%;
        padding: 8px;
        border: none;
        background-color: white;
        font-size: 14px;
        cursor: pointer;
    }

    .top-buttons .sgnin {
        background-color: #e9efff;
        color: #1749c7;

    }

    #email,
    #pass {
        height: 35px;
        border: 2px solid black;
        border-radius: 5px;
        width: 100%;
    }

    #sbmt {
        padding: 10px 10px;
        width: 100%;
        color: white;
        background-color: #1749c7;
        border-radius: 10px;
        border: 1px solid #1749c7;
        cursor: pointer;
    }

    label {
        font-weight: bold;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .signuplink {
        text-align: center;
    }

    h1 {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<body>


    <div id="signinPage">
        <h1>RentEase</h1>
        <br>

        <div class="top-buttons">
            <form action="">
                <input type="submit" name="sgnin" class="sgnin" value="Sign in">
            </form>

            <form action="index.php" method="get">
                <input type="hidden" name="page" value="signup">
                <input type="submit" value="Sign Up">
            </form>
        </div>


        <form action="controller/loginHandler.php" method="POST">
            <label for="">User Name</label>
            <br>
            <input type="text" name="email" id="email" placeholder="Enter your user name">
            <br><br>

            <label for="">Password</label>
            <br>
            <input type="password" name="pass" id="pass" placeholder="Enter your password">
            <br>

            <a href="index.php?page=forgotPass"
                style="display:block;text-align:right;color:#1749c7;text-decoration:none">
                Forgot password?
            </a>

            <br>
            <?php
            
            if (isset($_SESSION['errormsg']))
                echo "<span style='color:red; display:block;text-align:center' >" . $_SESSION['errormsg'] . "</span><br>" ?>

                <input type="submit" name="sbmt" id="sbmt" value="Sign in">
                <br>
                <p class="signuplink">Don't have an account? <a href="index.php?page=signup"
                        style="color:#1749c7;text-decoration:none">Sign up</a></p>

            </form>
        </div>


    </body>

    </html>