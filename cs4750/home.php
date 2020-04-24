<?php
require('loggedin_check.php');
require('connectdb.php');
require('db_methods.php');
?>

<?php
    $airline_query_set = getAirlines();
    $airbnb_query_set = getAirbnb();

    $crime_query_set = getCrime();
    $airline_history_set = getAirlineHistory();
    $airbnb_history_set = getAirbnbHistory();
    $crime_history_set = getCrimeHistory();

    $selected="Airline";
    if (isset($_POST['table'])){
        $selected=$_POST['table'];
    }
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
		  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Pacifico|Merriweather:wght@700" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
			integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
			crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
			integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
			crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
			integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/home.css">
</head>

<body>
<label style="color:#00cb82; font-family:Pacifico; font-size:20px;position:fixed;"><span>Web App</span></label>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        <i style="color:#00cb82; font-family:Pacifico; font-size:20px;"><span>Web App</span></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <i id="brand"><span style="color:#00cb82; font-family:Pacifico; font-size:20px;">Web App</span></i>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="home.php"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="reviews.php"><i class="fa fa-comments"></i> Reviews</a>
            </li>
             <li class="nav-item active">
                <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
<div class="sidenav shadow p-3 mb-5 bg-white rounded" style="font-family: 'Merriweather', serif;">
  <form action="home.php" method="post" id="query">
  <div class="form-group">
    <label>Table</label>
    <select class="form-control" id="table" name="table" value="Crime">
        <option <?php if ($selected=="Airline") echo "selected" ?> >Airline</option>
      <option <?php if ($selected=="Airbnb") echo "selected" ?> >Airbnb</option>
      <option <?php if ($selected=="Crime") echo "selected" ?> >Crime</option>
      <option <?php if ($selected=="Airline History") echo "selected" ?> >Airline History</option>
      <option <?php if ($selected=="Airbnb History") echo "selected" ?> >Airbnb History</option>
      <option <?php if ($selected=="Crime History") echo "selected" ?> >Crime History</option>
    </select>

    <div id='airbnb' style="display:none">
        <br>
        <label>Host ID</label>
        <input type="text" class="form-control" name="airbnbHostID" value="any" onfocus="this.value=''" required>
        <br>
        <label>Host Name</label>
        <input type="text" class="form-control" name="airbnbHostName" value="any" onfocus="this.value=''" required>
        <br>
        <label>Host Verification</label>
        <select class="form-control" name="airbnbHostVerification">
            <option>any</option>
            <option>T</option>
            <option>F</option>
        </select>
        <br>
        <label>Listing ID</label>
        <input type="text" class="form-control" name="airbnbListingName" value="any" onfocus="this.value=''" required>
        <br>
        <label>Location</label>
        <input type="text" class="form-control" name="airbnbLocation" value="any" onfocus="this.value=''" required>
        <br>
        <label>Listing Rating</label>
        <input type="text" class="form-control" name="airbnbRating" value="any" onfocus="this.value=''" required>
        <br>
        <label>Listing Bed-Type</label>
        <input type="text" class="form-control" name="airbnbBedType" value="any" onfocus="this.value=''" required>
        <br>
        <label>Listing Price</label>
        <input type="text" class="form-control" name="airbnbPrice" value="any" onfocus="this.value=''" required>
        <br>
        <label>Listing Room-Type</label>
        <input type="text" class="form-control" name="airbnbRoomType" value="any" onfocus="this.value=''" required>
        <br>
        <label>Listing Amenities</label>
        <input type="text" class="form-control" name="airbnbAmenities" value="any" onfocus="this.value=''" required>
    </div>

    <div id='airline' style="display:none">
        <br>
        <label>Airline Name</label>
        <input type="text" class="form-control" name="airlineName" value="any" onfocus="this.value=''" required>
        <br>
        <label>Incidents</label>
        <input type="text" class="form-control" name="airlineIncidents" value="any" onfocus="this.value=''" required>
        <br>
        <label>Fatal Accidents</label>
        <input type="text" class="form-control" name="airlineFatalAccidents" value="any" onfocus="this.value=''" required>
        <br>
        <label>Fatalities</label>
        <input type="text" class="form-control" name="airlineFatalities" value="any" onfocus="this.value=''" required>
    </div>

    <div id='crime' style="display:none">
        <br>
        <label>Arrest ID</label>
        <input type="text" class="form-control" name="arrestID" value="any" onfocus="this.value=''" required>
        <br>
        <label>Date</label>
        <input type="date" class="form-control" name="arrestDate">
        <br>
        <label>Type</label>
        <input type="text" class="form-control" name="arrestType" value="any" onfocus="this.value=''" required>
        <br>
        <label>Arrest Gender</label>
        <select class="form-control" name="arrestGender">
            <option>any</option>
            <option>M</option>
            <option>F</option>
        </select>
        <br>
        <label>Age Group</label>
        <input type="text" class="form-control" name="arrestAgeGroup" value="any" onfocus="this.value=''" required>
        <br>
        <label>Race</label>
        <input type="text" class="form-control" name="arrestRace" value="any" onfocus="this.value=''" required>
    </div>

  </div>
      <div class="form-group">
          <button type="submit" name="query" class="btn btn-success btn-block btn-lg" style="background: #00cb82;">Query</button>
          <br>
          <br>
	  </div>
  </form>
