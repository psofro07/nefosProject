<?php

include 'includes/dbh_handler.php';

//Check if the user came to this page by clicking the edit button in administration.php
if (isset($_POST['edit_btn'])) {

    $id = $_POST['edit_id'];
    include_once 'header.php';
}
else {
  header("location: administration.php?error=wrongrouting");
  exit();
}

?>

<div class="backadm">
  <div class="changeinfobody">

    <?php

      //Query to get the user's information and provide it in the placeholders of the following form.
      $query = "SELECT * FROM users WHERE ID='$id' ";
      $query_run = mysqli_query($conn, $query);

      //Create a form with the user's information. Foreach is not needed since id is primary key.
      foreach($query_run as $row) {

        ?>

        <form action="includes/adminupdateinc.php" method="POST">

          <input type="hidden" name="edit_id" value="<?php echo $row["ID"]; ?>">
          <div class="form-group">
            <label class="signuplabel">Name</label>
            <input type="text" name="edit_name" value="<?php echo $row["NAME"]; ?>" class="form-control" placeholder="Enter Name">
          </div>
          <div class="form-group">
            <label class="signuplabel">Surname</label>
            <input type="text" name="edit_surname" value="<?php echo $row["SURNAME"]; ?>" class="form-control" placeholder="Enter Surname">
          </div>
          <div class="form-group">
            <label class="signuplabel">Username</label>
            <input type="text" name="edit_username" value="<?php echo $row["USERNAME"]; ?>" class="form-control" placeholder="Enter Username">
          </div>
          <div class="form-group">
            <label class="signuplabel">Email</label>
            <input type="email" name="edit_email" value="<?php echo $row["EMAIL"]; ?>" class="form-control" placeholder="Enter Enail">
          </div>
          <div class="form-group">
            <label class="signuplabel">Role</label>
            <input type="text" name="edit_role" value="<?php echo $row["ROLE"]; ?>" class="form-control" placeholder="Enter Role">
          </div>
          <div class="form-group1">
            <label class="signuplabel conf">Confirmed</label>
            <select name="edit_confirmed" class="form-control">
              <option value="1">Yes</option>
              <option value="0">No </option>
            </select>
          </div>

          <button type="submit" name="updatebtn" class="btn-update">UPDATE</button>
          <a href="administration.php" class="btn-cancel">CANCEL</a>
        
        </form>

        <?php 

      }

    ?>

  </div>
</div>

<?php
  include_once 'footer.php';
?>