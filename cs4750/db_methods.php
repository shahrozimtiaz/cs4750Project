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
       if (strpos($_POST['airlineIncidents'], '>') !== false) {
           $params[] = 'Incidents > :incidents';
       } else if (strpos($_POST['airlineIncidents'], '<') !==false) {
           $params[] = 'Incidents < :incidents';
       } else {
           $params[] = 'Incidents=:incidents';
       }
   }
   if (isset($_POST['airlineFatalAccidents']) && $_POST['airlineFatalAccidents']!='any') {
       if (strpos($_POST['airlineFatalAccidents'], '>') !== false) {
           $params[] = 'Fatal_Accidents > :fatalAccidents';
       } else if (strpos($_POST['airlineFatalAccidents'], '<') !==false) {
           $params[] = 'Fatal_Accidents < :fatalAccidents';
       } else {
           $params[] = 'Fatal_Accidents=:fatalAccidents';
       }
   }
   if (isset($_POST['airlineFatalities']) && $_POST['airlineFatalities']!='any') {
       if (strpos($_POST['airlineFatalities'], '>') !== false) {
           $params[] = 'Fatalities > :fatalities';
       } else if (strpos($_POST['airlineFatalities'], '<') !==false) {
           $params[] = 'Fatalities < :fatalities';
       } else {
           $params[] = 'Fatalities=:fatalities';
       }
   }
   if (!empty($params)) {
      $query .= ' where ' . implode(' AND ', $params);
   }
   $statement = $db->prepare($query);
   if (isset($_POST['airlineName']) && $_POST['airlineName']!='any') {
      $statement->bindValue(':name', $_POST['airlineName']);
   }
   if (isset($_POST['airlineIncidents']) && $_POST['airlineIncidents']!='any') {
       $statement->bindValue('incidents', trim($_POST['airlineIncidents'], '<> '));
   }
   if (isset($_POST['airlineFatalAccidents']) && $_POST['airlineFatalAccidents']!='any') {
      $statement->bindValue(':fatalAccidents', trim($_POST['airlineFatalAccidents'], "<> "));
   }
   if (isset($_POST['airlineFatalities']) && $_POST['airlineFatalities']!='any') {
      $statement->bindValue(':fatalities', trim($_POST['airlineFatalities'], '<> '));
   }

   $statement->execute();
   $results = $statement->fetchAll();
   $statement->closecursor();

   if ($query != "select * from airline") {
     // Find max Query_ID from query_history
     $user_id = $_SESSION['loggedin'];
     $query1 = "SELECT MAX(`Group_ID`) FROM `query_history`;";
     $statement = $db->prepare($query1);
     $statement->execute();
     $results1 = $statement->fetchAll();
     foreach ($results1 as $result) {
       $max = $result['MAX(`Group_ID`)'];
     }
     $max++;

     // Inserting into query_history table
     $query1 = "INSERT INTO `query_history` (`User_ID`, `Query_ID`, `Group_ID`)
     VALUES (:user, :query, :group)";
     $statement = $db->prepare($query1);
     $statement->bindValue(':user', $user_id);
     $statement->bindValue(':group', $max);
     $statement->bindValue(':query', NULL);
     $statement->execute();

     // Find max Query_ID from query_history_airline
     $query1 = "SELECT MAX(`Group_ID`) FROM `query_history_airline`;";
     $statement = $db->prepare($query1);
     $statement->execute();
     $results1 = $statement->fetchAll();
     foreach ($results1 as $result) {
       $max = $result['MAX(`Group_ID`)'];
     }
     $max++;

     // Inserting into query_history_airline
     foreach ($results as $result) {
       $name = $result['Name'];
       $query = "INSERT INTO `query_history_airline` (`User_ID`, `Query_ID`, `Group_ID`, `Name`)
       VALUES (:user, :query, :group, :name)";
       $statement = $db->prepare($query);
       $statement->bindValue(':user', $user_id);
       $statement->bindValue(':group', $max);
       $statement->bindValue(':name', $name);
       $statement->bindValue(':query', NULL);
       $statement->execute();
     }
   }
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
      if (strpos($_POST['airbnbRating'], '>') !== false) {
        $params[] = 'airbnblist.Rating > :rating';
      } else if (strpos($_POST['airbnbRating'], '<') !== false) {
        $params[] = 'airbnblist.Rating < :rating';
      } else {
        $params[] = 'airbnblist.Rating = :rating';
      }
      
   }
   if (isset($_POST['airbnbPrice']) && $_POST['airbnbPrice']!='any') {
    if(strpos($query,'JOIN airbnblist ON airbnbhost.Host_Id') == false){
      $query.= "JOIN airbnblist ON airbnbhost.Host_Id = airbnblist.Host_Id";
    }
    if (strpos($_POST['airbnbPrice'], '>') !== false) {
      $params[] = 'airbnblist.Price > : price';
    }else if (strpos($_POST['airbnbPrice'], '<') !== false) {
      $params[] = 'airbnblist.Price < :price';
    }else {
      $params[] = 'Price = :price';
    }
    
     
     
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
      $statement->bindValue(':price', trim($_POST['airbnbPrice'], '<> '));
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
      $statement->bindValue(':rating', trim($_POST['airbnbRating'], '<> '));
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

   if ($query != "select * from airbnbhost ") {
     // Find max Query_ID from query_history
     $user_id = $_SESSION['loggedin'];
     $query1 = "SELECT MAX(`Group_ID`) FROM `query_history`;";
     $statement = $db->prepare($query1);
     $statement->execute();
     $results1 = $statement->fetchAll();
     foreach ($results1 as $result) {
       $max = $result['MAX(`Group_ID`)'];
     }
     $max++;


     // Inserting into query_history table
     $query1 = "INSERT INTO `query_history` (`User_ID`, `Query_ID`, `Group_ID`)
     VALUES (:user, :query, :group)";
     $statement = $db->prepare($query1);
     $statement->bindValue(':user', $user_id);
     $statement->bindValue(':group', $max);
     $statement->bindValue(':query', NULL);
     $statement->execute();


     // Find max Query_ID from query_history_airbnb
     $query1 = "SELECT MAX(`Group_ID`) FROM `query_history_airbnb`;";
     $statement = $db->prepare($query1);
     $statement->execute();
     $results1 = $statement->fetchAll();
     foreach ($results1 as $result) {
       $max = $result['MAX(`Group_ID`)'];
     }
     $max++;

     // Inserting into query_history_airbnb and query_history_airbnb_amenities tables
     foreach ($results as $result) {
       $host_id = $result['Host_ID'];
       if(isset($result['Listing_ID'])) {
         $listing_id = $result['Listing_ID'];
         $query = "INSERT INTO `query_history_airbnb` (`User_ID`, `Query_ID`, `Group_ID`, `Host_ID`, `Listing_ID`)
         VALUES (:user, :query, :group, :host, :listing)";
         $statement = $db->prepare($query);
         $statement->bindValue(':user', $user_id);
         $statement->bindValue(':group', $max);
         $statement->bindValue(':host', $host_id);
         $statement->bindValue(':listing', $listing_id);
         $statement->bindValue(':query', NULL);
         $statement->execute();
         $statement->closecursor();

         if (isset($result['Amenity'])) {
           $amenity = substr($result['Amenity'], 0, 255);
           $query = "INSERT INTO `query_history_airbnb_amenities` (`User_ID`, `Query_ID`, `Group_ID`, `Listing_ID`, `Amenity`)
           VALUES (:user, :query, :group, :listing, :amenity)";
           $statement = $db->prepare($query);
           $statement->bindValue(':user', $user_id);
           $statement->bindValue(':group', $max);
           $statement->bindValue(':listing', $listing_id);
           $statement->bindValue(':amenity', $amenity);
           $statement->bindValue(':query', NULL);
           $statement->execute();
           $statement->closecursor();
         }
       }
       else {
         $query = "INSERT INTO `query_history_airbnb` (`User_ID`, `Query_ID`, `Group_ID`, `Host_ID`, `Listing_ID`)
         VALUES (:user, :query, :group, :host, :list)";
         $statement = $db->prepare($query);
         $statement->bindValue(':user', $user_id);
         $statement->bindValue(':group', $max);
         $statement->bindValue(':host', $host_id);
         $statement->bindValue(':query', NULL);
         $statement->bindValue(':list', NULL);
         $statement->execute();
         $statement->closecursor();
       }
     }
   }

   return $results;
}