</div>

<div id="airlineResults" style="overflow:scroll;display:none">
    <table class="table table-striped table-bordered" id="table2">
        <tr>
            <th>Airline Name</th>
            <th>Incidents</th>
            <th>Fatal Accidents</th>
            <th>Fatalities</th>
        </tr>
        <?php foreach ($airline_query_set as $row): ?>
        <tr>
            <td>
            <?php echo $row['Name']; ?>
            </td>
            <td>
            <?php echo $row['Incidents']; ?>
            </td>
            <td>
            <?php echo $row['Fatal_Accidents']; ?>
            </td>
            <td>
            <?php echo $row['Fatalities']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-left" style="font-size:19px;margin-left: 300px;padding: 0px 10px;">
        <?php
        if (count($airline_query_set)){
            echo "Rows: " . count($airline_query_set);
        }else{
            echo "No results found";
        }
        ?>
    </div>
</div>

<div id="airbnbResults" style="overflow:scroll;display:none">
    <table class="table table-striped table-bordered">
        <tr>
            <?php if(isset($airbnb_query_set[0]['Listing_ID'])){ ?>
                <th>Listing Id </th>
            <?php } ?>
            <?php if(isset($airbnb_query_set[0]['Location'])){ ?>
                <th>Location</th>
            <?php } ?>
            <?php if(isset($airbnb_query_set[0]['Rating'])){ ?>
                <th>Rating (out of 100) </th>
            <?php } ?>
            <?php if(isset($airbnb_query_set[0]['Price'])){ ?>
                <th>Price</th>
            <?php } ?>
            <?php if(isset($airbnb_query_set[0]['Bed_type'])){ ?>
                <th>Bed Type</th>
            <?php } ?>
            <?php if(isset($airbnb_query_set[0]['Room_type'])){ ?>
                <th>Room Type</th>
            <?php } ?>
            <?php if(isset($airbnb_query_set[0]['Amenity'])){ ?>
                <th>Amenities</th>
            <?php } ?>
            <th>Host ID</th>
            <th>Host Name</th>
            <th>Verified</th>


        </tr>
        <?php foreach ($airbnb_query_set as $row): ?>
        <tr>
        <?php if(isset($row['Listing_ID'])){ ?>
            <td>
               <?php echo $row['Listing_ID']; ?>
            </td>
            <?php } ?>

            <?php if(isset($row['Location'])){?>
            <td>
                <?php echo $row['Location']; ?>
            </td>
            <?php } ?>
            <?php if(isset($row['Rating'])){?>
            <td>
                <?php echo $row['Rating']; ?>
            </td>
            <?php } ?>
            <?php if(isset($row['Price'])){?>
            <td>
                <?php echo $row['Price']; ?>
            </td>
            <?php } ?>
            <?php if(isset($row['Bed_type'])){?>
            <td>
                <?php echo $row['Bed_type']; ?>
            </td>
            <?php } ?>
            <?php if(isset($row['Room_type'])){?>
            <td>
                <?php echo $row['Room_type']; ?>
            </td>
            <?php } ?>
            <?php if(isset($row['Amenity'])){?>
            <td>
                <?php echo $row['Amenity']; ?>
            </td>
            <?php } ?>

            <td>
            <?php echo $row['Host_ID']; ?>
            </td>
            <td>
            <?php echo $row['First_name']; ?>
            </td>
            <td>
            <?php echo $row['Is_verified']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-left" style="font-size:19px;margin-left: 300px;padding: 0px 10px;">
        <?php
        if (count($airbnb_query_set)){
            echo "Rows: " . count($airbnb_query_set);
        }else{
            echo "No results found";
        }
        ?>
    </div>
</div>

<div id="crimeResults" style="overflow:scroll;display:none">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Arrest ID</th>
            <th>Date</th>
            <th>Type</th>
            <th>Arrest Gender</th>
            <th>Age Group</th>
            <th>Race</th>
        </tr>
        <?php foreach ($crime_query_set as $row): ?>
        <tr>
            <td>
            <?php echo $row['ArrestID']; ?>
            </td>
            <td>
            <?php echo $row['Date']; ?>
            </td>
            <td>
            <?php echo $row['Type']; ?>
            </td>
            <td>
            <?php echo $row['Gender']; ?>
            </td>
            <td>
            <?php echo $row['Age_group']; ?>
            </td>
            <td>
            <?php echo $row['Race']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-left" style="font-size:19px;margin-left: 300px;padding: 0px 10px;">
        <?php
        if (count($crime_query_set)){
            echo "Rows: " . count($crime_query_set);
        }else{
            echo "No results found";
        }
        ?>
    </div>
</div>

