<?php
    if (!isset($db)) {
       $host        = "127.0.0.1";
       $port        = "3306";
       $dbname      = "tudo";
       $username    = "tudo";
       $password    = "tudo1@1!";

       $db = new mysqli("$host", "$username", "$password", "$dbname");

       if (!$db) {
           echo "Error: Unable to connect to db.";
       }
    }
?>