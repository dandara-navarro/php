<?php
define('FILE_SIZE_LIMIT', 4000000);

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

/* To validate fields that only accept letters and space */
function validateTextInput($string)
{
    return preg_match('/^[a-zA-Z\s]+$/', $string);
}

/* To validate price fields */
function validatePrice($price) 
{
    return preg_match('/^\d+(\.\d{2})?$/', $price);
}

/* To validate the image size and type */
function checkPicture($file)
{
    if($file['picture']['size'] < FILE_SIZE_LIMIT && $file['picture']['type'] == 'image/jpeg')
    {
        return true;
    }

    return 'Unable to upload product picture!';
}

?>