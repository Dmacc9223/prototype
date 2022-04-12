<?php
include "_dbconnect.php";
    if (isset($_POST['passwordmgmt'])) {
        $pass = $conn->real_escape_string($_POST['pass']);
        $cpass = $conn->real_escape_string($_POST['cpass']);
        $sql = "UPDATE `users` SET `rights` = ? WHERE `users`.`sno` = $snoEdit;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Failed!";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $currentPermission);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result) {
            $updatePermission = true;
        }
    }
    }

?>
<!-- <div class="modal fade" id="password" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">change the password </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/prototype/partials/_passwordmgmt.php" method="POST">
                    <input type="hidden" name="passwordmgmt">
                    <div class="form-group">
                        <label for="loginPass">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>
                    <div class="form-group">
                        <label for="loginPass">Confirm Password</label>
                        <input type="password" class="form-control" id="cpass" name="cpass">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->