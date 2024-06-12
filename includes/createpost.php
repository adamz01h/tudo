<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $lvaCode = $_POST['lvaCode'];
        $lvaName = $_POST['lvaName'];
        $professor = $_POST['professor'];
        $ects = $_POST['ects'];
        $description = $_POST['description'];

        if ($lvaCode!=="" && $lvaName!=="" && $professor!=="" && $ects!=="" && $description!=="") {
            include('db_connect.php');
        //$ret = pg_prepare($db,
        //    "createpost_query", "insert into class_posts (code, name, professor, ects, description) values ($1, $2, $3, $4, $5)");
        //$ret = pg_execute($db, "createpost_query", array($lvaCode,$lvaName,$professor,$ects,$description));
        
        // Prepare the MySQLi statement
        $stmt = $db->prepare("INSERT INTO class_posts (code, name, professor, ects, description) VALUES (?, ?, ?, ?, ?)");

        // Check if the preparation was successful
        if ($stmt === false) {
            die("Error preparing statement: " . $db->error);
        }

        // Bind parameters (s for string, i for integer, d for double, b for blob)
        $stmt->bind_param("sssis", $lvaCode, $lvaName, $professor, $ects, $description);

        // Execute the statement
        $ret = $stmt->execute();


        }
    }
    header('location:/index.php');
    die();
?>