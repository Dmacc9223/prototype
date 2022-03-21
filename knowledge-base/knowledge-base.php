<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true) {
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
      $project = $conn->real_escape_string($_GET['project']);
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
    $sql = "DELETE FROM `knowledge-base` WHERE `sno` = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Failed!";    
    }
    else {
        mysqli_stmt_bind_param($stmt, "s", $sno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_stmt_execute($stmt)) {
          $delete = true;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['snoEdit'])) {
      $sno = $conn->real_escape_string($_GET['snoEdit']);
      $sno = $conn->real_escape_string($_GET['snoEdit']);
      $date = $conn->real_escape_string($_GET['dateEdit']);
      $offense = $conn->real_escape_string($_GET['offenseEdit']);
      $offensedesc = $conn->real_escape_string($_GET['offensedescEdit']);
      $knowledgeadd = $conn->real_escape_string($_GET['knowledgeaddEdit']);
      $rpt = $_GET['rptEdit'];
      $sql = "UPDATE `knowledge-base` SET `date`=?,`offense`=?,`offense-desc`=?, `knowledge-add`=?, `response-from-team`=? WHERE `knowledge-base`.`sno`=?;";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "Failed!";    
      }
      else {
          mysqli_stmt_bind_param($stmt, "ssssss", $date, $offense, $offensedesc, $knowledgeadd, $rpt, $sno);
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
        $date = $conn->real_escape_string($_GET['date']);
        $offense = $conn->real_escape_string($_GET['offense']);
        $offensedesc = $conn->real_escape_string($_GET['offense-desc']);
        $knowledgeadd = $conn->real_escape_string($_GET['knowledge-add']);
        $rpt = $conn->real_escape_string($_GET['response-from-team']);
        $project = $conn->real_escape_string($_GET['project']);
        $sql = "INSERT INTO `knowledge-base`(`date`, `offense`, `offense-desc`, `knowledge-add`, `response-from-team`, `project`) VALUES (?,?,?,?,?,?)";

        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "Failed!";    
        }
        else {
            mysqli_stmt_bind_param($stmt, "ssssss", $date, $offense, $offensedesc, $knowledgeadd, $rpt, $project);
            $result = mysqli_stmt_execute($stmt);
            // $result = mysqli_stmt_get_result($stmt);
        if ($result) {
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this knowledge-base</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="knowledge-base.php" method="GET">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <input type="hidden" name="project" id="project" value="<?php echo $project ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title of the knowledge-base</label>
                            <input type="date" class="form-control" id="dateEdit" name="dateEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description of the knowledge-base</label>
                            <input type="text" class="form-control" id="offenseEdit" name="offenseEdit">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description of the knowledge-base</label>
                            <textarea type="text" class="form-control" id="offensedescEdit" name="offensedescEdit"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description of the knowledge-base</label>
                            <textarea type="text" class="form-control" id="knowledgeaddEdit" name="knowledgeaddEdit"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description of the knowledge-base</label>
                            <textarea type="text" class="form-control" id="rptEdit" name="rptEdit"></textarea>
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
    <h2 class="text-center">Log Source </h2>
    <table class="table" id="myTable">
    <caption>Log Sources</caption>

        <thead>
            <tr>
                <th scope="col">S.No.</th>
                <th scope="col">date</th>
                <th scope="col">Offense</th>
                <th scope="col">Knowledge Desc</th>
                <th scope="col">Knowledge Desc</th>
                <th scope="col">RPT</th>
                <th scope="col">RPT</th>
            </tr>
        </thead>
        <tbody>
        <?php
      if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['project'])) {
          $project = $conn->real_escape_string($_GET['project']);
        }
      }
      $sql = "SELECT * FROM `knowledge-base` WHERE `project`=?";

      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "Failed!";    
      }
      else {
          mysqli_stmt_bind_param($stmt, "s", $project);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);


      $sno = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $sno = $sno + 1;
        echo '<tr>
      <th scope="row">' . $sno . '  </th>
      <td>' . $row['date'] . '</td>
      <td>' . $row['offense'] . '</td>
      <td>' . $row['offense-desc'] . '</td>
      <td>' . $row['knowledge-add'] . '</td>
      <td>' . $row['response-from-team'] . '</td>
      <td>';
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
          if ($right == 1 or $right == 2) {
            echo '
      <button class="btn btn-success btn-sm my-2 my-sm-0 edit" type="submit" id="' . $row['sno'] . '">Edit</button><button class="btn btn-sm btn-danger my-2 mx-1 my-sm-0 delete" type="submit" id="d' . $row['sno'] . '">Delete</button>';
          } else {
            echo '<button class="btn btn-secondary btn-sm my-2 my-sm-0" type="submit" id="' . $row['sno'] . '">Edit</button><button class="btn btn-sm btn-secondary my-2 mx-1 my-sm-0" type="submit" id="d' . $row['sno'] . '">Delete</button>';
          }
          echo '
      </td>
    ';
        }
        echo '</tr>';
      }
    }
      ?></tbody>
    </table>
    <!-- </div> -->
    <!--Forms-->
    <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if ($right == 1 or $right == 2) {
      echo '
  <div class="container my-4" id="addnotes">
    <h1 class="text-center"> Form for adding new Note</h1>
    <form action="knowledge-base.php" method="GET">
      <input type="hidden" name="project" value="'. $project .'">
      <input type="hidden" name="insert" value="insert">
      <div class="form-group">
        <label for="exampleInputPassword1">Date</label>
        <input type="date" class="form-control" id="date" name="date">
      </div>
      <div class="mb-3">
        <label class="form-label">Offense</label>
        <textarea class="form-control" name="offense" id="offense" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Offense Description</label>
        <textarea class="form-control" name="offense-desc" id="offense-desc" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Knowledge addition</label>
        <textarea class="form-control" name="knowledge-add" id="knowledge-add" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Response from team</label>
        <textarea class="form-control" name="response-from-team" id="response-from-team" rows="3"></textarea>
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
    <script src="/prototype/partials/datatables.js"></script>
    <script src="/prototype/partials/resize.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "sDom": "Rlfrtip",
            });
        });
    </script>
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("Edit");
        tr = e.target.parentNode.parentNode;
        date = tr.getElementsByTagName("td")[0].innerText;
        offense = tr.getElementsByTagName("td")[1].innerText;
        offensedesc = tr.getElementsByTagName("td")[2].innerText;
        knowledgeadd = tr.getElementsByTagName("td")[3].innerText;
        rpt = tr.getElementsByTagName("td")[4].innerText;
        console.log(name);
        dateEdit.value = date;
        offenseEdit.value = offense;
        offensedescEdit.value = offensedesc;
        knowledgeaddEdit.value = knowledgeadd;
        rptEdit.value = rpt;
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
          window.location = `knowledge-base.php?delete=${sno}&project=${<?php echo $project ?>}`;
        } else {
          console.log("no");
        }
      })
    });
  </script>
</body>

</html>