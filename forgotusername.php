<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('location: /index.php');
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];

        include('includes/db_connect.php');
    /*  $ret = pg_query($db, "select * from users where username='".$username."';");

        if (pg_num_rows($ret) === 1) {
            $success = true;
        } else {
            $error = true;
        } */
    // Prepare the MySQLi statement to select the user
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($query);
    if ($stmt === false) {
        die("Error preparing statement: " . $db->error);
    }

    // Bind the username parameter
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row was returned
    $success = false;
    $error = false;
    if ($result->num_rows === 1) {
        $success = true;
    } else {
        $error = true;
    }

    // Close the statement
    $stmt->close();
    }
?>

<html>
    <head>
        <title>TUDO/Forgot Username</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div id="content">
            <form class="center_form" action="forgotusername.php" method="POST">
                <h1>Forgot Username:</h1>
                <p>Forgetting your username can be very frustrating. Unfortunately, we can't just list all the accounts out for everyone 
                to see. What we can do is let you look up your username guesses and we will check if they are in the system. Hopefully it 
                won't take you too long :(</p>
                <input name="username" placeholder="Username"><br><br>
                <input type="submit" value="Send Reset Token"> 
                <?php if (isset($error)){echo "<span style='color:red'>User doesn't exist.</span>";}
                else if (isset($success)){echo "<span style='color:green'>User exists!</span>";} ?>
                <br><br>
                <?php include('includes/login_footer.php'); ?>
            </form>
        </div>
    </body>
</html>