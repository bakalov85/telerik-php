<?php

function is_username_available($username)
{
    return TRUE;
}

function register_user()
{
    return TRUE;
}

function proceed_login($username, $password)
{
    $_SESSION['session_started'] = true;
    $_SESSION['username'] = $username;
    return FALSE;
    return TRUE;
}
