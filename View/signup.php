<html>

<head>
    <!-- <link rel="stylesheet" href="View/signupstyle.css"> -->
</head>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 50%;

    }

    #signupPage {
        border: 2px solid #1749c7;
        border-radius: 10px;
        width: 300px;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

    }

    #signupPage form {
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
    #pass,
    #fullname,
    #phone {
        height: 35px;
        border: 2px solid black;
        border-radius: 5px;
        width: 100%;
    }

    #address {
        border: 2px solid black;
        border-radius: 5px;
        width: 100%;
        padding: 6px;
        font-family: inherit;
        font-size: inherit;
        resize: vertical;
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

    input::placeholder,
    textarea::placeholder {
        color: #999;
        font-family: Arial, Helvetica, sans-serif;
        opacity: 1;
        font-size: small;
    }
</style>

<body>


    <div id="signupPage">
        <h1>RentEase</h1>
        <br>

        <div class="top-buttons">
            <form action="index.php" method="get">
                <input type="submit" value="Sign In">
            </form>

            <form action="">
                <input type="submit" name="sgnup" class="sgnin" value="Sign Up">
            </form>
        </div>


        <form action="signupHandler.php" method="post">
            <label for="">Full Name</label>
            <br>
            <input type="text" name="fullname" id="fullname" placeholder="Enter your full name">
            <br><br>

            <label for="">Email</label>
            <br>
            <input type="text" name="email" id="email" placeholder="Enter your email">
            <br><br>

            <label for="">Password</label>
            <br>
            <input type="password" name="pass" id="pass" placeholder="Create a password">
            <br><br>

            <label for="">Phone Number</label>
            <br>
            <input type="text" name="phone" id="phone" placeholder="Enter your phone number">
            <br><br>

            <label for="">Address</label>
            <br>
            <textarea name="address" id="address" placeholder="Enter your address" rows="3"></textarea>
            <br><br>

            <?php
            if (isset($_SESSION['signuperrormsg']))
                echo "<span style='color:red; display:block;text-align:center' >" . $_SESSION['errormsg'] . "</span><br>" ?>

                <input type="submit" name="sbmt" id="sbmt" value="Create account">
                <br>
                <p class="signuplink">Already have an account? <a href="index.php"
                        style="color:#1749c7;text-decoration:none">Sign in</a></p>

            </form>
        </div>


    </body>

    </html>