<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Prototype </title>
</head>

<body>
    <?php include "partials/_navbar.php"; ?>
    <?php include "partials/_dbconnect.php"; ?>
    <div class="container">
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '
        <h2 class="text-center my-4">Projects</h2>
        <div class="row">';
        ?>
        <?php
            $sql = "SELECT * FROM `projects`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['sno'];
                echo '<div class="col-md-4 my-2">
            <div class="card" style="width: 18rem;">
            <img src="https://source.unsplash.com/500x400/?coding,' . $row['project'] . '" class="card-img-top" alt="...">
                <div class="card-body">
                <!--<h5 class="card-title"><a href="submenu.php?catid=' . $id . '">' . $row['project'] . '</a></h5>-->
                <h5 class="card-title">' . $row['project'] . '</h5>
                <p class="card-text">' . substr($row['project_desc'], 0, 110) . '...</p>
                <form action="submenu.php" method="POST">
                    <input type="hidden" name="catid" id="'.$id.'" value="' . $id . '">
                <input type="submit" class="btn btn-primary" value="Submit">
                </form>
                </div>
            </div>
        </div>';
            }
        } else {
            echo '<div class="jumbotron my-4">
            <h1 class="display-4">Welcome!</h1>
            <p class="lead">You need to login first to use the website!</p>
            <hr class="my-4">
            <p class="lead">
              <a class="btn btn-primary btn-lg"  type="button" data-toggle="modal" data-target="#loginModal" role="button">Login</a>
              <a class="btn btn-danger btn-lg"  type="button" data-toggle="modal" data-target="#signupModal" role="button">Signup</a>
            </p>
          </div>';
        }
        ?>
    </div>
    </div>
    <?php include "partials/_footer.php"; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>