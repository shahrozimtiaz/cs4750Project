<?php
require('loggedin_check.php');
require('connectdb.php');
require('db_methods.php');
?>

<?php
$id = Null;
if (!isset($_GET['reviewID'])) {
    header("Location: reviews.php");
    exit;
} else {
    $id = $_GET['reviewID'];
    $review = getReview($_GET['reviewID']);
    if (!$review || $review['User_Name'] != $_SESSION['loggedin']) {
        header("Location: reviews.php");
        exit;
    }
}
if (isset($_GET['deleteReview'])) {
    if (deleteReview($id)) {
        header("Location: reviews.php");
        exit;
    } else {
        $_SESSION['message'] = 'Invalid form';
    }
}
if (isset($_POST['reviewTitle'])) {
    if (updateReview($id, $_SESSION['loggedin'], $_POST['reviewTitle'], $_POST['reviewText'], $_POST['reviewRating'])) {
        header("Location: reviews.php");
        exit;
    } else {
        $_SESSION['message'] = 'Invalid form';
    }
}
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
    <br>
    <br>
    <div class="container shadow p-3 mb-5 bg-white rounded" style="font-family: 'Merriweather', serif;width:34rem">
            <div class="text-center">
                <label style="color:#00cb82; font-family:Pacifico; font-size:20px;">Leave a Review!</label>
                <span class="text-right">
                        <a class="close" href="edit_review.php?reviewID=<?php echo $review['Review_ID'] ?>&deleteReview=TRUE"><i class="fa fa-trash-o"></i></a>
                </span>
            </div>
            <form action="edit_review.php?reviewID=<?php echo $id ?>" method="post" id="query">
            <label>Title</label>
            <input type="text" class="form-control" name="reviewTitle" placeholder="title" value="<?php echo $review['Title'] ?>" required>
            <br>
            <label>Description</label>
            <textarea type="text" class="form-control" name="reviewText" placeholder="any comments you may have" rows="4" required><?php echo $review['Text'] ?></textarea>
            <br>
            <label>Rating</label>
            <select class="form-control" name="reviewRating">
                <option <?php if ($review['Rating'] == 10) echo "selected" ?>>10</option>
                <option <?php if ($review['Rating'] == 9) echo "selected" ?>>9</option>
                <option <?php if ($review['Rating'] == 8) echo "selected" ?>>8</option>
                <option <?php if ($review['Rating'] == 7) echo "selected" ?>>7</option>
                <option <?php if ($review['Rating'] == 6) echo "selected" ?>>6</option>
                <option <?php if ($review['Rating'] == 5) echo "selected" ?>>5</option>
                <option <?php if ($review['Rating'] == 4) echo "selected" ?>>4</option>
                <option <?php if ($review['Rating'] == 3) echo "selected" ?>>3</option>
                <option <?php if ($review['Rating'] == 2) echo "selected" ?>>2</option>
                <option <?php if ($review['Rating'] == 1) echo "selected" ?>>1</option>
            </select>
            <br>
            <div class="text-center">
                <button type="submit" class="btn btn-success btn" style="background: #00cb82;">Update</button>
            </div>
            <br>
        </form>
    </div>
</body>

</html>