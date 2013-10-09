<?php
/**
 * Creates connection to the database
 * @return source|boolean
 */
function get_connection()
{
    // This variable contains the same value, no matter how many times we call the function
    static $connection;
    $conf = $GLOBALS['config']['db'];

    if ( !$connection) {
        $connection = mysqli_connect($conf['host'], $conf['username'], $conf['password'], $conf['database']);
    }

    if (!mysqli_connect_errno())
      {
        return $connection;
    }

    return FALSE;
}

/**
 * If username is unique through the database
 * @param string $username
 * @return boolean
 */
function is_username_available($username)
{
    $connection = get_connection();

    if ($connection)
    {
        // Escape given username
        $escUsername = mysqli_real_escape_string($connection, $username);

        $sql = 'SELECT `users`.`id` '
                . 'FROM `users` '
                . "WHERE `users`.`username` = \"{$escUsername}\"";

        $query = mysqli_query($connection, $sql);

        // If query is successful an no rows founded
        if ($query && !$query->num_rows)
        {
            return TRUE;
        }
    }
    return FALSE;
}

/**
 * Register new user
 * @param string $username
 * @param string $password
 * @return boolean
 */
function register($username, $password)
{
    $connection = get_connection();

    if ($connection)
    {
        // Escape username and password
        $escUsername = mysqli_real_escape_string($connection, $username);
        $escPassword = mysqli_real_escape_string($connection, $password);

        $sql = 'INSERT INTO `users` '
                . '(`username`, `password`, `date_created`) '
                . "VALUES (\"{$escUsername}\", \"{$escPassword}\", UNIX_TIMESTAMP())";

        // If query was successful
        if (mysqli_query($connection, $sql))
        {
            return TRUE;
        }
    }

    return FALSE;
}

/**
 * Login user
 * @param string $username
 * @param string $password
 * @return boolean
 */
function login($username, $password)
{
    $connection = get_connection();

    if ($connection)
    {
        // Escape username and password
        $escUsername = mysqli_real_escape_string($connection, $username);
        $escPassword = mysqli_real_escape_string($connection, $password);

        $sql = 'SELECT `users`.`id`'
                . 'FROM `users`'
                . "WHERE `users`.`username` = \"{$escUsername}\""
                . "AND `users`.`password` = \"{$escPassword}\"";

        $query = mysqli_query($connection, $sql);

        // If query was successful
        if ($query)
        {
            $user = $query->fetch_assoc();

            // If there is such user, start session
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

/**
 * Get all submitted messages
 * @param boolean $dateAscending
 * @return boolean
 */
function get_messages($dateAscending = TRUE)
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

        // If query was successful
        if ($query)
        {
            $result = array();
            
            // Iterate trough data and humanize it
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

/**
 * Add new message to the database
 * @param string $subject
 * @param string $message
 * @return boolean
 */
function save_message($subject, $message)
{
    $connection = get_connection();

    if ($connection)
    {
        // Escape subject and message body
        $escSubject = mysqli_real_escape_string($connection, $subject);
        $escMessage = mysqli_real_escape_string($connection, $message);

        $sql = 'INSERT INTO `messages` (`user_id`, `subject`, `content`, `date_created`)'
                . "VALUES ({$_SESSION['user_id']}, \"{$escSubject}\", \"{$escMessage}\", UNIX_TIMESTAMP())";

        $query = mysqli_query($connection, $sql);

        // If query is successful
        if ($query)
        {
            return TRUE;
        }
    }

    return FALSE;
}
