<?php

  require_once 'includes/dbh_handler.php';
  require_once 'includes/functions.php';

  //Check if the user came to this site by using the update button.
  if(isset($_POST['update-btn'])) {

    $id = $_POST['movieid'];

    //Find the movie by id to update it's information and display it's data in the following form's placeholders.
    $query = "SELECT * FROM movies WHERE ID='$id' ";
    $query_run = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($query_run);
    include 'header.php';

    ?>
  <!--Create a form to edit the new data of the movie-->
  <div class="backown">
    <div class="changeinfobody2">

    <form action="includes/ownerupdateinc.php" method="POST">
      <input type="hidden" name="edit_id" value="<?php echo $row["ID"]; ?>">

      <div class="form-group">
        <label class="mov-lab">Title</label>
        <input type="text" name="edit_title" value="<?php echo $row["TITLE"]; ?>" class="modal-inputs" placeholder="Enter Title">
      </div>

      <div class="form-group">
        <label class="mov-lab">Premiere Date</label>
        <br>
        <input type="date" name="edit_startdate" value="<?php echo $row["STARTDATE"]; ?>" class="modal-inputsdate" placeholder="Enter Start date">
      </div>

      <div class="form-group">
        <label class="mov-lab">End date</label>
        <input type="date" name="edit_enddate" value="<?php echo $row["ENDDATE"]; ?>" class="modal-inputsdate" placeholder="Enter End date">
      </div>

      <div class="form-group">
        <label class="mov-lab">Cinema Name</label>
        <input type="text" name="edit_cinemaname" value="<?php echo $row["CINEMANAME"]; ?>" class="modal-inputs" placeholder="Enter Cinema name">
      </div>

      <div class="form-group">
        <label class="mov-lab">Category</label>
        <input type="text" name="edit_category" value="<?php echo $row["CATEGORY"]; ?>" class="modal-inputs" placeholder="Enter Category">
      </div>

      <button type="submit" name="updatebtn" class="btn-update">UPDATE</button>
      <a href="owner.php" class="btn-cancel">CANCEL</a>
      
      </form>

    </div>

  </div>

    <?php
    
}
else {
  header("location: owner.php?error=wrongrouting");
  exit();
}

?>

<?php
  include_once 'footer.php';
?>