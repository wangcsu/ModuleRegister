<?php
require 'config.php';
require 'db.php';

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

// Get sid
$sid = mysqli_real_escape_string($conn, $_GET['sid']);
// Check for submit
if (filter_has_var(INPUT_POST, 'submit')){
    $sid_new = mysqli_real_escape_string($conn, $_POST['sid']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $timeSlot = mysqli_real_escape_string($conn, $_POST['time_slot']);
    $timeSlot = substr($timeSlot, 0, strpos($timeSlot, '-') + 8);
    // Check for required fields
    if (!empty($sid_new) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($timeSlot)) {
        // Check for valid email address
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
                // Increase the available seats
                $query = "SELECT time_slot FROM students WHERE SID = '$sid'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $time_slot = $row['time_slot'];
                switch ($time_slot) {
                    case 'Wednesday, July 5th, 2:00pm - 4:00pm':
                        $seatsRemaining1 += 1;
                        break;
                    case 'Wednesday, July 19th, 2:00pm - 4:00pm':
                        $seatsRemaining2 += 1;
                        break;
                    case 'Wednesday, August 2nd, 2:00pm - 4:00pm':
                        $seatsRemaining3 += 1;
                        break;
                    case 'Wednesday, August 16th, 2:00pm - 4:00pm':
                        $seatsRemaining4 += 1;
                        break;
                    default:
                        ;
                }
                // Delete the old record
                $query = "DELETE FROM students WHERE SID = '$sid'";
                mysqli_query($conn, $query);
                // Check if the new SID or email is in use
                $query = "SELECT COUNT(*) AS 'count' FROM students WHERE SID = '$sid_new' OR email = '$email'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $count = $row['count'];
                if ($count > 0) {
                    $msg = 'SID: ' . $sid . ' or Email: ' . $email . ' has already been registered, please use a different one';
                    $msgClass = 'alert-warning';
                } else {
                    // Insert the new record into database
                    $query = "INSERT INTO students(SID, first_name, last_name, email, time_slot) VALUES('$sid_new', '$firstName', '$lastName', '$email', '$timeSlot')";
                    if (mysqli_query($conn, $query)) {
                        $msg = 'You registered at ' . $timeSlot . ' successfully.';
                        $msgClass = 'alert-success';
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
    } else {
        $msg = 'Please fill in all fields';
        $msgClass = 'alert-danger';
    }
}
?>

<html>
<head>
    <title>Update</title>
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Registration</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo ROOT_URL; ?>">Student</a></li>
                <li><a href="#">Lecturer</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
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
    <?php if ($msg == ''): ?>
    <div class="alert alert-dismissible alert-warning">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Warning!</h4>
        <P>You've already registered!</P>
        <p>If you wish to update your information, please fill out the form below.</p>
        <p>Or,</p>
        <p><a href="<?php echo ROOT_URL; ?>">Back to registration</a></p>
    </div>
    <?php else: ?>
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
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

