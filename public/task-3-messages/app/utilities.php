<?php

/**
 * Generate page title
 * @param string $pageTitle
 * @return string
 */
function page_title($pageTitle)
{
    $title = '';
    if ($pageTitle)
    {
        $title .= $pageTitle . $GLOBALS['config']['base_title_separator'];
    }
    $title .= $GLOBALS['config']['base_title'];
    return $title;
}

/**
 * Redirects to file
 * @param type $file
 */
function redirect_to($file, $fileExt = 'php')
{
    header('Location: ' . $file . '.' . $fileExt);
    exit;
}

/**
 * Checks if user is already logined
 * @return type
 */
function is_logined()
{
    return (isset($_SESSION['session_started']) && $_SESSION['session_started']);
}

/**
 * If file consists only alphanumeric and dashes
 * @param string $filename
 * @return boolean
 */
function is_valid_username($username)
{
    $valid = array('_');

    if ($username && ctype_alnum(str_replace($valid, '', $username)))
    {
        return TRUE;
    }
    return FALSE;
}

/**
 * Generate html of errors from array
 * @param array $errors
 * @return string
 */
function display_errors($errors)
{
    $html = '';
    if ($errors)
    {
        $html .= '<div class="errors msg-container">';

        foreach ($errors as $error)
        {
            $html .= '<p class="msg">' . $error . '</p>';
        }

        $html .= '</div>';
    }
    return $html;
}

/**
 * If given string fits in range
 * @param string $str
 * @param integer $min
 * @param integer $max
 * @return boolean
 */
function validate_strlen($str, $min, $max = FALSE)
{
    $length = mb_strlen($str);

    if ($length >= $min && ($max === FALSE || $length <= $max))
    {
        return TRUE;
    }

    return FALSE;
}
