<!-- connecting to cs4750 db project -->
<?php

$username = 'project_user';
$password = 'cs4750';
$host = 'localhost:3306';
$dbname = 'project';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = "";


try 
{
   $db = new PDO($dsn, $username,$password);   
}
catch (PDOException $e)
{
   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>