<?php
if (isset($errors)) {
    if (count($errors) > 0) {
        echo '<ul>';
        foreach ($errors as $value) {
            echo '<li class="errors">' . $value . '</li>';
        }
        echo '</ul>';
    }
}

$name = isset($editData[1]) ? $editData[1] : "";
$cash = isset($editData[2]) ? $editData[2] : "";
$cat = isset($editData[3]) ? $editData[3] : "";
?>
<a href="index.php">Back to list</a>
<div class="expense">
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" name="edit" method="POST">
        <fieldset>
            <legend>Add new expense</legend>
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $name; ?>"/>
            <label for="cash">Cash</label>
            <input type="text" name="cash" id="cash" value="<?php echo $cash; ?>" onchange="updateTextInput(this.value);" onkeypress='validate(event)'/>
            <label for="category">Category:</label>
            <select name="category">
                <option value="0">Select</option>
                <?php
                if (is_array($category)) {
                    foreach ($category as $key => $categories) {
                        $select = stristr($categories[1], $cat) ? "selected" : "";
                        echo '<option value="' . $categories[0] . '" ' . $select . '>' . $categories[1] . '</option>';
                    }
                }
                ?>
            </select>
            <input type="submit" name="submit" value="Add"/>
            <input type="hidden" name="check" value="1"/>
        </fieldset>
    </form>
</div>
<?php
if (isset($success)) {
    echo '<p class="success">Success!!!</p>';
}
?>