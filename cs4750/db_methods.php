<!-- functions for querying db -->
<?php 
function login($username,$password){
   global $db;
   $query = "select Password from user where User_Name=:username";
   $statement = $db->prepare($query);
   $statement->bindValue(':username', $username);
   $statement->execute();
   $results = $statement->fetch();
   $statement->closecursor();
   if(!$results){
      return FALSE;
   }
   return password_verify($password,$results['Password']);
}

function signup($username,$password){
   global $db;
   $query = "insert into user(User_Name, Password) values (:username,:password)";
   $statement = $db->prepare($query);
   $statement->bindValue(':username', $username);
   $statement->bindValue(':password', password_hash($password,PASSWORD_DEFAULT));
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

function getReviews(){
   global $db;
   $query = "select * from review order by Date desc";
   $statement = $db->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll();
   $statement->closecursor();
   return $results;
}

function createReview($username,$title,$text,$rating){
   global $db;
   $query = "insert into review(User_Name,Rating,Title,Text) values (:username,:rating,:title,:text)";
   $statement = $db->prepare($query);
   $statement->bindValue(':username', $username);
   $statement->bindValue(':title', $title);
   $statement->bindValue(':text', $text);
   $statement->bindValue(':rating', $rating);
   if ($statement->execute()){
      $results = TRUE;
   }else{
      $results = FALSE;
   }
   $statement->closecursor();
   return $results;
}

function getReview($id){
   global $db;
   $query = "select * from review where Review_ID=:id";
   $statement = $db->prepare($query);
   $statement->bindValue(':id', $id);
   if ($statement->execute()){
      $results = $statement->fetch();
   }else{
      $results = FALSE;
   }
   $statement->closecursor();
   return $results;
}

function updateReview($id,$username,$title,$text,$rating){
   global $db;
   echo $id;
   $query = "update review set User_Name=:username, Rating=:rating, Title=:title, Text=:text where Review_ID=:id";
   $statement = $db->prepare($query);
   $statement->bindValue(':id', $id);
   $statement->bindValue(':username', $username);
   $statement->bindValue(':title', $title);
   $statement->bindValue(':text', $text);
   $statement->bindValue(':rating', $rating);
   if ($statement->execute()){
      $results = TRUE;
   }else{
      $results = FALSE;
   }
   $statement->closecursor();
   return $results;
}

function deleteReview($id){
   global $db;
   $query = "delete from review where Review_ID=:id";
   $statement = $db->prepare($query);
   $statement->bindValue(':id', $id);
   if ($statement->execute()){
      $results = TRUE;
   }else{
      $results = FALSE;
   }
   $statement->closecursor();
   return $results;
}
?>