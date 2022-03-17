<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>SoC Prototype</title>
</head>

<body>
    <?php include "partials/_navbar.php"; ?>
    <?php include "partials/_dbconnect.php"; ?>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (isset($_GET['catid'])) {
                $project = $_GET['catid'];
                echo $project;
            }
        }
        ?>
        <h2 class="text-center my-4">Projects</h2>
        <?php

        $sql = "SELECT * FROM `knowledge-base` WHERE `project`=$project";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['category_id'];
            echo '<div class="col-md-4 my-2">
    <div class="card" style="width: 18rem;">
    <img src="https://source.unsplash.com/500x400/?coding,' . $row['category_name'] . '" class="card-img-top" alt="...">
        <div class="card-body">
        <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '">' . $row['category_name'] . '</a></h5>
        <p class="card-text">' . substr($row['category_description'], 0, 110) . '...</p>
    <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
        </div>
    </div>
</div>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>