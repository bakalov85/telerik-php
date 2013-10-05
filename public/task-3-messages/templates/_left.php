<div id="left">
    <ul>
        <?php if (isset($menu)) : ?>
            <?php foreach ($menu as $url => $caption) : ?>
                <li>
                    <a href="<?= $url; ?>"><?= $caption; ?></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>