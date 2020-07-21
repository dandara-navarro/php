<?php
require 'includes/manage_product.php';

session_start();
if(!isset($_SESSION['loggedin']))
{
    header('Location: index.php');
    exit();
}

// if this was an actual database, you'd be validating the ID
deleteProduct($_GET['id'], $_SESSION['email']);
header('Location: index.php');
exit();
