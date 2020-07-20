<?php 
require 'includes/functions.php';

if(count($_POST) > 0)
{
     if($_GET['from'] == 'login')
     {
    //     $found   = false;// assume not found

    //     $user = trim($_POST['user']);
    //     $pass = trim($_POST['password']);

    //     echo $user . 'opa: ' . $pass;

    //     if(checkUsername($user))
    //     {
    //         $found = findUser($user, $pass);

    //         if($found)
    //         {
    //             session_start();
    //             $_SESSION['loggedin'] = true;
    //             $_SESSION['username'] = $user;
    //             header('Location: thankyou.php?type=login&username='.filterUserName($user));
    //             exit();
    //         }
            
    //     }

    //     setcookie('error_message', 'Login not found! Try again.');
    //     header('Location: login.php');
    //     exit();
     }
    elseif($_GET['from'] == 'signup')
    {
        $message = checkSignUp($_POST);
        if($message == 'true' && saveUser($_POST))
        {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = trim($_POST['email']);
            $_SESSION['user'] = $_POST['first-name'] . ' ' . $_POST['last-name'];
            header('Location: index.php?from=signup&email='.trim($_POST['email']));
            exit();
        }

        setcookie('error_message', $message);
        header('Location: index.php');
        exit();
    }
}
?>