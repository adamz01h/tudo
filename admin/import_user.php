<?php
    include('../includes/utils.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userObj = $_POST['userobj'];
        if ($userObj !== "") {
            $user = unserialize($userObj);
            include('../includes/db_connect.php');
                // Prepare the MySQLi statement
                $stmt = $db->prepare("INSERT INTO users (username, password, description) VALUES (?, ?, ?)");

                // Check if the preparation was successful
                if ($stmt === false) {
                    die("Error preparing statement: " . $db->error);
                }

                // Bind parameters (s for string, i for integer, d for double, b for blob)
                $stmt->bind_param("sss", $user->username, $user->password, $user->description);

                // Execute the statement
                $ret = $stmt->execute();

                // Check for errors
                if ($stmt->error) {
                    die("Error executing statement: " . $stmt->error);
                } 
            }  
    }
    header('location:/index.php');
    die();
?>