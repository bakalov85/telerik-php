<div id="left">
    <ul>
        <?php if (isset($_SESSION['session_started']) && $_SESSION['session_started']): ?>
            <li>
                <a href="upload.php">Качи файл в облака</a>
            </li>
            <li>
                <a href="files.php">Прегледай облака</a>
            </li>
            <li>
                <a href="logout.php">Изход <b><?= $_SESSION['username']; ?></b></a>
            </li>
        <?php endif; ?>
    </ul>
</div>