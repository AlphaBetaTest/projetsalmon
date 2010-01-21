<?php
$dbhost = "localhost"; // ip du serveur mysql
$dbusername = "root"; // nom d'utilisateur
$dbpass = ""; // mot de passe
$dbname = "projet"; // nom de la base de données
mysql_connect($dbhost, $dbusername, $dbpass); // connexion
mysql_select_db($dbname); // selection de la BD
?>
