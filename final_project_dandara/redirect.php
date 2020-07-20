<?php 
require 'includes/functions.php';

if(count($_POST) > 0)
{
     if($_GET['from'] == 'login')
     {
        $found   = false;// assume not found

        $email = trim($_POST['email']);
        $pass = trim($_POST['password']);

        if(checkEmail($email))
        {
            $found = findUser($email, $pass);

            if($found)
            {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['user'] = getUser($email);
                header('Location: index.php?from=login');
                exit();
            }
            
        }

        setcookie('error_message', 'Login not found! Try again.');
        header('Location: index.php');
        exit();
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
            header('Location: index.php?from=signup');
            exit();
        }

        setcookie('error_message', $message);
        header('Location: index.php');
        exit();
    }
}
?>