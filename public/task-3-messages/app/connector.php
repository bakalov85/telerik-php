<?php

function get_connection()
{
    $conf = $GLOBALS['config']['db'];
    $connection = mysqli_connect($conf['host'], $conf['username'], $conf['password'], $conf['database']);

    if (!mysqli_connect_errno())
    {
        return $connection;
    }

    return FALSE;
}

function is_username_available($username)
{
    $connection = get_connection();

    if ($connection)
    {
        $escUsername = mysqli_real_escape_string($connection, $username);

        $sql = 'SELECT `users`.`id` '
                . 'FROM `users` '
                . "WHERE `users`.`username` = \"{$escUsername}\"";

        $query = mysqli_query($connection, $sql);

        if ($query && !$query->num_rows)
        {
            return TRUE;
        }
    }
    return FALSE;
}

function register_user($username, $password)
{
    $connection = get_connection();

    if ($connection)
    {
        $escUsername = mysqli_real_escape_string($connection, $username);
        $escPassword = mysqli_real_escape_string($connection, $password);

        $sql = 'INSERT INTO `users` '
                . '(`username`, `password`, `date_created`) '
                . "VALUES (\"{$escUsername}\", \"{$escPassword}\", UNIX_TIMESTAMP())";

        if (mysqli_query($connection, $sql))
        {
            return TRUE;
        }
    }

    return FALSE;
}

function login($username, $password)
{
    $connection = get_connection();

    if ($connection)
    {
        $escUsername = mysqli_real_escape_string($connection, $username);
        $escPassword = mysqli_real_escape_string($connection, $password);

        $sql = 'SELECT `users`.`id`'
                . 'FROM `users`'
                . "WHERE `users`.`username` = \"{$escUsername}\""
                . "AND `users`.`password` = \"{$escPassword}\"";

        $query = mysqli_query($connection, $sql);

        if ($query)
        {
            $user = $query->fetch_assoc();

            if ($user)
            {
                $_SESSION['session_started'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user['id'];
                return TRUE;
            }
        }
    }
    return FALSE;
}

function get_messages($dateAscending = FALSE)
{
    $connection = get_connection();

    if ($connection)
    {
        $sort = ($dateAscending) ? 'ASC' : 'DESC';
        $sql = 'SELECT `messages`.*, `users`.`username` '
                . 'FROM `messages` '
                . 'LEFT JOIN `users`'
                . 'ON `messages`.`user_id` = `users`.`id`'
                . "ORDER BY `messages`.`date_created` {$sort}";

        $query = mysqli_query($connection, $sql);

        if ($query)
        {
            $result = array();

            while ($row = $query->fetch_assoc())
            {
                // Escape scpecial chars
                $resultRow['subject'] = htmlspecialchars($row['subject']);
                $resultRow['content'] = htmlspecialchars($row['content']);
                $resultRow['date'] = date($GLOBALS['config']['date_format'], $row['date_created']);
                $resultRow['user'] = $row['username'];
                $result[] = $resultRow;
            }

            return $result;
        }
    }
    return FALSE;
}

function save_message($subject, $message)
{
    $connection = get_connection();

    if ($connection)
    {
        $escSubject = mysqli_real_escape_string($connection, $subject);
        $escMessage = mysqli_real_escape_string($connection, $message);

        $sql = 'INSERT INTO `messages` (`user_id`, `subject`, `content`, `date_created`)'
                . "VALUES ({$_SESSION['user_id']}, \"{$escSubject}\", \"{$escMessage}\", UNIX_TIMESTAMP())";

        $query = mysqli_query($connection, $sql);

        if ($query)
        {
            return TRUE;
        }
    }

    return FALSE;
}
