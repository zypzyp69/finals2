<link rel="stylesheet" href="nbar.css">
<div class="greet">
	<h1>Hello there! Welcome, <span style="color: blue;"><?php echo $_SESSION['username']; ?></span></h1>
</div>

<div class="navbar">
	<h3>
		<a href="index.php">Home</a>
		<a href="insert.php">Add New Vet</a>
		<a href="users.php">View All Users</a>
		<a href="actlogs.php">Activity Logs</a>
		<a href="login.php">Logout</a>	
	</h3>	
</div>

