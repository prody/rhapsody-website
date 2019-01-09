<?php
    $username = "Welcome to my world";
    $html = file_get_contents("template.html"); // opens template.html
    $html = str_replace("{{username}}", $username, $html); // replaces placeholder with $username

    echo $html;
?>
