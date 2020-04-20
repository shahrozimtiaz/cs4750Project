<?php
require('error.php')
?>

<?php
    unset($_SESSION['loggedin']);
    header("Location: index.php");
?>