<?php
require 'config.php';
require 'db.php';

$number = 1;

// Create query
$query = 'SELECT * FROM students ORDER BY time_slot DESC, last_name, first_name';

// Get result
$result = mysqli_query($conn, $query);

// Fetch data
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free result
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>
<?php include('header.php'); ?>
<div class="container">
    <h3>Module Demonstration Schedule</h3>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>SID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Time Slot</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo $number++; ?></td>
                <td><?php echo $student['SID']; ?></td>
                <td><?php echo $student['first_name'].' '.$student['last_name']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td><?php echo $student['time_slot']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include('footer.php'); ?>

