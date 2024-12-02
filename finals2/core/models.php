<?php  

require_once 'dbConfig.php';

function getAllUsers($pdo) {
	$sql = "SELECT * FROM veterinary
			ORDER BY first_name ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getUserByID($pdo, $id) {
	$sql = "SELECT * from veterinary WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForAUser($pdo, $searchQuery) {
	
	$sql = "SELECT * FROM veterinary WHERE 
			CONCAT(first_name,last_name,gender,specialization,
				years_of_experience,date_added) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}



function insertUser($pdo, $first_name, $last_name, $gender, $specialization, $years_of_experience) {
    $sql = "INSERT INTO veterinary (first_name, last_name, gender, specialization, years_of_experience) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $gender, $specialization, $years_of_experience]);

    if ($executeQuery) {
        $lastId = $pdo->lastInsertId();
        insertActLog($pdo, $_SESSION['username'], $lastId, "INSERT");
        return ["status" => "200", "message" => "User successfully inserted!"];
    } else {
        return ["status" => "400", "message" => "An error occurred with the query!"];
    }
}


function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO userz (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}
    


function editUser($pdo, $first_name, $last_name, $gender, $specialization, $years_of_experience, $id) {
    $sql = "UPDATE veterinary
            SET first_name = ?, last_name = ?, gender = ?, specialization = ?, years_of_experience = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $gender, $specialization, $years_of_experience, $id]);

    if ($executeQuery) {
        insertActLog($pdo, $_SESSION['username'], $id, "EDIT");
        return ["status" => "200", "message" => "User successfully edited!"];
    } else {
        return ["status" => "400", "message" => "An error occurred with the query!"];
    }
}


function deleteUser($pdo, $id) {
    $sql = "SELECT * FROM veterinary WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if ($user) {
        insertActLog($pdo, $_SESSION['username'], $id, "DELETE");
    }

    $sql = "DELETE FROM veterinary WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$id]);

    if ($executeQuery) {
        return ["status" => "200", "message" => "User successfully deleted!"];
    } else {
        return ["status" => "400", "message" => "An error occurred with the query!"];
    }
}


function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM userz WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}


function getAllsUsers($pdo) {
	$sql = "SELECT * FROM userz";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function insertActLog($pdo, $username, $id, $user_action) {
    $sql = "INSERT INTO act_logs (username, id, user_action) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$username, $id, $user_action]);
}


function getAllActLogs($pdo) {
	$sql = "SELECT * FROM act_logs";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}

