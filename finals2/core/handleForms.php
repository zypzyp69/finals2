<?php  

require_once 'dbConfig.php';
require_once 'models.php';


	

if (isset($_POST['insertUserBtn'])) { $first_name = trim($_POST['first_name']); $last_name = trim($_POST['last_name']); $gender = trim($_POST['gender']);
	$specialization = trim($_POST['specialization']); $years_of_experience = trim($_POST['years_of_experience']);
    if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($specialization) && !empty($years_of_experience)){
        $insertUser = insertUser($pdo,$_POST['first_name'], $_POST['last_name'],  $_POST['gender'], $_POST['specialization'], $_POST['years_of_experience']);

                if ($insertUser['status' == '200']) {
                    $_SESSION['message'] = $insertUser['message'];
                    $_SESSION['status'] = $insertUser['status'];
                    header("Location: ../index.php");
                }
                else {
                    $_SESSION['message'] = $insertUser['message'];
                    $_SESSION['status'] = $insertUser['status'];
                    header("Location: ../index.php");
                }
    }
    else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../index.php");
    }
}

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);
	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
			$_SESSION['message'] = $insertQuery['message'];

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Make sure both passwords are correct";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['editUserBtn'])) {

	$editUser = editUser($pdo,$_POST['first_name'], $_POST['last_name'], $_POST['gender'],  $_POST['specialization'], $_POST['years_of_experience'], $_GET['id']);

	if ($editUser['status' == '200']) {
		$_SESSION['message'] = $editUser['message'];
		$_SESSION['status'] = $editUser['status'];
		header("Location: ../index.php");
	}
	else {
		$_SESSION['message'] = $editUser['message'];
		$_SESSION['status'] = $editUser['status'];
		header("Location: ../index.php");
	}
}


if (isset($_POST['deleteUserBtn'])) {
	$deleteUser = deleteUser($pdo,$_GET['id']);

	if ($deleteUser['status' == '200']) {
		$_SESSION['message'] = $deleteUser['message'];
		$_SESSION['status'] = $deleteUser['status'];
		header("Location: ../index.php");
	}
	else {
		$_SESSION['message'] = $deleteUser['message'];
		$_SESSION['status'] = $deleteUser['status'];
		header("Location: ../index.php");
	}
}

if (isset($_GET['searchBtn'])) {
	$searchForAUser = searchForAUser($pdo, $_GET['searchInput']);
	foreach ($searchForAUser as $row) {
		echo "<tr> 
				<td>{$row['id']}</td>
				<td>{$row['first_name']}</td>
				<td>{$row['last_name']}</td>
				<td>{$row['gender']}</td>
				<td>{$row['specialization']}</td>
				<td>{$row['years_of_experience']}</td>
			  </tr>";
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$usernameFromDB = $loginQuery['userInfoArray']['username'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			header("Location: ../index.php");
		}

		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}

}
