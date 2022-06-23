<?php
include'dbh.php';

if(!$conn) {
  header("Location: ../welcome.php?error=failedDBconn");
}
