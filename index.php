<?php
require 'config.php';
require 'db.php';
// Error message variables
$msg = '';
$msgClass = '';
// Check for submit
if (filter_has_var(INPUT_POST, 'submit')){
    // Get data from the form
    $sid = mysqli_real_escape_string($conn, $_POST['sid']);
    $firstName = mysqli_real_escape_string($conn, $_POST['first_name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $timeSlot = mysqli_real_escape_string($conn, $_POST['time_slot']);

    // Check required field
    if (!empty($sid) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($timeSlot)){
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = 'Please enter a valid email address';
            $msgClass = 'alert-danger';
        } else {
            $query = "INSERT INTO students(SID, first_name, last_name, email, time_slot) VALUES('$sid', '$firstName', '$lastName', '$email', '$timeSlot')";
            if (mysqli_query($conn, $query)){
                $msg = 'You registered at '.$timeSlot.' successfully.';
                $msgClass = 'alert-success';
            } else {
                $msg = 'ERROR: '.mysqli_error($conn);
                $msgClass = 'alert-danger';
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
    <title>Register</title>
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
                        <option>Wednesday, July 5th, 2:00pm - 4:00pm</option>
                        <option>Wednesday, July 19th, 2:00pm - 4:00pm</option>
                        <option>Wednesday, August 2nd, 2:00pm - 4:00pm</option>
                        <option>Wednesday, August 16th, 2:00pm - 4:00pm</option>
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
<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
