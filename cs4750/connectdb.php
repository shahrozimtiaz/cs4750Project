<!-- connecting to cs4750 db project -->
<?php

$username = 'root';
$host = 'localhost:3306';
$dbname = 'project';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = "";


try 
{
   $db = new PDO($dsn, $username);   
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