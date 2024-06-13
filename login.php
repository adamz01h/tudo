<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header('location: /index.php');
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = hash('sha256', $_POST['password']);

    include('includes/db_connect.php');

    // Prepare the MySQLi statement to check login credentials
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $db->error);
    }

    // Bind the username and password parameters
    $stmt->bind_param("ss", $_POST['username'], $password);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows === 1) {
        // Start the session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_POST['username'];

        if ($_SESSION['username'] === 'admin') {
            $_SESSION['isadmin'] = true;
        }

        // Redirect to the index page
        header('Location: /index.php');
        die();
    } else {
        $error = true;
    }
}
?>

<html>

<head>
    <title>TUDO/Log In</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div id="content">
        <div class="center_form">
            <?php
            include('includes/db_connect.php');

            echo '<h4>[All Posts]</h4>';
            echo '<table id="class_posts">';
            echo '<tr><th>Course Code</th><th>Course Name</th><th>Professor</th>';
            echo '<th>Rating</th><th>Comment</th></tr>';
            // Execute the query to select all records from the class_posts table
            $result = $db->query("SELECT * FROM class_posts");

            // Check for errors
            if ($db->error) {
                die("Error executing query: " . $db->error);
            }

            // Fetch and display each row
            while ($row = $result->fetch_row()) {
                echo '<tr>';
                echo '<td><i>' . htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') . '</i></td>';
                echo '<td><u>' . htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8') . '</u></td>';
                echo '<td>' . htmlspecialchars($row[3], ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($row[4], ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($row[5], ENT_QUOTES, 'UTF-8') . '</td>';
                echo '</tr>';
            }
            echo '</table><hr>';
            ?>
        </div>
        <form class="center_form" action="login.php" method="POST">
            <h1>Log In:</h1>
            <p>Currently we are in the Alpha testing phase, thus you may log in if you recieved credentials from
                the admin. Otherwise you can admin the few pages linked at the bottom :)
            </p>
            <input name="username" placeholder="Username"><br><br>
            <input type="password" name="password" placeholder="Password"><br><br>
            <input type="submit" value="Log In">
            <?php if (isset($error)) {
                echo "<span style='color:red'>Login Failed</span>";
            } ?>
            <br><br>
            <?php include('includes/login_footer.php'); ?>
        </form>
    </div>
</body>

</html>