<?php
require('connectdb.php');
require('frienddb.php');
require('error.php');
?>


<?php
$msg = '';
$friend_to_update = '';

if (!empty($_POST['db-btn']))
{
   if ($_POST['db-btn'] == "Create")           {   create_table();  }
   else if ($_POST['db-btn'] == "Drop")        {   drop_table();    }  
   else if ($_POST['db-btn'] == "Insert")
   {
      if (!empty($_POST['name']) && !empty($_POST['major']) && !empty($_POST['year']))
         addFriend($_POST['name'], $_POST['major'], $_POST['year']);
      else 
         $msg = "Enter friend's information to insert";
   }
   else if($_POST['db-btn'] == "Confirm-update")  
   {
      if (!empty($_POST['name']) && !empty($_POST['major']) && !empty($_POST['year']))
         updateFriendInfo($_POST['name'], $_POST['major'], $_POST['year']);
      else
         $msg = "Enter friend's information to update";
   }
}

if (!empty($_POST['action']))
{
   if ($_POST['action'] == "Update")
      $friend_to_update = getFriendInfo_by_name($_POST['name']);
   else if ($_POST['action'] == "Delete")
   {
      if (!empty($_POST['name']) )
         deleteFriend($_POST['name']);
   }
}

$friends = getAllFriends();

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>Database interfacing</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
</head>

<body>
<div class="container">
<br/>
<h1>Shahroz's Friend book</h1>
<form action="simpleform.php" method="post">
  <div class="form-group">
    Name:
    <input type="text" class="form-control" name="name" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['name'] ?>" />        
  </div>  
  <div class="form-group">
    Major:
    <input type="text" class="form-control" name="major" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['major'] ?>"/>        
  </div>  
  <div class="form-group">
    Year:
    <input type="text" class="form-control" name="year" value="<?php if (!empty($friend_to_update)) echo $friend_to_update['year'] ?>" />        
  </div> 
  
  <div class="form-group">
    <input type="submit" value="Create table" class="btn btn-success" name="db-btn" title="Create 'friends' table"/>
    <input type="submit" value="Drop table" class="btn btn-danger" name="db-btn" title="Drop 'friends' table" />
    <input type="submit" value="Insert freind" class="btn btn-primary" name="db-btn" title="Insert into 'friends' table" />
    <input type="submit" value="Confirm-update" class="btn btn-warning" name="db-btn" title="Update 'friends' info" />
    <small class="text-danger"><?php echo $msg ?></small>
  </div>  
</form>

<h4>List of Shahroz's friends</h4>
    <table class="table table-striped table-bordered">
      <tr>
        <th>Friend Name</th>
        <th>Major</th>
        <th>Year</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>      
      <?php foreach ($friends as $friend): ?>
      <tr>
        <td>
          <?php echo $friend['name']; ?> 
        </td>
        <td>
          <?php echo $friend['major']; ?> 
        </td>        
        <td>
          <?php echo $friend['year']; ?> 
        </td>                
        <td>
          <form action="simpleform.php" method="post">
            <input type="submit" value="Update" name="action" class="btn btn-primary" />             
            <input type="hidden" name="name" value="<?php echo $friend['name'] ?>" />
          </form> 
        </td>                        
        <td>
          <form action="simpleform.php" method="post">
            <input type="submit" value="Delete" name="action" class="btn btn-danger" />      
            <input type="hidden" name="name" value="<?php echo $friend['name'] ?>" />
          </form>
        </td>                                
      </tr>
      <?php endforeach; ?>
    </table>
    
</div>    
</body>
</html>