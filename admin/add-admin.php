<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <?php 
        if(isset($_SESSION['add'])) //checking whether session set or not
        {
            echo $_SESSION['add']; //display session message if set
            unset($_SESSION['add']); //remove session message
        } 
        ?>

        <form action="" method="POST">
            <table class="tbl-30"> 
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name" ></td>
            
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your username">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Your password">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
// process the value from form and save into databse
// check whether the button is clicked or not

if(isset($_POST['submit']))
{
    // button clicked
    // echo "Button Clicked";

    //1.Get data from form
     $full_name = $_POST['full_name'];
     $username = $_POST['username'];
     $password = md5($_POST['password']);
    //  password encrypted with md5

    //2.SQL query to save the data into database
     $sql="INSERT INTO tbl_admin SET
     full_name='$full_name',
     username='$username',
     pass='$password'
     ";

   //3.Execute query and save data in database
   
     $res = mysqli_query($conn, $sql) ;
    //  or die(mysqli_error());

   //4.check whether data is inserted or not and display appropriate message(execute query)
   if($res==TRUE)
   {
       // data inserted
       // echo "Data Inserted";
       // create  a variable to display message
       $_SESSION['add']="Admin added successfully";
       // redirect page to manage admin
       header("location:".SITEURL.'admin/manage-admin.php');

   }
   else
   {
       // failed to insert data
       // echo "Failed to insert data";
       // echo "Data Inserted";
       // create  a variable to display message
       $_SESSION['add']="failed to add admin";
       // redirect page to add admin
       header("location:".SITEURL.'admin/manage-admin.php');
   }



}

 ?>