<div id="airlineHistoryResults" style="overflow:scroll;display:none">
    <table class="table table-striped table-bordered">
        <tr>
            <th>User Name</th>
            <th>Query ID</th>
            <th>Date</th>
            <th>Airline Name</th>
        </tr>
        <?php foreach ($airline_history_set as $row): ?>
        <tr>
            <td>
            <?php echo $row['User_ID']; ?>
            </td>
            <td>
            <?php echo $row['Query_ID']; ?>
            </td>
            <td>
            <?php echo $row['Date_Time']; ?>
            </td>
            <td>
            <?php echo $row['Name']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-left" style="font-size:19px;margin-left: 300px;padding: 0px 10px;">
        <?php
        if (count($airline_history_set)){
            echo "Rows: " . count($airline_history_set);
        }else{
            echo "No results found";
        }
        ?>
    </div>
</div>

<div id="airbnbHistoryResults" style="overflow:scroll;display:none">
    <table class="table table-striped table-bordered">
        <tr>
            <th>User Name</th>
            <th>Query ID</th>
            <th>Date</th>
            <th>Host ID</th>
            <th>Listing ID</th>
        </tr>
        <?php foreach ($airbnb_history_set as $row): ?>
        <tr>
            <td>
            <?php echo $row['User_ID']; ?>
            </td>
            <td>
            <?php echo $row['Query_ID']; ?>
            </td>
            <td>
            <?php echo $row['Date_Time']; ?>
            </td>
            <td>
            <?php echo $row['Host_ID']; ?>
            </td>
            <td>
            <?php echo $row['Listing_ID'] ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-left" style="font-size:19px;margin-left: 300px;padding: 0px 10px;">
        <?php
        if (count($airbnb_history_set)){
            echo "Rows: " . count($airbnb_history_set);
        }else{
            echo "No results found";
        }
        ?>
    </div>
</div>

<div id="crimeHistoryResults" style="overflow:scroll;display:none">
    <table class="table table-striped table-bordered">
        <tr>
            <th>User Name</th>
            <th>Query ID</th>
            <th>Date</th>
            <th>Arrest ID</th>
        </tr>
        <?php foreach ($crime_history_set as $row): ?>
        <tr>
            <td>
            <?php echo $row['User_ID']; ?>
            </td>
            <td>
            <?php echo $row['Query_ID']; ?>
            </td>
            <td>
            <?php echo $row['Date_Time']; ?>
            </td>
            <td>
            <?php echo $row['ArrestID']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="text-left" style="font-size:19px;margin-left: 300px;padding: 0px 10px;">
        <?php
        if (count($crime_history_set)){
            echo "Rows: " . count($crime_history_set);
        }else{
            echo "No results found";
        }
        ?>
    </div>
</div>

<script>
showResultsTable("<?php echo $selected ?>");
function showResultsTable(table) {
    if (table == "Crime"){
        $("div#airline").hide();
        $("div#airbnb").hide();
        $("div#airlineResults").hide();
        $("div#airbnbResults").hide();
        $("div#airlineHistoryResults").hide();
        $("div#crimeHistoryResults").hide();
        $("div#crime").show();
        $("div#crimeResults").show();
    }
    else if(table=="Airline"){
        $("div#crime").hide();
        $("div#airbnb").hide();
        $("div#crimeResults").hide();
        $("div#airbnbResults").hide();
        $("div#airlineHistoryResults").hide();
        $("div#airbnbHistoryResults").hide();
        $("div#crimeHistoryResults").hide();
        $("div#airline").show();
        $("div#airlineResults").show();
    }
    else if (table == "Airline History") {
      $("div#airline").hide();
      $("div#airbnb").hide();
      $("div#airlineResults").hide();
      $("div#airbnbResults").hide();
      $("div#crime").hide();
      $("div#crimeResults").hide();
      $("div#airbnbHistoryResults").hide();
      $("div#crimeHistoryResults").hide();
      $("div#airlineHistoryResults").show();
    }
    else if (table == "Airbnb History") {
      $("div#airline").hide();
      $("div#airbnb").hide();
      $("div#airlineResults").hide();
      $("div#airbnbResults").hide();
      $("div#crime").hide();
      $("div#crimeResults").hide();
      $("div#airlineHistoryResults").hide();
      $("div#crimeHistoryResults").hide();
      $("div#airbnbHistoryResults").show();
    }
    else if (table == "Crime History") {
      $("div#airline").hide();
      $("div#airbnb").hide();
      $("div#airlineResults").hide();
      $("div#airbnbResults").hide();
      $("div#crime").hide();
      $("div#crimeResults").hide();
      $("div#airlineHistoryResults").hide();
      $("div#airbnbHistoryResults").hide();
      $("div#crimeHistoryResults").show();
    }
    else{
        $("div#airline").hide();
        $("div#crime").hide();
        $("div#crimeResults").hide();
        $("div#airlineResults").hide();
        $("div#airlineHistoryResults").hide();
        $("#div#airbnbHistoryResults").hide();
        $("div#crimeHistoryResults").hide();
        $("div#airbnb").show();
        $("div#airbnbResults").show();
    }
    window.scrollTo({top:0, left:0});
}

$("#table").change(function(){
    showResultsTable($(this).val())
});
</script>

</body>
</html>