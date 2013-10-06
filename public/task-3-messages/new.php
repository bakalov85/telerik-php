<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

if (!is_logined())
{
    redirect_to('index');
}

$title = 'Ново съобщение';

$menu = array(
    'messages.php' => 'Съобщения',
    'logout.php' => "Изход <b>{$_SESSION['username']}</b>",
);

if ($_POST)
{
    // Get post variables
    $subject = (isset($_POST['subject'])) ? $_POST['subject'] : '';
    $message = (isset($_POST['message'])) ? $_POST['message'] : '';

    // Normalize data
    $subject = trim($subject);
    $message = trim($message);

    // Validate string length
    if (!validate_strlen($subject, $GLOBALS['config']['min_subject'], $GLOBALS['config']['max_subject']))
    {
        $errors[] = "Заглавието трябва да е между {$GLOBALS['config']['min_subject']} и {$GLOBALS['config']['max_subject']} символа.";
    }

    if (!validate_strlen($subject, $GLOBALS['config']['min_message'], $GLOBALS['config']['max_message']))
    {
        $errors[] = "Съобщението трябва да е между {$GLOBALS['config']['min_message']} и {$GLOBALS['config']['max_message']} символа.";
    }

    // If no errors, try to save the message
    if (!isset($errors))
    {
        if (save_message($subject, $message))
        {
            redirect_to('messages');
        }
        else
        {
            $errors[] = 'Неуспешен запис, опитайте по-късно.';
        }
    }
}
?>

<?php include './templates/_header.php'; ?>

<?php include './templates/_left.php'; ?>

<div id="content">

    <form method="POST" id="form">
        <label>
            Заглавие:
            <input type="text" name="subject" value="<?= (isset($subject)) ? $subject : ''; ?>"/>
        </label>
        <p class="info">
            * Дължина от 1 до 50 символа
        </p>
        <br />
        <label>
            Съобщение:
            <textarea type="text" name="message"><?= (isset($message)) ? $message : ''; ?></textarea>
        </label>
        <p class="info">
            * Дължина от 1 до 250 символа
        </p>
        <br />
        <button type="submit">Изпрати</button>
    </form>

    <?php if (isset($errors)) : ?>
        <?= display_errors($errors); ?>
    <?php endif; ?>

</div>

<?php include './templates/_footer.php'; ?>
