<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

$title = 'Добави';
$categories = get_categories();

if ($_POST)
{
    // Normalization
    $label = str_replace($GLOBALS['config']['data_separator'], '', trim($_POST['label']));
    $category = $_POST['category'];
    $cost = round((float) $_POST['cost'], 2);

    $errors = array();

    // Validation
    // Validate label - should be proper length
    if (mb_strlen($label, 'UTF-8') < $GLOBALS['config']['label_min'])
    {
        $errors[] = 'Неподходяща дължина на полето за име на разхода.';
    }

    // Validate category - index should exist
    if (!array_key_exists($category, $categories))
    {
        $errors[] = 'Избрана е несъществуваща категория.';
    }

    // Validate cost - should be positive number
    if ($cost <= 0)
    {
        $errors[] = 'Неправилно форматирана цена';
    }

    // If no errors, proceed to save
    if (!$errors)
    {
        $data = array($label, $category, $cost);
        
        // If save is successfull
        if (save_expense($data))
        {
            $success = 'Успешен запис на "' . $label . '"';
        }
        else
        {
            $errors[] = 'Неуспешен запис на "' . $label . '"';
        }
    }
}
?>

<?php include 'templates/_header.php'; ?>
<div id="left">
    <a href="index.php">Обратно към списъка</a>
</div>

<div id="content">
    <form method="POST">
        <div id="form">
            <label>
                разход:
                <textarea name="label"></textarea>
            </label>
            <p class="info">
                * Име/етикет на направения разход (поне <?= $GLOBALS['config']['label_min']; ?> символа)
            </p>
            <label>
                тип:
<?= input_select('category', $categories); ?>
            </label>
            <p class="info">
                * Тип/категория/група на направения разход
            </p>
            <label>
                сума:
                <input type="number" name="cost" min="0.01" step="0.01" />
            </label>
            <p class="info">
                * Размер на разхода (поне 0.01 валутни единици, точка за разделител)
            </p>
<?php if (isset($errors) && $errors) : ?>
                <div class="errors msg-container">
                    <h1>Неподходящи данни</h1>
                    <?php foreach ($errors as $error): ?>
                        <p class="msg"><?= $error; ?> </p>
                <?php endforeach; ?>
                </div>
<?php elseif (isset($success)): ?>
                <div class="success msg-container">
                    <h1>Успешен запис</h1>
                    <p class="msg"><?= $success; ?> </p>
                </div>
<?php endif; ?>
            <button type="submit">Запиши</button>
        </div>
    </form>
</div>
<?php include 'templates/_footer.php'; ?>