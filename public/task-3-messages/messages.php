<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

if ( !is_logined())
{
    redirect_to('index');
}

$title = 'Съобщения';

$menu = array(
    'new.php' => 'Ново съобщение',
    'logout.php' => "Изход <b>{$_SESSION['username']}</b>",
);

$list = get_messages();
?>

<?php include './templates/_header.php'; ?>

<?php include './templates/_left.php'; ?>

<div id="content">
    <table>
        <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Заглавие
                </th>
                <th>
                    Потребител
                </th>
                <th>
                    Дата
                </th>
                <th>
                    Прочети
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($list)) : ?>
                <?php foreach ($list as $index => $msg) : ?>

                    <tr>
                        <td>
                            <?= $index + 1; ?>
                        </td>
                        <td>
                            <?= $msg['subject']; ?>
                        </td>
                        <td>
                            <?= $msg['user']; ?>
                        </td>
                        <td>
                            <?= $msg['date']; ?>
                        </td>
                        <td>
                            <a href="#" class="preview">Преглед</a>
                            <div class="preview-container">
                                <?= $msg['content']; ?>
                            </div>
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php elseif ($list !== FALSE): ?>

                <tr>
                    <td colspan="5" class="msg">Няма качени съобщения в системата.</td>
                </tr>

            <?php else: ?>

                <tr>
                    <td colspan="5" class="msg">Възникна грешка, опитайте по-късно.</td>
                </tr>

            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include './templates/_footer.php'; ?>