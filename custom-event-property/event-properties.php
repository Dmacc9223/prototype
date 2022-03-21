<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: /prototype");
  exit;
}
?>
<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/prototype/partials/_dbconnect.php";
$entryError = false;
$delete = false;
?>
<?php
if (isset($_GET['project'])) {
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $project = $_GET['project'];
  }
}
?>
<?php
$insert = false;
$edit = false;
$delete = false;
$entryError = false;
if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  $sql = "DELETE FROM `custom-event-properties` WHERE `sno` = ? ";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Failed!";
  } else {
    mysqli_stmt_bind_param($stmt, "s", $sno);
    $result = mysqli_stmt_execute($stmt);
    // $result = mysqli_stmt_get_result($stmt);
    if ($result) {
      $delete = true;
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  if (isset($_GET['snoEdit'])) {
    $sno = $conn->real_escape_string($_GET['snoEdit']);
    $logsource = $conn->real_escape_string($_GET['logsourceEdit']);
    $name = $conn->real_escape_string($_GET['nameEdit']);
    $regex = $conn->real_escape_string($_GET['regexEdit']);
    $sql = "UPDATE `custom-event-properties` SET `log-source-type`=?,`name`=?,`regex`=? WHERE `custom-event-properties`.`sno`=$sno;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "Failed!";
    } else {
      mysqli_stmt_bind_param($stmt, "sss", $logsource, $name, $regex);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_stmt_execute($stmt)) {
        $edit = true;
      } else {
        echo "Error";
      }
    }
  } else {
    if (isset($_GET['insert'])) {
      $logsource = $conn->real_escape_string($_GET['log-source']);
      $name = $conn->real_escape_string($_GET['name']);
      $regex = $conn->real_escape_string($_GET['regex']);
      $sql = "INSERT INTO `custom-event-properties`(`log-source-type`, `name`, `regex`, `parent-id`) VALUES (?,?,?,?)";

      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "Failed!";    
      }
      else {
          mysqli_stmt_bind_param($stmt, "ssss", $logsource, $name, $regex, $project);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
      if (mysqli_stmt_execute($stmt)) {
        $insert = true;
      }
    }
  }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <title>custom-event-properties!</title>
</head>

<body>
  <!--modal-->
  <!-- Button trigger modal -->
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this custom-event-properties</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="event-properties.php" method="GET">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <input type="hidden" name="project" value="<?php echo $_GET['project']; ?>" id="project">
            <div class="form-group">
              <label for="exampleInputEmail1">Title of the custom-event-properties</label>
              <input type="text" class="form-control" id="logsourceEdit" name="logsourceEdit" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Description of the custom-event-properties</label>
              <input type="text" class="form-control" id="nameEdit" name="nameEdit">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Description of the custom-event-properties</label>
              <input type="text" class="form-control" id="regexEdit" name="regexEdit">
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
  <!--modal-->
  <!--navbar-->
  <?php include "$root/prototype/partials/_navbar.php"; ?>
  <!--navbar-->
  <!--PHP-->
  <?php
  if ($insert) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You had added the notes successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
  if ($edit) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Edited successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
  if ($entryError) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Please enter the required fields.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
  if ($delete) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Success!</strong> You deleted the record successfully.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
  ?>
  <!--PHP-->
  <!-- <div class="container"> -->
  <h2 class="text-center my-4">Custom Event properties </h2>
  <table class="table" id="myTable">
    <thead>
      <tr>
        <th scope="col">S.No.</th>
        <th scope="col">Log Source</th>
        <th scope="col">Name</th>
        <th scope="col">Regex</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM `custom-event-properties`";
      $result = mysqli_query($conn, $sql);
      $sno = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $sno = $sno + 1;
        echo '<tr>
      <th scope="row">' . $sno . '  </th>
      <td>' . $row['log-source-type'] . '</td>
      <td>' . $row['name'] . '</td>
      <td>' . $row['regex'] . '</td>
      <td>';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
          if ($right == 1 or $right == 2) {
            echo '<button class="btn btn-success btn-sm my-2 my-sm-0 edit" type="submit" id="' . $row['sno'] . '">Edit</button><button class="btn btn-sm btn-danger my-2 mx-1 my-sm-0 delete" type="submit" id="d' . $row['sno'] . '">Delete</button>';
          }
          if ($right == 0) {
            echo '<button class="btn btn-secondary btn-sm my-2 my-sm-0" type="submit" id="' . $row['sno'] . '">Edit</button><button class="btn btn-sm btn-secondary my-2 mx-1 my-sm-0" type="submit" id="d' . $row['sno'] . '">Delete</button>';
          }
        }
      ?>
      <?php
        echo '</td>
      </tr>
      ';
      }
      ?>
    </tbody>
  </table>
  <!-- </div> -->
  <!--Forms-->
  <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if ($right == 1 or $right == 2) {
      echo '<div class="container my-4" id="addnote">
      <h1>Log Source</h1>
      <form action="event-properties.php" method="GET">
        <div class="form-group">
        <input type="hidden" name="project" value="' . $project . '">
        <input type="hidden" name="insert" value="insert">
        <label for="exampleInputEmail1">Log source type</label>
          <input type="text" class="form-control" id="log-source" name="log-source" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Name</label>
          <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Regex</label>
          <input type="text" class="form-control" id="regex" name="regex">
        </div>
        <button type="submit" class="btn btn-outline-primary">Submit</button>
      </form>
    </div>';
    }
  }


  ?>
  <!--Forms-->
  <!--Table-->

  <!--Table-->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Edit");
        tr = e.target.parentNode.parentNode;
        logsource = tr.getElementsByTagName("td")[0].innerText;
        name = tr.getElementsByTagName("td")[1].innerText;
        regex = tr.getElementsByTagName("td")[2].innerText;
        console.log(logsource);
        console.log(name);
        logsourceEdit.value = logsource;
        nameEdit.value = name;
        regexEdit.value = regex;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
      });
    });
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("delete", e);
        sno = e.target.id.substr(1, );
        if (confirm("Are you sure to delete this note?")) {
          window.location = `event-properties.php?project=<?php echo $project; ?>&delete=${sno}`;
        } else {
          console.log("no");
        }
      })
    });
  </script>
</body>

</html>