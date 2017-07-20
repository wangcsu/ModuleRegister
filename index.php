<?php
require 'config.php';
require 'db.php';
// Error message variables
$msg = '';
$msgClass = '';
$query = "SELECT COUNT(*) AS 'count' FROM students WHERE time_slot = 'Wednesday, July 5th, 2:00pm - 4:00pm'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
$seatsRemaining1 = 8 - $count;
$query = "SELECT COUNT(*) AS 'count' FROM students WHERE time_slot = 'Wednesday, July 19th, 2:00pm - 4:00pm'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
$seatsRemaining2 = 8 - $count;
$query = "SELECT COUNT(*) AS 'count' FROM students WHERE time_slot = 'Wednesday, August 2nd, 2:00pm - 4:00pm'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
$seatsRemaining3 = 8 - $count;
$query = "SELECT COUNT(*) AS 'count' FROM students WHERE time_slot = 'Wednesday, August 16th, 2:00pm - 4:00pm'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
$seatsRemaining4 = 8 - $count;
// Check for submit
if (filter_has_var(INPUT_POST, 'submit')){
    // Get data from the form
    $sid = mysqli_real_escape_string($conn, $_POST['sid']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $timeSlot = mysqli_real_escape_string($conn, $_POST['time_slot']);
    $timeSlot = substr($timeSlot, 0, strpos($timeSlot, "-") + 8);
    // Check required field
    if (!empty($sid) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($timeSlot)){
        // Check if email is valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = 'Please enter a valid email address';
            $msgClass = 'alert-danger';
        } else {
            // Check if there are seats available
            if (($timeSlot == 'Wednesday, July 5th, 2:00pm - 4:00pm' && $seatsRemaining1 <= 0)
                    || ($timeSlot == 'Wednesday, July 19th, 2:00pm - 4:00pm' && $seatsRemaining2 <= 0)
                    || ($timeSlot == 'Wednesday, August 2nd, 2:00pm - 4:00pm' && $seatsRemaining3 <= 0)
                    || ($timeSlot == 'Wednesday, August 16th, 2:00pm - 4:00pm' && $seatsRemaining4 <= 0)) {
                $msg = 'No available seat remaining, please choose a different time slot.';
                $msgClass = 'alert-danger';
            } else {
                // Check if the student already registered
                $query = "SELECT COUNT(*) AS 'count' FROM students WHERE SID = '$sid' AND email = '$email' AND first_name = '$firstName' AND last_name = '$lastName'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $count = $row['count'];
                if ($count > 0){
                    $url = ROOT_URL.'update.php?sid='.$sid;
                    header('Location: '.$url.'');
                } else {
                    // Check if the email or SID is already in use
                    $query = "SELECT COUNT(*) AS 'count' FROM students WHERE SID = '$sid' OR email = '$email'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $count = $row['count'];
                    if ($count > 0) {
                        $msg = 'SID: ' . $sid . ' or Email: ' . $email . ' has already been registered, please use a different one';
                        $msgClass = 'alert-warning';
                    } else {
                        // Insert into the database
                        $query = "INSERT INTO students(SID, first_name, last_name, email, time_slot) VALUES('$sid', '$firstName', '$lastName', '$email', '$timeSlot')";
                        if (mysqli_query($conn, $query)) {
                            $msg = 'You registered at ' . $timeSlot . ' successfully.';
                            $msgClass = 'alert-success';
                            // Decrease the available seats
                            switch ($timeSlot) {
                                case 'Wednesday, July 5th, 2:00pm - 4:00pm':
                                    $seatsRemaining1 -= 1;
                                    break;
                                case 'Wednesday, July 19th, 2:00pm - 4:00pm':
                                    $seatsRemaining2 -= 1;
                                    break;
                                case 'Wednesday, August 2nd, 2:00pm - 4:00pm':
                                    $seatsRemaining3 -= 1;
                                    break;
                                case 'Wednesday, August 16th, 2:00pm - 4:00pm':
                                    $seatsRemaining4 -= 1;
                                    break;
                                default:
                                    ;
                            }
                        } else {
                            $msg = 'ERROR: ' . mysqli_error($conn);
                            $msgClass = 'alert-danger';
                        }
                    }
                }
            }
        }
    } else {
        $msg = 'Please fill in all fields';
        $msgClass = 'alert-danger';
    }

}
// Free result
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>
<?php include('header.php'); ?>
<div class="container">
    <h3>Module Demonstrations - Register here for a time slot</h3>
    <div class="well">
        <h4>Register only if you know what you are doing.</h4>
        <ul>
            <li>Please enter <strong>all</strong> information and select your desired day.</li>
            <li>Please enter a correct 'SID' number.</li>
            <li>Please check the number of available slots before submitting.</li>
            <li>Register only to one slot.</li>
            <li>Any problem? Send a message to <a href="#">Administrator</a></li>
        </ul>
    </div>
    <?php if ($msg !=''): ?>
        <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
    <?php endif; ?>
    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label for="inputFirstName" class="col-lg-2 control-label">First Name</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputFirstName" name="first_name" placeholder="First Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputLastName" class="col-lg-2 control-label">Last Name</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputLastName" name="last_name" placeholder="Last Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputSID" class="col-lg-2 control-label">SID</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputSID" name="sid" placeholder="SID">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Time Slot</label>
                <div class="col-lg-10">
                    <select class="form-control" id="select" name="time_slot">
                        <option>Wednesday, July 5th, 2:00pm - 4:00pm &nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $seatsRemaining1; ?> seats remaining)</option>
                        <option>Wednesday, July 19th, 2:00pm - 4:00pm &nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $seatsRemaining2; ?> seats remaining)</option>
                        <option>Wednesday, August 2nd, 2:00pm - 4:00pm &nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $seatsRemaining3; ?> seats remaining)</option>
                        <option>Wednesday, August 16th, 2:00pm - 4:00pm &nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $seatsRemaining4; ?> seats remaining)</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<?php include('footer.php'); ?>