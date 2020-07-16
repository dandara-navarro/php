<?php

define('SALT', 'a_very_random_salt_for_this_app');
define('FILE_SIZE_LIMIT', 4000000);

/**
 * Look up the user & password pair from the text file.
 *
 * Passwords are simple md5 hashed.
 *
 * Remember, md5() is just for demonstration purposes.
 * Do not do this in production for passwords.
 *
 * @param $user string The username to look up
 * @param $pass string The password to look up
 * @return bool true if found, false if not
 */
function findUser($user, $pass)
{
    $found = false;
    $lines = file('users.txt');

    foreach($lines as $line)
    {
        $pieces = preg_split("/\|/", $line); // | is a special character, so escape it
        $hash   = md5($pass . SALT);

        if($pieces[0] == $user && trim($pieces[1]) == $hash)
        {
            $found = true;
        }
    }

    return $found;
}

function storeAdminCredentials($user, $pass) {
    $fp = fopen('admin.ini', 'a+');
    if($fp != false) {
        fwrite($fp, $user.','.$pass. PHP_EOL);
        fclose($fp);
    }
}

/**
 * Remember, md5() is just for demonstration purposes.
 * Do not do this in production for passwords.
 *
 * @param $data
 * @return bool returns false if fopen() or fwrite() fails
 */
function saveUser($data)
{
    $success = false;

    $fp = fopen('users.txt', 'a+');

    if($fp != false)
    {
        $username   = trim($data['username']);
        $password   = trim($data['password']);
        $hash       = md5($password . SALT);

        $results = fwrite($fp, $username.'|'.$hash. PHP_EOL);

        fclose($fp);

        if($results)
        {
            $success = true;
        }
    }

    return $success;
}

function checkUsername($username)
{
    return preg_match('/^([a-z]|[0-9]){8,15}$/i', $username);
}

/**
 * @param $data
 * @return bool
 */
function checkSignUp($data)
{
    $valid = true;

    // if any of the fields are missing
    if( trim($data['username'])        == '' ||
        trim($data['password'])        == '' ||
        trim($data['verify_password']) == '')
    {
        $valid = false;
    }
    elseif(!checkUsername(trim($data['username'])))
    {
        $valid = false;
    }
    elseif(!preg_match('/((?=.*[a-z])(?=.*[0-9])(?=.*[!?|@])){8}/', trim($data['password'])))
    {
        $valid = false;
    }
    elseif($data['password'] != $data['verify_password'])
    {
        $valid = false;
    }

    return $valid;
}

function filterUserName($name)
{
    // if it's not alphanumeric, replace it with an empty string
    return preg_replace("/[^a-z0-9]/i", '', $name);
}

/**
 * @param $file
 * @return bool
 */
function checkPost($file)
{
    if($file['picture']['size'] < FILE_SIZE_LIMIT && $file['picture']['type'] == 'image/jpeg')
    {
        return true;
    }

    return 'Unable to upload profile picture!';
}

/**
 * @param $username
 * @param $file
 * @return bool
 */
function saveProfile($username, $file)
{
    $success = false;

    $picture = md5($username.time());

    $fp      = fopen('profiles.txt', 'a+');
    $moved   = move_uploaded_file($file['picture']['tmp_name'], 'profiles/'.$picture);

    if($fp != false && $moved)
    {
        $post_id = uniqid();
        $results = fwrite($fp, $post_id.'|'.$username.'|'.$picture.PHP_EOL);

        fclose($fp);

        if($results)
        {
            $success = true;
        }
    }

    return $success;
}

/**
 * @return array
 */
function getAllProfiles()
{
    $lines = file('profiles.txt');
    $profiles = [];

    if($lines != false)
    {
        foreach($lines as $line)
        {
            $pieces = preg_split("/\|/", $line);

            $profile['id']       = $pieces[0];
            $profile['username'] = $pieces[1];
            $profile['picture']  = $pieces[2];

            $profiles[] = $profile;
        }
    }

    return $profiles;
}

/**
 * @param $id
 * @param $username
 */
function deleteProfile($id, $username)
{
    $lines = file('profiles.txt');

    if($lines != false)
    {
        // w truncates the file
        $fp = fopen('profiles.txt', 'w');

        // comb through all existing lines
        foreach($lines as $line)
        {
            $pieces = preg_split("/\|/", $line);

            // only deletes if the username matches
            if($pieces[0] == $id && $pieces[1] == $username)
            {
                unlink('profiles/'.trim($pieces[2])); // delete the file
                continue;                             // skip line, end loop
            }

            fwrite($fp, $line); // include this line
        }

        fclose($fp);
    }
}

function isDuplicate($username)
{
    if($lines = file('profiles.txt'))
    {
        foreach($lines as $line)
        {
            $pieces = preg_split('/\|/', $line);
            if(preg_match("/^$username$/", $pieces[1]))
            {
                return true;
            }
        }
    }

    return false;
}
