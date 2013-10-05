<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

$title = 'Регистрация';

$menu = array(
    'index.php' => 'Вход'
);

if ($_POST)
{
//    if (isset())
    $username = trim(@$_POST['username']);
    $password = trim(@$_POST['password']);
    $passwordConfirm = trim(@$_POST['password2']);

    $usernameLength = mb_strlen($username);
    $passwordLength = mb_strlen($password);

    if ($usernameLength < $GLOBALS['config']['min_username'] || $usernameLength > $GLOBALS['config']['max_username'])
    {
        $errors[] = "Потребителското име трябва да е с дължина между {$GLOBALS['config']['min_username']} и {$GLOBALS['config']['max_username']} символа.";
    }

    if ($passwordLength < $GLOBALS['config']['min_password'] || $passwordLength > $GLOBALS['config']['max_password'])
    {
        $errors[] = "Паролата трябва да е с дължина между {$GLOBALS['config']['min_password']} и {$GLOBALS['config']['max_password']} символа.";
    }

    if (!is_valid_username($username))
    {
        $errors[] = 'Потребителското име трябва да съдържа само латински букви, цифри или долно тире.';
    }

    if (!is_username_available($username))
    {
        $errors[] = "Потребителското име \"{$username}\" вече е заето, моля изберете различно име.";
    }

    if ($password != $passwordConfirm)
    {
        $errors[] = 'Паролите не съвпадат.';
    }

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
