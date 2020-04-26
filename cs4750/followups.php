<?php
require('loggedin_check.php');
require('connectdb.php');
require('db_methods.php');
?>

<?php
if (!isset($_GET['reviewID'])) {
    header("Location: reviews.php");
    exit;
}
$review= getReview($_GET['reviewID']);
if(!$review){
    header("Location: reviews.php");
    exit;
}
$follow_ups_set = getFollowups($_GET['reviewID']);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Pacifico|Merriweather:wght@700" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/home.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
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
    <br>
    <div class="container shadow p-3 mb-5 bg-white rounded" style="font-family: 'Merriweather', serif;">
        <div class="text-right">
            <a class="btn btn-success btn-lg" href="leave_followup.php?reviewID=<?php echo $review['Review_ID'] ?>" style="background: #00cb82;"><i class="fa fa-pencil"></i> Leave a follow-up</a>
        </div>
        <br>
        <div class="card shadow p-3 mb-5 bg-white rounded text-center mx-auto" style="width: 54rem">
                <h5 class="card-header">
                    Rating: <?php echo $review['Rating']; ?>
                    <?php if ($review['User_Name']==$_SESSION['loggedin']) : ?>
                        <span class="text-right">
                            <a class="close" href="edit_review.php?reviewID=<?php echo $review['Review_ID'] ?>"><i class="fa fa-pencil"></i></a>
                        </span>
                    <?php endif; ?>
                </h5>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php echo strtoupper($review['Title']); ?>
                    </h5>
                    <p class="card-text">
                        <?php echo $review['Text']; ?>
                    </p>
                </div>
                <div class="card-footer text-muted">
                    <?php echo $review['User_Name']; ?>
                    <?php echo substr($review['Date'], 0, 10); ?>
                </div>
            </div>
        <br>
        <?php foreach ($follow_ups_set as $row) : ?>
            <div class="card shadow p-3 mb-5 bg-white rounded text-center mx-auto" style="width: 34rem">
                <h5 class="card-header">
                    Follow-up
                </h5>
                <div class="card-body">
                    <p class="card-text">
                        <?php echo $row['Text']; ?>
                    </p>
                    <a href="#" class="btn btn-success" style="background: #00cb82;">Follow up</a>
                </div>
                <div class="card-footer text-muted">
                    <?php echo $row['User_Name']; ?>
                    <?php echo substr($row['Date'], 0, 10); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>