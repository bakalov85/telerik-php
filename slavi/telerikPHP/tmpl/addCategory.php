<?php
if (isset($error)) {
    echo '<p class="errors">' . $error . '</p>';
}
?>
<a href="index.php">Back to list</a>
<div class="expense">
    <form action="index.php?view=addCategory&task=addCategory" name="edit" method="POST">
        <fieldset>
            <legend>Add new category</legend>
            <label for="category">Category name:</label>
            <input type="text" name="category" value=""/>
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