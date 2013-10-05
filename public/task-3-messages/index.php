<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

if (is_logined())
{
    redirect_to('messages');
}

$title = 'Начало';

$menu = array(
    'register.php' => 'Регистрация'
);

if ($_POST)
{
    // Get post variables
    $username = (isset($_POST['username'])) ? $_POST['username'] : '';
    $password = (isset($_POST['password'])) ? $_POST['password'] : '';

    // Normalize data
    $username = trim($username);

    // Try to login
    if (login($username, $password))
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
        Влезте в системата, за да можете да използвате пълната функционалност на сайта или се <a href="register.php">регистрирайте</a>.
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

