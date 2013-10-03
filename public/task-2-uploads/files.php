<?php
include './app/config.php';
include './app/utilities.php';

$title = 'Списък';

if (!is_logined())
{
    redirect_to('index');
}

$dirPath = get_user_dir_path();

if (isset($_GET['filename']))
{
    $filename = basename($_GET['filename']);
    
    download_file(get_user_file_path($filename));
    exit;
}

$contents = get_dir_files($dirPath);

if ($contents)
{
    $list = generate_files_data($contents, $dirPath);
}
else
{
    $errors[] = 'Няма качени файлове.';
}
?>


<?php include './templates/_header.php'; ?>

<?php include './templates/_left.php'; ?>

<div id="content">
    <p>Списък с качените файлове на потребителя.</p>

    <table>
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Име
                </th>
                <th>
                    Размер
                </th>
                <th>
                    Дата
                </th>
                <th>
                    Сваляне
                </th>
            </tr>
        </thead>
        <?php if (isset($list) && $list): ?>
            <?php foreach ($list as $file): ?>
                <tr>
                    <td>
                        <?= $file['index'] ?>
                    </td>
                    <td>
                        <?= $file['name']; ?>
                    </td>
                    <td>
                        <?= $file['size']; ?> байта
                    </td>
                    <td>
                        <?= $file['date']; ?>
                    </td>
                    <td>
                        <form method="GET">
                            <input type="hidden" name="filename" value="<?= $file['name']; ?>" />
                            <button type="submit">Скачать</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="msg">
                    Няма качени файлове.
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<?php include './templates/_footer.php'; ?>