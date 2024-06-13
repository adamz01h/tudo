<?php
    if (!isset($db)) {
       $dbhost        = "127.0.0.1";
       $dbport        = "3306";
       $dbname        = "tudo";
       $dbusername    = "tudo";
       $dbpassword    = "tudo1@1!";

       $db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
       if(!$db) {
           echo "Error: Unable to connect to db.";
       }
    }