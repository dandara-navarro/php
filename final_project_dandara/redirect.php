<?php 
require 'includes/manage_user.php';
require 'includes/manage_product.php';

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
            $_SESSION['email'] = trim($_POST['email']);
            $_SESSION['user'] = $_POST['first-name'] . ' ' . $_POST['last-name'];
            header('Location: index.php?from=signup');
            exit();
        }

        setcookie('error_message', $message);
        header('Location: index.php');
        exit();
    }
    elseif($_GET['from'] == 'new-item')
    {
        if(count($_FILES) > 0)
        {
            session_start();
            if(checkPicture($_FILES) != 'true')
            {
                setcookie('error_message', 'Choose a JPG image with up to 4MB.');
               // exit();
            }
            elseif(!validatePrice($_POST['price']))
            {
                setcookie('error_message', 'The product price is in incorrect format.');
               // exit();
            }
            else{
                addProduct($_SESSION['email'], $_POST, $_FILES);
               
            }
            header('Location: index.php');
            exit();
        }
        
    }
}
elseif(isset($_GET['downvote']))
{
    session_start();
    if(!isset($_SESSION['loggedin']))
    {
        header('Location: index.php');
        exit();
    }
    
    $product_id = $_GET['downvote'];
    $user_email = $_SESSION['email'];
    downvoteProduct($product_id, $user_email);
    header('Location: index.php');
    exit();
}
?>