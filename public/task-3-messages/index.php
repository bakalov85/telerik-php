<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

$title = 'Начало';

$menu = array(
    'register.php' => 'Регистрация'
);

if (is_logined())
{
    redirect_to('messages');
}

if ($_POST)
{
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';
    $password = (isset($_POST['password'])) ? $_POST['password'] : '';

    $username = trim($username);

    if (proceed_login($username, $password))
    {
        redirect_to('messages');
    }
    else
    {
        $errors[] = 'Грешен потребител или парола.';
    }
}
?>

<?php include './templates/_header.php'; ?>

<?php include './templates/_left.php'; ?>

<div id="content">
    <p>
        Влезте в системата (<b>user</b> => <b>qwerty</b>), за да можете да използвате пълната функционалност на сайта или се <a href="register">регистрирайте</a>.
    </p>
    <form id="form" method="POST">
        <label>
            Потребител:
            <input type="text" name="username" />
        </label>
        <br />
        <label>
            Парола:
            <input type="password" name="password" />
        </label>
        <br />
        <button type="submit">Вход</button>

        <?php if (isset($errors)) : ?>
            <?= display_errors($errors); ?>
        <?php endif; ?>

        <br />
    </form>
</div>

<?php include './templates/_footer.php'; ?>

