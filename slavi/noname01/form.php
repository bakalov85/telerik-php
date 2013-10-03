<?php
$pageTitle = 'input';
include './includes/header.php';
require './includes/constants.php';
$error = FALSE;

if ($_POST) {
    $date = date('d.m.Y');

    $name = trim($_POST['name']);
    $name = str_replace('!', '', $name);

    $cost = (trim($_POST['sum']));
    $cost = floatval(str_replace('!', '', $cost));
	
	

    $expenseGroup = (int) $_POST['expenses'];

    if ((mb_strlen($name) < 2) || (mb_strlen($name) > 20 )) {
        echo 'the name must be at least 2 characters(max20)';
        $error = true;
    }

    if ($cost <= 0) {
        echo 'invalid price';
        $error = true;
    }

    if (!array_key_exists($expenseGroup, $expenseTypes)) {
        $error = true;
    }

    if (!$error) {
        $record = $date . '!' . $name . '!' . $cost . '!' . $expenseGroup . "\n";
        file_put_contents('record.txt', $record, FILE_APPEND);
        echo "entry successfully saved";
    }
}
?>

<div>
<a href="index.php">expenses list</a>

<form method="POST">
<div>
<label for="name">name: </label>
<input type="text" name="name">
</div>
<div>
<label for="sum">sum: </label>
<input type="text" name="sum">
</div>
<div>
<label for="expenses">type: </label>
<select name="expenses" >
<?php
                foreach ($expenseTypes as $key => $value) {
                    if ($key == 0) {
                        continue;
                    }
                    echo '<option value="' . $key . '">' . $value . '</option>';
                }
                ?>
</select>
</div>
<div>
<input type="submit" name="add" value="add">
</div>
</form>
</div>
<?php
include './includes/footer.php';
?>