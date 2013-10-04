<?php
include './app/config.php';
include './app/utilities.php';

$title = 'Качи';

if (!is_logined())
{
    redirect_to('index');
}

if ($_POST && $_FILES)
{
    $filename = (isset($_POST['filename']) && $_POST['filename']) ? trim($_POST['filename']) : trim($_FILES['file']['name']);

    $filename = str_replace(array('../', './'), '', $filename);
    
    if (strlen($filename) > $GLOBALS['config']['max_filename'])
    {
        $errors[] = 'Името на файла трябва да е не по-дълго от ' . $GLOBALS['config']['max_filename'];
    }

    if (!is_valid_filename($filename))
    {
        $errors[] = 'Името на файла трябва да съдържа само цифри, латински букви и/или тирета.';
    }

    if (!isset($errors))
    {
        if ($_POST['filename'])
        {
            $filename .= '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        }
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], get_user_file_path($filename)))
        {
            $success = 'Файла <b>' . $filename . '</b> е успешно качен!';
        }
        else
        {
            $errors[] = 'Неуспешен запис на файла <b>' . $filename . '</b>.';
        }
    }
}
?>

<?php include './templates/_header.php'; ?>
<?php include './templates/_left.php'; ?>

<div id="content">

    <form id="form" method="POST" enctype="multipart/form-data">
        <label>
            Име:
            <input type="text" name="filename">
        </label>
        <p class="info">
            * Незадължително поле, до <?= $GLOBALS['config']['max_filename']; ?> латински символа, тирета и цифри.
        </p>
        <label>
            Файл:
            <input type="file" name="file">
        </label>
        <p class="info">
            * Максимален размер от 8 МВ.
        </p>
        <br />
        <button type="submit">Изпрати</button>
    </form>

    <?php if (isset($errors)) : ?>
        <div class="errors msg-container">
            <?php foreach ($errors as $error): ?>
                <p class="msg">
                    <?= $error; ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <div class="success msg-container">
            <p class="msg">
                <?= $success; ?>
            </p>
        </div>
    <?php endif; ?>
</div>
<?php include './templates/_footer.php'; ?>
