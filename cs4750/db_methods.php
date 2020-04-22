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
   $query = "select * from airbnbhost ";
   if (isset($_POST['airbnbListingName']) && $_POST['airbnbListingName']!='any') {
      $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id";
      $params[] = 'Listing_ID=:listing_id';
   }
   if (isset($_POST['airbnbLocation']) && $_POST['airbnbLocation']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == false){
         $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id";
      }
      $params[] = "Location LIKE CONCAT( '%', :location, '%' )";
   }
   if (isset($_POST['airbnbAmenities']) && $_POST['airbnbAmenities']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == false){
         $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id JOIN airbnblisting_amenities ON airbnblist.Listing_ID = airbnblisting_amenities.Listing_ID ";
         $params[] = "Amenity LIKE CONCAT( '%', :amenity, '%' )";
      }else{
         $query.=" JOIN airbnblisting_amenities ON airbnblist.Listing_ID = airbnblisting_amenities.Listing_ID ";
         $params[] = "Amenity LIKE CONCAT( '%', :amenity, '%' )";
      }
   }
   if (isset($_POST['airbnbRating']) && $_POST['airbnbRating']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == false){
         $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id";
      }
      $params[] = 'Rating >= :rating';
   }
   if (isset($_POST['airbnbPrice']) && $_POST['airbnbPrice']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == false){
         $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id";
      }
      $params[] = 'Price <= :price';
   }
   if (isset($_POST['airbnbBedType']) && $_POST['airbnbBedType']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == false){
         $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id";
      }
      $params[] = "Bed_type LIKE CONCAT( '%', :bedtype, '%' )";
   }
   if (isset($_POST['airbnbRoomType']) && $_POST['airbnbRoomType']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == false){
         $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id";
      }
      $params[] = "Room_type LIKE CONCAT( '%', :roomtype, '%' )";
   }
   if (isset($_POST['airbnbHostID']) && $_POST['airbnbHostID']!='any') {
     if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == true){
         $params[] = 'airbnbhost.Host_ID=:hostid';
      }else{
         $params[] = 'Host_ID=:hostid';
      }
   }
   if (isset($_POST['airbnbHostName']) && $_POST['airbnbHostName']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == true){
          $params[] = "airbnbhost.First_name LIKE CONCAT( '%', :hostname, '%' ) ";
       }else{
          $params[] = "First_name LIKE CONCAT( '%', :hostname, '%' )";
       }
    }
   if (isset($_POST['airbnbHostVerification']) && $_POST['airbnbHostVerification']!='any') {
      if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == true){
          $params[] = 'airbnbhost.Is_verified=:verified';
       }else{
          $params[] = 'Is_verified=:verified';
       }
    }
   if (!empty($params)) {
      $query .= ' where ' . implode(' AND ', $params);
   }
   $statement = $db->prepare($query);
   if (isset($_POST['airbnbListingName']) && $_POST['airbnbListingName']!='any') {
      $statement->bindValue(':listing_id', $_POST['airbnbListingName']);
   }
   if (isset($_POST['airbnbLocation']) && $_POST['airbnbLocation']!='any') {
      $statement->bindValue(':location', $_POST['airbnbLocation']);
   }
   if (isset($_POST['airbnbPrice']) && $_POST['airbnbPrice']!='any') {
      $statement->bindValue(':price', $_POST['airbnbPrice']);
   }
   if (isset($_POST['airbnbBedType']) && $_POST['airbnbBedType']!='any') {
      $statement->bindValue(':bedtype', $_POST['airbnbBedType']);
   }
   if (isset($_POST['airbnbRoomType']) && $_POST['airbnbRoomType']!='any') {
      $statement->bindValue(':roomtype', $_POST['airbnbRoomType']);
   }
   if (isset($_POST['airbnbHostID']) && $_POST['airbnbHostID']!='any') {
      $statement->bindValue(':hostid', $_POST['airbnbHostID']);
   }
   if (isset($_POST['airbnbHostName']) && $_POST['airbnbHostName']!='any') {
      $statement->bindValue(':hostname', $_POST['airbnbHostName']);
   }
   if (isset($_POST['airbnbRating']) && $_POST['airbnbRating']!='any') {
      $statement->bindValue(':rating', $_POST['airbnbRating']);
   }
   if (isset($_POST['airbnbAmenities']) && $_POST['airbnbAmenities']!='any') {
      $statement->bindValue(':amenity', $_POST['airbnbAmenities']);
   }
   if (isset($_POST['airbnbHostVerification']) && $_POST['airbnbHostVerification']!='any') {
      if($_POST['airbnbHostVerification']=='T'){
         $statement->bindValue(':verified','1');
      }elseif($_POST['airbnbHostVerification']=='F'){
         $statement->bindValue(':verified','0');
      }else{
         $statement->bindValue(':verified', $_POST['airbnbHostVerification']);
      }
   }
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