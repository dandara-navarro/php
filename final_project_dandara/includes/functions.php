<?php
define('SALT', '951753654');

function checkSignUp($data)
{
    $valid = true;

    // if any of the required fields are missing
    if( trim($data['email'])        == '' ||
        trim($data['password'])        == '' ||
        trim($data['verify-password']) == '')
    {
        $valid = 'You must fill all the required fields';
    }
    elseif(!checkEmail(trim($data['email'])))
    {
        $valid = 'You cannot sign up! E-mail format is incorrect';
    }
    elseif(!checkPassword(trim($data['password'])))
    {
        $valid = 'You cannot sign up! Password format is incorrect';
    }
    elseif($data['password'] != $data['verify-password'])
    {
        $valid = 'You cannot sign up! The password is different from the verify password';
    }

    return $valid;
}

/* To check if the password is matching with the requirements */
function checkPassword($password) 
{
    return preg_match('/((?=.*[a-z])(?=.*[0-9])(?=.*[!?|@])){8}/', $password);
}
/* To check if the email is in a correct format */
function checkEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function saveUser($data)
{
    $success = false;

    $fp = fopen('users.txt', 'a+');

    if($fp != false)
    {
        $first_name = trim($data['first-name']);
        $last_name = trim($data['last-name']);
        $email   = trim($data['email']);
        $password   = trim($data['password']);
        $hash       = md5($password . SALT);

        $results = fwrite($fp, $email.'|'.$hash.'|'.$first_name.'|'.$last_name. PHP_EOL);

        fclose($fp);

        if($results)
        {
            $success = true;
        }
    }

    return $success;
}

/* To check if a user is registered to log in */
function findUser($email, $pass)
{
    $found = false;
    $lines = file('users.txt');

    foreach($lines as $line)
    {
        $pieces = preg_split("/\|/", $line); 
        $hash   = md5($pass . SALT);

        if($pieces[0] == $email && trim($pieces[1]) == $hash)
        {
            $found = true;
        }
    }

    return $found;
}

function getUser($email)
{
    $user = '-';

    $lines = file('users.txt');

    foreach($lines as $line)
    {
        $pieces = preg_split("/\|/", $line); 

        if($pieces[0] == $email)
        {
            $user = $pieces[2] .' '. $pieces[3];
        }
    }
    return $user;
}

?>