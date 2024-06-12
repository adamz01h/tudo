<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('location: /index.php');
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = hash('sha256',$_POST['password']);

        include('includes/db_connect.php');
    /*         $ret = pg_prepare($db, "login_query", "select * from users where username = $1 and password = $2");
        $ret = pg_execute($db, "login_query", array($_POST['username'], $password));

        if (pg_num_rows($ret) === 1) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST['username'];

            if ($_SESSION['username'] === 'admin')
                $_SESSION['isadmin'] = true;

            header('location: /index.php');
            die();
        } */


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
    }
        else {
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
            <form class="center_form" action="login.php" method="POST">
                <h1>Log In:</h1>
                <p>Currently we are in the Alpha testing phase, thus you may log in if you recieved credentials from
                the admin. Otherwise you can admin the few pages linked at the bottom :)
                </p>
                <input name="username" placeholder="Username"><br><br>
                <input type="password" name="password" placeholder="Password"><br><br>
                <input type="submit" value="Log In"> 
                <?php if (isset($error)){echo "<span style='color:red'>Login Failed</span>";} ?>
                <br><br>
                <?php include('includes/login_footer.php'); ?>
            </form>
        </div>
    </body>
</html>