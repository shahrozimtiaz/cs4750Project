<?php
require('error.php')
?>

<?php
  if (!$_SESSION['loggedin']){
      $message= "Need to login to use the app";
      $_SESSION['message'] = $message;
      header("Location: index.php");
    }
?>