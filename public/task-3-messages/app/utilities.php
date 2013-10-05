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
 * Gets all registered users
 * @return array
 */
function get_users()
{
    $usersData = file($GLOBALS['config']['users_path']);

    $users = array();

    foreach ($usersData as $userData)
    {
        $userArray = explode($GLOBALS['config']['data_separator'], trim($userData));
        $users[$userArray[0]] = $userArray[1];
    }

    return $users;
}

/**
 * Checks if login is successful
 * @param string $username
 * @param string $password
 * @return boolean
 */
function is_valid_login($username, $password)
{
    $users = get_users();

    if (isset($users[$username]) && $users[$username] == md5($password))
    {
        return TRUE;
    }
    return FALSE;
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
 * Gets files in given folder
 * @param string $dir
 * @return array|boolean
 */
function get_dir_files($dir)
{
    if (is_dir($dir))
    {
        $contents = scandir($dir);
    }

    if (isset($contents) && count($contents) > 2)
    {
        return array_slice($contents, 2);
    }

    return FALSE;
}

/**
 * Generates human readable file data
 * @param type $fileList
 * @param type $dir
 * @return array
 */
function generate_files_data($fileList, $dir = '')
{
    $list = array();

    foreach ($fileList as $i => $f)
    {
        $file = $dir . DIRECTORY_SEPARATOR . $f;

        $fileData['index'] = $i + 1;
        $fileData['name'] = $f;
        $fileData['date'] = date('d-m-Y', filemtime($file));
        $fileData['size'] = number_format(filesize($file), 0, '.', ' ');
        $fileData['url'] = '';

        array_push($list, $fileData);
    }

    return $list;
}

/**
 * 
 * @return string
 */
function get_user_dir_path()
{
    return $GLOBALS['config']['files_path'] . DIRECTORY_SEPARATOR . $_SESSION['username'];
}

/**
 * @param string $filename
 * @return string
 */
function get_user_file_path($filename)
{
    return get_user_dir_path() . DIRECTORY_SEPARATOR . $filename;
}

/**
 * Downloads file
 * @author marro <marro@email.cz>
 * @link http://www.php.net/manual/en/function.readfile.php#81925
 * @param string $file
 */
function download_file($file)
{ // $file = include path 
    if (file_exists($file))
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        return true;
    }
    return false;
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
