<?php
require('connectdb.php');
require('db_methods.php');
require('error.php')
?>

<?php
  $username = $_POST['username'];
  $password = $_POST['password'];
  if (isset($_POST['login'])){
    $result = login($username,$password);
    if(!$result){
      $message= "Incorrect username/password";
      $_SESSION['message'] = $message;
      header("Location: index.php");
    }else{
      $_SESSION['loggedin'] = $username;
      header("Location: home.php");
    }
  }else{
    $result = signup($username,$password);
    if(!$result){
      $message= "username $username is already taken";
      $_SESSION['message'] = $message;
      header("Location: index.php");
    }else{
      $_SESSION['loggedin'] = $username;
      header("Location: home.php");
    }
  }
?>