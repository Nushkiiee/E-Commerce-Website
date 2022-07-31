<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
    <h1>Manage Food</h1>

    <br>

          <?php 
          
          if(isset($_SESSION['add']))
          {
              echo $_SESSION['add'];
               unset($_SESSION['add']);
          }
          if(isset($_SESSION['remove']))
          {
              echo $_SESSION['remove'];
               unset($_SESSION['remove']);
          }
          if(isset($_SESSION['delete']))
          {
               echo $_SESSION['delete'];
               unset($_SESSION['delete']);
          }
          if(isset($_SESSION['upload']))
          {
               echo $_SESSION['upload'];
               unset($_SESSION['upload']);
          }
          if(isset($_SESSION['no-food-found']))
          {
               echo $_SESSION['no-food-found'];
               unset($_SESSION['no-food-found']);
          }
          if(isset($_SESSION['update']))
          {
               echo $_SESSION['update'];
               unset($_SESSION['update']);
          }
          if(isset($_SESSION['failed-remove']))
          {
              echo $_SESSION['failed-remove'];
              unset($_SESSION['failed-remove']);
          }
          ?>

          <br>

          <!-- button to add food -->
             
             <a href="<?php echo SITEURL; ?>admin/add-food.php" class = "btn-primary">Add food</a>
             

          <br>

          <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            <?php 
            // create sql query to get all the food
            $sql = "SELECT * FROM tbl_food";

            // execute the query
            $res = mysqli_query($conn, $sql);

            if($res==TRUE)
            {

            // count rows to check whether we have food or not
            $count = mysqli_num_rows($res);
            
            // create serial number variable and set default value as 1
            $sn=1;


            if($count>0)
            {
                // we have food in database
                // get the foods from databse and display
                while($row = mysqli_fetch_assoc($res))
                {
                    // get the value from individual columns
                    $id = $row['id'];
                    $title =  $row['title'];
                    $price =  $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>
                        <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                        <?php 
                            // check whether image name is available or not
                            if($image_name!="")
                            {
                                // display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width ="100px">

                                <?php
                                
                            }
                            else
                            {
                                // display the message
                                echo "<div class='error'>Image not added.</div>";
                            }
                         ?>
                            
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update food</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?> &image_name = <?php echo $image_name; ?>" class="btn-danger">Delete food</a>
                    
                </td>
            </tr>

                    <?php
                }
            }
            else
            {
                // food not added in database
                ?>
                
                <tr>
                 <td colspan='7'><div class="error">Food not added yet.</div></td> 
                </tr>
                <?php
            }
        }
            ?>
          
                
               
            

        </table>
    </div>
   
</div>

<?php include('partials/footer.php') ?>