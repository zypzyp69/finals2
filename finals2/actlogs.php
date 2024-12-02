<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>
    <link rel="stylesheet" href="styles/actlogs.css">
</head>
<body>
    <?php include 'nbar.php'; ?>
    <div class="tableClass">
        <h1>Activity Log</h1>
        <table>
            <tr>
                <th>Activity Log ID</th>
                <th>ID</th>
                <th>Username</th> 
                <th>User Action</th>
                <th>Date Added</th>
            </tr>
            <?php $getAllActivityLogs = getAllActLogs($pdo); ?>
            <?php foreach ($getAllActivityLogs as $row) { ?>
            <tr>
                <td><?php echo $row['log_id']; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['user_action']; ?></td>
                <td><?php echo $row['date_added']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
