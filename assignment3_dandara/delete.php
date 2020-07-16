<?php
require 'includes/functions.php';

session_start();
if(!isset($_SESSION['loggedin']))
{
    header('Location: index.php');
    exit();
}

// if this was an actual database, you'd be validating the ID
deleteProfile($_GET['id'], $_SESSION['username']);
header('Location: profiles.php');
exit();
