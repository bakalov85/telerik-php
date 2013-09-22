<?php
include './app/config.php';
include './app/utilities.php';
include './app/connector.php';

$title = 'Списък';
$categories = get_categories();

$data = get_expenses();
$options = array('' => 'всички') + $categories;
$defaultOption = NULL;


// If there is filter rule set
if (isset($_GET['filter']))
{
    $filter = (int) $_GET['filter'];

    // Apply filter only if category exists
    if (array_key_exists($filter, $categories))
    {
        $filteredExpenses = filter_data($data, $filter);
        $defaultOption = $filter;
    }
}

// If there is no filter applied, $filteredExpenses is actually all data
if (!isset($filteredExpenses))
{
    $filteredExpenses = $data;
}

$totalNumber = count($filteredExpenses);
$totalCost = calc_total_cost($filteredExpenses);

// Convert model data to human readable
$expenses = humanize_expense_data($filteredExpenses, $categories);
?>

<?php include './templates/_header.php'; ?>
<div id="left">
    Общ брой разходи: <?= $totalNumber; ?> <br />
    Общ размер разходи: <?= humanize_price($totalCost); ?> <br />
    <hr />
    <form>
        <?= input_select('filter', $options, $defaultOption); ?>
        <button type="submit">Филтрирай</button>
    </form>
    <hr />
    <a href="create.php">Добави нов разход</a>
</div>
<div id="content">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Разход</th>
                <th>Тип</th>
                <th>Сума</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($expenses) : ?>
                <?php foreach ($expenses as $index => $expense) : ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <?php foreach ($expense as $cell) : ?>
                            <td><?= $cell; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="msg">Скръндза! Все още няма похарчено :( </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include 'templates/_footer.php'; ?>