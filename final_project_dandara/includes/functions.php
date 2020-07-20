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
    elseif(!filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL))
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

        $results = fwrite($fp, $first_name.'|'.$last_name.'|'.$email.'|'.$hash. PHP_EOL);

        fclose($fp);

        if($results)
        {
            $success = true;
        }
    }

    return $success;
}

?>