<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>SoC Prototype</title>
</head>

<body>
    <?php include "partials/_navbar.php"; ?>
    <?php include "partials/_dbconnect.php"; ?>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['catid'])) {
                $project = $_POST['catid'];
            }
        }
        ?>
        <h2 class="text-center my-4">Projects</h2>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Knowledge Base</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="knowledge-base/knowledge-base.php?project=<?php echo $project; ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Custom Event Proeprties</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="custom-event-property/event-properties.php?project=<?php echo $project; ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>