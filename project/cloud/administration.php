<?php

  include_once 'header.php';
  $temp = 'Admin';

  //Check if the user is logged in. If not redirect him to loggin page.
  if (!isset($_SESSION["id"])) {
    header("location: index.php?error=notloggedin");
    exit();
  }

  //Grant access to the user only if his role is admin. Else redirect him to the welcome page.
  if (strcmp($_SESSION["role"],$temp) !=0 ) {
    header("location: welcome.php?error=notAdmin");
    exit();
  }

  //Check if the user is confirmed by the admin. Else redirect him to the welcome page.
  if ($_SESSION["confirmed"] != 1) {
    header("location: welcome.php?error=notConfirmed");
    exit();
  }
  include'includes/dbh_handler.php';

?>

<!--BANNER-->
<div class="banner">
  <img class="banner-image" src="images/shindler.jpg" alt="banner">
</div>

<div class="adminbody">
  <h1 class="admh1">This is the administration table!</h1>
  <h2 class="admh2">Edit or Delete users by clicking the equivalent button.</h2>

  <?php

    ////Get statements to inform the user if his actions where succesfull or had errors.
    if (isset($_GET["error"])){

      if ($_GET["error"]  == "deletefailed") {
        echo '<p class="failed">An error occured. Delete failed!</p>';
      }
      else if ($_GET["error"]  == "updatefailed") {
        echo '<p class="failed">An error occured. Edit failed!</p>';
      }
      else if ($_GET["error"]  == "noned") {
        echo '<p class="success">The user has been deleted!</p>';
      }
      else if ($_GET["error"]  == "noneu") {
        echo '<p class="success">The user has been edited succesfully!</p>';
      }
      
    }

  ?>

  <br>

  <table class="admtable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Username</th>
        <th class="pwdtd">Password</th>
        <th>Email</th>
        <th>Role</th>
        <th>Confirmed</th>
        <th>EDIT</th>
        <th>DELETE</th>
      </tr>
    </thead>
    <tbody>

      <?php

        //Create the query for the admin table.
        $query = "SELECT * FROM users";
        $query_run = mysqli_query($conn, $query);

        //Check if there are any results for the query
        if (mysqli_num_rows($query_run) > 0) {

          //For every row of the resulted query create an html row with the user table data.
          while($row = mysqli_fetch_assoc($query_run) ){
          
            ?>

            <tr>
              <td><?php echo $row["ID"]; ?></td>
              <td><?php echo $row["NAME"]; ?></td>
              <td><?php echo $row["SURNAME"]; ?></td>
              <td><?php echo $row["USERNAME"]; ?></td>
              <td><?php echo $row["PASSWORD"]; ?></td>
              <td><?php echo $row["EMAIL"]; ?></td>
              <td><?php echo $row["ROLE"]; ?></td>
              <td><?php echo $row["CONFIRMED"]; ?></td>
              <td>
                <form action="changeinfo.php" method="post">
                  <input type="hidden" name="edit_id" value="<?php echo $row["ID"]; ?>">
                  <button  type="submit" name="edit_btn" class="btn-edit"><span>EDIT</span></button>
                </form>
              </td>
              <td>
                <form action="includes/admindeleteinc.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row["ID"]; ?>">
                  <button type="submit" name="delete_btn" class="btn-delete"><span>DELETE</span></button>
                </form>
              </td>
            </tr>

            <?php

          }
        }
        else {
          echo 'User table is empty';
        }

      ?>

    </tbody>

  </table>

</div>

<?php
  include_once 'footer.php';
?>