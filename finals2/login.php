<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="login.css">
	<title>Login</title>
</head>
<body>
	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
		$statusClass = $_SESSION['status'] == "200" ? 'success' : 'error';
		echo "<div class='alert {$statusClass}'>{$_SESSION['message']}</div>";
	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	<h1>Login Now!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username" required>
		</p>
		<p>
			<label for="password">Password</label>
			<input type="password" name="password" required>
		</p>
		<p>
			<input type="submit" name="loginUserBtn" value="Login">
		</p>
	</form>
	<p>Don't have an account? You may register <a href="register.php">here</a></p>
</body>
</html>