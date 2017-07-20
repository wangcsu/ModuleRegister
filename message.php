<?php
require 'config.php';
require 'db.php';
// Message vars
$msg = '';
$msgClass = '';
// check for submit
if (filter_has_var(INPUT_POST, 'submit')){
    // get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // check required field
    if (!empty($email) && !empty($name) && !empty($message)){
        // check email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = 'Please enter a valid email address';
            $msgClass = 'alert-danger';
        } else {
            // recipient email
            $toEmail = 'wk.qwerty17@gmail.com';
            // subject
            $subject = 'Contact request from '.$name;
            $body = '<h2>Contact Request</h2>
                        <h4>Name</h4><p>'.$name.'</p>
                        <h4>Email</h4><p>'.$email.'</p>
                        <h4>Message</h4><p>'.$message.'</p>';

            // Email Headers
            $headers = "MIME-Version: 1.0"."\r\n";
            $headers .= "Content-Type:text/html;charset=UTF-8"."\r\n";

            // Additional Headers
            $headers .= "From: ".$name."<".$email.">"."\r\n";

            if (mail($toEmail, $subject, $body, $headers)){
                // Email sent
                $msg = "Your email has been sent";
                $msgClass = 'alert-success';
            } else {
                $msg = 'Your email was not sent';
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
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container">
    <?php if ($msg != ''): ?>
        <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''?>">
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea name="message" class="form-control"><?php echo isset($_POST['message']) ? $message : ''?></textarea>
        </div>
        <br>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>