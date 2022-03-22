<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /prototype");
    exit;
}
?>
<!doctype html>
<html lang="en">
<?php require "partials/_dbconnect.php";
$updatePermission = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $snoEdit = $conn->real_escape_string($_POST['snoEdit']);
    $currentPermission = $conn->real_escape_string($_POST['currentPermission']);
    $sql = "UPDATE `users` SET `rights` = ? WHERE `users`.`sno` = $snoEdit;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Failed!";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $currentPermission);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $sql = "UPDATE `users` SET `add_status` = ? WHERE `users`.`sno` = $snoEdit;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "Failed!";
            } else {
                $val = 1;
                mysqli_stmt_bind_param($stmt, "s", $val);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($result) {
                    $updatePermission = true;
                }
            }
            $updatePermission = true;
        }
    }
}
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <title>knowledge-base!</title>
</head>

<body>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Change the permissions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="user_approve.php" method="POST">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="exampleInputEmail1">PS Number</label>
                            <input type="text" class="form-control" id="psnoEdit" name="psnoEdit" disabled aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Email Address</label>
                            <input type="text" class="form-control" disabled id="useremailEdit" name="useremailEdit">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description of the knowledge-base</label>
                            <input type="text" class="form-control" id="timestampEdit" name="timestampEdit" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description of the knowledge-base</label>
                            <select class="custom-select mr-sm-2" id="currentPermission" name="currentPermission">
                                <option value="0" selected>User</option>
                                <option value="1">Admin</option>
                                <option value="2">Super Admin</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_navbar.php"; ?>
    <?php
    if ($updatePermission) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Updated successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <h2 class="text-center my-4">User Management</h2>
    <div class="container">
        <table class="table" id="myTable">
            <caption>User Management</caption>
            <thead>
                <tr>
                    <th scope="col">S.No.</th>
                    <th scope="col">PS No</th>
                    <th scope="col">User Email</th>
                    <th scope="col">Account Creation</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `users` WHERE `add_status` = 0";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                $right = NULL;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo '<tr>
      <th scope="row">' . $sno . '  </th>
      <td>' . $row['psno'] . '</td>
      <td>' . $row['user_email'] . '</td>
      <td>' . $row['timestamp'] . '</td>
     
      <td><button class="btn btn-success btn-sm my-2 my-sm-0 edit" type="submit" id="' . $row['sno'] . '">Update</button>
      </td>
    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="/prototype/partials/datatables.js"></script>
    <script src="partials/resize.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "sDom": "Rlfrtip"
            });
        });
        // $(document).ready(function() {
        //     $('#myTable').DataTable({
        //         // "scrollY": 200,
        //         "scrollX": true
        //     });
        // });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("Edit");
                tr = e.target.parentNode.parentNode;
                psno = tr.getElementsByTagName("td")[0].innerText;
                user_email = tr.getElementsByTagName("td")[1].innerText;
                timestamp = tr.getElementsByTagName("td")[2].innerText;
                psnoEdit.value = psno;
                useremailEdit.value = user_email;
                timestampEdit.value = timestamp;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#editModal').modal('toggle');
            });
        });
    </script>
</body>

</html>