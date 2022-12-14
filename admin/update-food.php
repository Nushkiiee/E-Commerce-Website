<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br>

<?php 
   // check whether id is set or not
   if(isset($_GET['id']))
   {
    // get all the details
    $id = $_GET['id'];

    // sql query to get the selected food
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    // execute the query
    $res2 = mysqli_query($conn, $sql2);

    $count = mysqli_num_rows($res2);
     if($count==1)
     {

        // get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        // get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
   }
   else
   {
    // redirect to  manage food
    $_SESSION['no-food-found']="<div class='error'>Food not found.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
   }
}
else
    {
        // redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }
  
?>


        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>
            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description"  cols="30" rows="10"><?php echo $description; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>
            <tr>
                <td>Current Image: </td>
                <td>
                   <!-- Display the image if available -->
                   <?php 
                   if($current_image =="")
                   {
                    // image not available
                    echo "<div class='error'>Image not available.</div>";
                   } 
                   else
                   {
                    // image available
                    ?>
                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width = "100px">
                    <?php
                   }
                   ?>
                </td>
            </tr>
            <tr>
                <td>Select New Image</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                    <?php  
                        // Query to get active categories
                         $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        //  execute the query
                        $res = mysqli_query($conn, $sql);
                        // count rows
                        $count = mysqli_num_rows($res);

                        // check whether category available or not
                        if($count>0)
                        {
                            // category available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $category_title = $row['title'];
                                $category_id = $row['id'];
                                
                                // echo "<option value='$category_id'>$category_title</option>";
                                ?>
                                <option <?php if($current_category == $category_id){echo "selected";} ?> value="<?php echo $category_title; ?>"><?php echo $category_title?></option>
                                <?php
                            }
                        }
                        else
                        {
                            // category not available  
                            ?> 
                           <option value='0'> Category not available.</option>;
                           <?php
                        }


                    ?>                                                   
                        <!-- <option value="0">Test Category</option> -->
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>
            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No") {echo "checked";} ?>type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
        </table>
       
        </form>
        <?php 
            //  check 
            if(isset($_POST['submit']))
            {
                // echo "button clicked";

                // 1.Get all the details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2.Upload the image if selected
                // check whetherupload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    // upload button clicked
                    $image_name = $_FILES['image']['name'];  //new image name

                    // check whether file is available or not
                    if($image_name!="")
                    {
                        // image is available
                        // a.uploading new image
                        // rename the image
                        $ext = end(explode('.', $image_name)); //gets the extension of the image

                        $image_name = "Food_Name_".rand(0000,9999).'.'.$ext; //this will be renamed image

                        // get the source path and destination path
                        $source_path = $_FILES['image']['tmp_name']; //source path
                        $destination_path = "../images/category/".$image_name;

                        // upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // check whether the image is uploaded or not
                        if($upload == false)
                        {
                            // failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                            // redirect to manage food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }

                        // 3.Remove the image if new image is uploaded and current image exists
                        // b. remove current image if available
                        if($current_image!="")
                        {
                            // current image is available
                            // remove the image
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);

                            // check whether the image is removed or not
                            if($remove==false)
                            {
                                // failed to remove current image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";

                                // redirect to manage food
                                header('location:'.SITEURL.'admin/manage-food.php');
                                // stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image; //default image when image is not selected[bug]
                    }
                }
                else
                {
                    $image_name = $current_image; //default image when button is not clicked
                }

                

                // 4.update the food in database
                $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category_id',
                featured =  '$featured',
                active = '$active'
                WHERE id=$id
                ";
                // execute the sql query
                $res3 = mysqli_query($conn , $sql3);

                // ?check whether the query is executed or not
                if($res3==true)
                {
                    // query executed and food updated
                    $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    // failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                // redirect to manage food with session message
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>