<?php 

    include('../config/constants.php');
   
     if(isset($_GET['id']) AND isset($_GET['image_name']))

     {
        // process to delete
        // echo "Process to delete";
        // 1.get Id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2.Remove the image if available
        // check whether the image is available or not and delete only ig available
        if($image_name != "")
        {
            // It has image and need to remove from folder
            // Get the image path
            $path = "../images/category/".$image_name;

            // Remove image file from folder
            $remove = unlink($path);

            // check whether image is removed or not
            if($remove == false)
            {
                // failed to remove image
                $_SESSION['remove'] = "<div class='error'>Failed to remove food image.</div>";
                // redirect to manage food
                header('location:'.SITEURL.'admin/manage-food.php');
                // stop the process of deleting food
                die();
            }
        }
        // 3.Delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        // Execute the query
        $res = mysqli_query($conn, $sql);

        // check whether the query executed or not and set the session message respectively
        if($res==true)
        {
            // food deleted
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // Failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        // 4.Redirect to manage food with session message
     }
     else
     {
        // redirect to manage food page
        // echo "Redirect";
        $_SESSION['delete'] = "<div class='error'>Failed to delete food. Try again later.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
     }

?>