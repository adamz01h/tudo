<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_FILES['image']) {
            $validfile = true;

            $is_check = getimagesize($_FILES['image']['tmp_name']);
            if ($is_check === false) {
                $validfile = false;
                echo 'Failed getimagesize<br>';
            }

            $illegal_ext = Array("php","pht","phtm","phtml","phpt","pgif","phps","php2","php3","php4","php5","php6","php7","php16","inc");
            $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if (in_array($file_ext, $illegal_ext)) {
                $validfile = false;
                echo 'Illegal file extension<br>';
            }

            $allowed_mime = Array("image/gif","image/png","image/jpeg");
            $file_mime = $_FILES['image']['type'];
            if (!in_array($file_mime, $allowed_mime)) {
                $validfile = false;
                echo 'Illegal mime type<br>';
            }

            if ($validfile) {
                $path = basename($_FILES['image']['name']);
                $title = htmlentities($_POST['title']);

                move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$path);

                include('../includes/db_connect.php');
            /* $ret = pg_prepare($db,
                    "createimage_query", "insert into motd_images (path, title) values ($1, $2)");
                $ret = pg_execute($db, "createimage_query", array($path, $title)); */

            // Prepare the MySQLi statement to insert the image
            $stmt = $db->prepare("INSERT INTO motd_images (path, title) VALUES (?, ?)");
            if ($stmt === false) {
                die("Error preparing statement: " . $db->error);
            }

            // Bind the path and title parameters
            $stmt->bind_param("ss", $path, $title);

            // Execute the statement
            $ret = $stmt->execute();

            // Check for errors
            if ($stmt->error) {
                die("Error executing statement: " . $stmt->error);
            }

            // Close the statement
            $stmt->close();

                echo 'Success';
            }
        }
    }

    header('location:/admin/update_motd.php');
    die();
?>