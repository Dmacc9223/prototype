<?php
  
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  include "_dbconnect.php";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $psno = $_SESSION['psno'];
  $sql = "SELECT * FROM `users` WHERE `psno`=?";


  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "Failed!";    
  }
  else {
      mysqli_stmt_bind_param($stmt, "s", $psno);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);


  while ($row = mysqli_fetch_assoc($result)) {
    $right = $row['rights'];
  }
}
}
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#">Prototype</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
    <a class="nav-link" href="/prototype">Home <span class="sr-only">(current)</span></a>
    </li>';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  if ($right == 2) {
    echo '<li class="nav-item">
    <a class="nav-link" href="/prototype/adminpanel.php">User Management</a>
    </li><li class="nav-item">
    <a class="nav-link" href="/prototype/user_approve.php">User Approve</a>
    </li>';
  }
}
echo '     
  </ul>';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  echo ' <button type="button" class="btn btn-secondary" data-placement="top" title="Loggedin ID"  data-toggle="modal" data-target="#password">Logged in as: <b>' . $_SESSION['psno'] . '</b>
  </button>
  <a href="/prototype/partials/_logout.php" class="btn btn-danger my-2 mx-2 my-sm-0" type="submit">Logout</a>';
} else {
  echo '
<button class="btn btn-outline-danger my-2 my-sm-0 mx-2" type="button" data-toggle="modal" data-target="#loginModal">Login</button>
<button class="btn btn-outline-info my-2 my-sm-0" type="button" data-toggle="modal" data-target="#signupModal">Signup</button>
';
}
echo '
</div>
</nav>';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/prototype/partials/_loginModal.php";
include "$root/prototype/partials/_passwordmgmt.php";
include "$root/prototype/partials/_signupModal.php";
if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> Now you can login.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
} else {
  if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false") {
    $showError = $conn->real_escape_string($_GET['error']);
    if ($_GET['error'] != 'false') {
      echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
      <strong>Error!</strong> ' . $showError . '.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
  }
}
if (isset($_GET['loginsuccess'])) {
  $loginSuccess = $conn->real_escape_string($_GET['loginsuccess']);
  if ($loginSuccess != 'true') {
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Error!</strong> ' . $loginSuccess . '.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }
}
