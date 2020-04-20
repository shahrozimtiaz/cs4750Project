<!-- functions for querying db -->
<?php 
function login($username,$password){
   global $db;
   $query = "select * from user where User_Name=:username and Password=:password";
   $statement = $db->prepare($query);
   $statement->bindValue(':username', $username);
   $statement->bindValue(':password', $password);
   $statement->execute();
   $results = $statement->fetch();
   $statement->closecursor();
   return $results;
}

function signup($username,$password){
   global $db;
   $query = "insert into user(User_Name, Password) values (:username,:password)";
   $statement = $db->prepare($query);
   $statement->bindValue(':username', $username);
   $statement->bindValue(':password', $password);
   if ($statement->execute()){
      $results = TRUE;
   }else{
      $results = FALSE;
   }
   $statement->closecursor();
   return $results;
}

function getAirlines(){
   global $db;
   $query = "select * from airline";
   if (isset($_POST['airlineName']) && $_POST['airlineName']!='any') {
      $params[] = 'Name=:name';
   }
   if (isset($_POST['airlineIncidents']) && $_POST['airlineIncidents']!='any') {
      $params[] = 'Incidents=:incidents';
   }
   if (isset($_POST['airlineFatalAccidents']) && $_POST['airlineFatalAccidents']!='any') {
      $params[] = 'Fatal_Accidents=:fatalAccidents';
   }
   if (isset($_POST['airlineFatalities']) && $_POST['airlineFatalities']!='any') {
      $params[] = 'Fatalities=:fatalities';
   }
   if (!empty($params)) {
      $query .= ' where ' . implode(' AND ', $params);
   }
   $statement = $db->prepare($query);
   if (isset($_POST['airlineName']) && $_POST['airlineName']!='any') {
      $statement->bindValue(':name', $_POST['airlineName']);
   }
   if (isset($_POST['airlineIncidents']) && $_POST['airlineIncidents']!='any') {
      $statement->bindValue(':incidents', $_POST['airlineIncidents']);
   }  
   if (isset($_POST['airlineFatalAccidents']) && $_POST['airlineFatalAccidents']!='any') {
      $statement->bindValue(':fatalAccidents', $_POST['airlineFatalAccidents']);
   } 
   if (isset($_POST['airlineFatalities']) && $_POST['airlineFatalities']!='any') {
      $statement->bindValue(':fatalities', $_POST['airlineFatalities']);
   } 
   $statement->execute();
   $results = $statement->fetchAll();
   $statement->closecursor();
   return $results;
}

function getAirbnb(){
   global $db;
   $query = "select * from airbnbhost";
   $statement = $db->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll();
   $statement->closecursor();
   return $results;
}

function getCrime(){
   global $db;
   $query = "select * from arrest";
   $statement = $db->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll();
   $statement->closecursor();
   return $results;
}
?>