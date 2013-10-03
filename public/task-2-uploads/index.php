<?php
include './app/config.php';
include './app/utilities.php';

$title = 'Начало';

if (is_logined())
{
    redirect_to('files'); 
}

if (isset($_POST['username']) || isset($_POST['password']))
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (is_valid_login($username, $password))
    {
        $_SESSION['session_started'] = true;
        $_SESSION['username'] = $username;
        redirect_to('files');
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
        Здравейте <b>потребител</b>, влезте с потребителското си име (<b>user</b>) и парола (<b>qwerty</b>), за да използвате пълната функционалност на сайта.        
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
            <div class="errors msg-container">
                <?php foreach ($errors as $error): ?>
                    <p class="msg">
                        <?= $error; ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </form>
</div>

<?php include './templates/_footer.php'; ?>

