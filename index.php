<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] == true) {
        header('location: /login.php');
        die();
    } 
?>

<html>
    <head>
        <title>TUDO/Home</title>
        <link rel="stylesheet" href="style/style.css">
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div id="content">
            <div id="index_content">
                <?php if (isset($_SESSION['isadmin'])) {
                    include('includes/db_connect.php');
                    // Execute the query to select all users ordered by uid in ascending order
                    $result = $db->query("SELECT * FROM users ORDER BY uid ASC");

                    // Check for errors
                    if ($db->error) {
                        die("Error executing query: " . $db->error);
                    }

                    // Display the results
                    echo '<h4>[Admin Section]</h4>';
                    echo '<table>';
                    echo '<tr><th>Uid</th><th>Username</th><th>Password (SHA256)</th><th>Description</th></tr>';

                    // Fetch and display each row
                    while ($row = $result->fetch_row()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars($row[3], ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '</tr>';
                    }

                    echo '</table><br>';
                    echo '<b>Import user:</b> <br>';
                ?>
                    <form action="admin/import_user.php" method="POST">
                        <input name="userobj" placeholder="User Object"> 
                        <input type="submit" value="Import User">
                    </form>
                <?php
                    echo '<hr>';
                } ?>

                <?php
                    if (isset($_SESSION['isadmin']))
                        echo '<a href="admin/update_motd.php">';
                    echo '<h4>[MoTD]</h4>';
                    echo '<div class="center_div">';
                    if (isset($_SESSION['isadmin']))
                        echo '</a>';

                    include('includes/db_connect.php');
                 //  // Execute the query to select all records from the motd table
                 //  $result = $db->query("SELECT * FROM motd");

                 //  // Check for errors
                 //  if ($db->error) {
                 //      die("Error executing query: " . $db->error);
                 //  }

                 //  // Fetch the first row
                 //  $row = $result->fetch_row();
                    require_once 'vendor/autoload.php';
                    $smarty = new Smarty();
                    $smarty->assign("username", $_SESSION['username']);
                    $smarty->debugging = true;
                    $smarty->force_compile = true;
                    echo $smarty->fetch("motd.tpl").'<br>';

                    // Execute the query to select the last 3 records from the motd_images table ordered by iid in descending order
                    $result = $db->query("SELECT * FROM motd_images ORDER BY iid DESC LIMIT 3");

                    // Check for errors
                    if ($db->error) {
                        die("Error executing query: " . $db->error);
                    }

                    // Fetch and display each row
                    while ($row = $result->fetch_row()) {
                        echo '<figure><img src="' . htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8') . '" /><figcaption>' . htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8') . '</figcaption></figure>';
                    }


                    echo '</div>';
                    echo '<hr>';
                ?>

                <?php
                    include('includes/db_connect.php');
               
                    echo '<h4>[All Posts]</h4>';
                    echo '<table id="class_posts">';
                    echo '<tr><th>Lva Code</th><th>Lva Name</th><th>Professor</th>';
                    echo '<th>ECTS</th><th>Comment</th></tr>';
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

                <h4>[Create a post]</h4>
                <form action="includes/createpost.php" method="POST">
                    <input name="lvaCode" placeholder="Lva Code">
                    <input name="lvaName" placeholder="Lva Name">
                    <input name="professor" placeholder="Professor">
                    <input type="number" step="0.5" name="ects" placeholder="Ects">
                    <input name="description" placeholder="Description">
                    <br><br>
                    <input type="submit" value="Submit Post">
                </form>
            </div>
        </div>
    </body>
</html>