function getCrime(){
    global $db;
    $query = "select * from arrest ";
    if (isset($_POST['arrestID']) && $_POST['arrestID'] != 'any') {
        $params[] = 'ArrestID=:arrestID';
    }
    if (isset($_POST['arrestDate']) && $_POST['arrestDate'] != '') {
        $params[] = 'Date=:arrestDate';
    }
    if (isset($_POST['arrestType']) && $_POST['arrestType'] != 'any') {
        $params[] = "Type LIKE CONCAT('%', :arrestType, '%')";
    }
    if (isset($_POST['arrestGender']) && $_POST['arrestGender'] != 'any') {
        $params[] = "Gender=:arrestGender";
    }
    if (isset($_POST['arrestAgeGroup']) && $_POST['arrestAgeGroup'] != 'any') {
        $params[] = "Age_Group=:arrestAgeGroup";
    }
    if (isset($_POST['arrestRace']) && $_POST['arrestRace'] != 'any') {
        $params[] = "Race=:arrestRace";
    }
    if (!empty($params)) {
        $query .= ' WHERE ' . implode(' AND ', $params);
    }
    $statement = $db->prepare($query);
    if (isset($_POST['arrestID']) && $_POST['arrestID'] != 'any') {
        $statement->bindValue('arrestID', $_POST['arrestID']);
    }
    if (isset($_POST['arrestDate']) && $_POST['arrestDate'] != '') {
        $statement->bindValue('arrestDate', $_POST['arrestDate']);
    }
    if (isset($_POST['arrestType']) && $_POST['arrestType'] != 'any') {
        $statement->bindValue('arrestType', $_POST['arrestType']);
    }
    if (isset($_POST['arrestGender']) && $_POST['arrestGender'] != 'any') {
        $statement->bindValue('arrestGender', $_POST['arrestGender']);
    }
    if (isset($_POST['arrestAgeGroup']) && $_POST['arrestAgeGroup'] != 'any') {
        $statement->bindValue('arrestAgeGroup', $_POST['arrestAgeGroup']);
    }
    if (isset($_POST['arrestRace']) && $_POST['arrestRace'] != 'any') {
        $statement->bindValue('arrestRace', $_POST['arrestRace']);
    }
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closecursor();

    if ($query != "select * from arrest ") {
      // Find max Query_ID from query_history
      $user_id = $_SESSION['loggedin'];
      $query1 = "SELECT MAX(`Group_ID`) FROM `query_history`;";
      $statement = $db->prepare($query1);
      $statement->execute();
      $results1 = $statement->fetchAll();
      foreach ($results1 as $result) {
        $max = $result['MAX(`Group_ID`)'];
      }
      $max++;

     // Inserting into query_history table
     $query1 = "INSERT INTO `query_history` (`User_ID`, `Query_ID`, `Group_ID`)
     VALUES (:user, :query, :group)";
     $statement = $db->prepare($query1);
     $statement->bindValue(':user', $user_id);
     $statement->bindValue(':group', $max);
     $statement->bindValue(':query', NULL);
     $statement->execute();


      // Find max Query_ID from query_history_crime
      $user_id = $_SESSION['loggedin'];
      $query1 = "SELECT MAX(`Group_ID`) FROM `query_history_crime`;";
      $statement = $db->prepare($query1);
      $statement->execute();
      $results1 = $statement->fetchAll();
      foreach ($results1 as $result) {
        $max = $result['MAX(`Group_ID`)'];
      }
      $max++;

      // Inserting into query_history_crime table
      foreach ($results as $result) {
        $arrest_id = $result['ArrestID'];
        $query = "INSERT INTO `query_history_crime` (`User_ID`, `Query_ID`, `Group_ID`, `ArrestID`)
        VALUES (:user, :query, :group, :arrest)";
        $statement = $db->prepare($query);
        $statement->bindValue(':user', $user_id);
        $statement->bindValue(':group', $max);
        $statement->bindValue(':arrest', $arrest_id);
        $statement->bindValue(':query', NULL);
        $statement->execute();
      }
    }

    return $results;
}

function getAirlineHistory() {
  global $db;
  $user_id = $_SESSION['loggedin'];
  $query = "SELECT * FROM `query_history_airline` WHERE `query_history_airline`.`User_ID` = :user ORDER BY Group_ID DESC;";
  $statement = $db->prepare($query);
  $statement->bindValue(':user', $user_id);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closecursor();
  return $results;
}

function getAirbnbHistory() {
  global $db;
  $user_id = $_SESSION['loggedin'];
  $query = "SELECT * FROM `query_history_airbnb` WHERE `query_history_airbnb`.`User_ID` = :user ORDER BY Group_ID DESC;";
  $statement = $db->prepare($query);
  $statement->bindValue(':user', $user_id);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closecursor();
  return $results;
}

function getCrimeHistory() {
  global $db;
  $user_id = $_SESSION['loggedin'];
  $query = "SELECT * FROM `query_history_crime` WHERE `query_history_crime`.`User_ID` = :user ORDER BY Group_ID DESC;";
  $statement = $db->prepare($query);
  $statement->bindValue(':user', $user_id);
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
