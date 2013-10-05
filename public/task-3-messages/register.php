<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

if (is_logined())
{
    redirect_to('messages');
}

$title = 'Регистрация';

$menu = array(
    'index.php' => 'Вход'
);

if ($_POST)
{
    // Get post variables
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';
    $password = (isset($_POST['password'])) ? $_POST['password'] : '';
    $passwordConfirm = (isset($_POST['password2'])) ? $_POST['password2'] : '';

    // Normalize data
    $username = trim($username);
    $password = trim($password);
    $passwordConfirm = trim($passwordConfirm);

    // Validate length
    if (!validate_strlen($username, $GLOBALS['config']['min_username'], $GLOBALS['config']['max_username']))
    {
        $errors[] = "Потребителското име трябва да е с дължина между {$GLOBALS['config']['min_username']} и {$GLOBALS['config']['max_username']} символа.";
    }

    if (!validate_strlen($password, $GLOBALS['config']['min_password'], $GLOBALS['config']['max_password']))
    {
        $errors[] = "Паролата трябва да е с дължина между {$GLOBALS['config']['min_password']} и {$GLOBALS['config']['max_password']} символа.";
    }

    // Validate characters
    if (!is_valid_username($username))
    {
        $errors[] = 'Потребителското име трябва да съдържа само латински букви, цифри или долно тире.';
    }

    // Check if username is available
    if (!is_username_available($username))
    {
        $errors[] = "Потребителското име \"{$username}\" вече е заето, моля изберете различно име.";
    }

    // Whether passwords match
    if ($password != $passwordConfirm)
    {
        $errors[] = 'Паролите не съвпадат.';
    }

    // If there are not errors, try to register
    if (!isset($errors))
    {
        if (register_user($username, $password))
        {
            redirect_to('index');
        }
        else
        {
            $errors[] = 'Неуспешна регистрация, моля опитайте отново.';
        }
    }
}
?>
<?php include './templates/_header.php'; ?>

<?php include './templates/_left.php'; ?>

<div id="content">
    <form method="POST" id="form">
        <label>
            Потребителско име: 
            <input type="text" name="username" value="<?= (isset($username)) ? $username : ''; ?>"/>
        </label>
        <p class="info">
            * Минимум пет символа (латински букви, цифри или тире)
        </p>
        <br />
        <label>
            Парола: 
            <input type="password" name="password" />
        </label>
        <p class="info">
            * Минимум пет символа
        </p>
        <br />
        <label>
            Повторно парола:
            <input type="password" name="password2" />
        </label>
        <br />
        <button type="submit">Регистрирай</button>
    </form>

    <?php if (isset($errors)): ?>
        <?= display_errors($errors); ?>
    <?php endif; ?>
</div>

<?php include './templates/_footer.php'; ?>
