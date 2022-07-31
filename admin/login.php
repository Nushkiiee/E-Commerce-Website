<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login-Food order system</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br>

            <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
             ?>
             <br>

            <!-- login form starts here -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter username"> <br><br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter password"> <br><br>

                <input type="submit" name="submit" value="login" class="btn-primary">
                <br>
            </form>
             <!-- login form ends here -->
            
             <p class="text-center">Created By <a href="www.nushki.com">Anushka Rasure</a></p>
        </div>
    </body>
</html>

<?php 
// check whether submit button is clicked or not
if(isset($_POST['submit']))
{
    // process for login
    // 1.get the data from login form
        // $username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        // $password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        // 2.sql to check whether user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND pass='$password'";

        // 3. Execute the query
        $res = mysqli_query($conn,$sql);
        
        // 4.count to check whether user exists or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            // user available and login success
            $_SESSION['login'] = "<div class='success'>Login successful.</div>";
            $_SESSION['user']= $username; //to check whether the user is logged in or not and logout will unset it

            // Redirect to home page/dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            // user not available and login failed
            $_SESSION['login'] = "<div class='error text-center'>Username or password did not match.</div>";
            // Redirect to home page/dashboard
            header('location:'.SITEURL.'admin/login.php');
        }
    }


?>