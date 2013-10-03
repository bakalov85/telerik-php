<div class="menu">
    <div class="action">
        <a href="index.php?view=addExpense" class="new">Add new expense</a>
        <span>|</span>
        <a href="index.php?view=addCategory" class="new">Add new category</a>
    </div>
    <?php 
    $dateFilter = isset($dateFilter)?$dateFilter:"";
    ?>
    <form name="filter" action="index.php?task=filter" method="POST" class="filter">
        Date: <input type="text" name="dateFilter" id="datepicker" value="<?php echo $dateFilter; ?>"/>
        <select name="category">
            <option value="null">All</option>
            <?php
            if (is_array($category)) {
                foreach ($category as $key => $categories) {
                    $filterSelected = isset($filter) && $filter == trim($categories[1]) ? "selected" : "";
                    echo '<option value="' . $categories[1] . '" ' . $filterSelected . '>' . $categories[1] . '</option>';
                }
            }
            ?>
        </select>
        <input type="submit" value="Филтрирай" name="submit"/>
    </form>
</div>
<div class="custTable">
    <table>
        <?php
        if (isset($listing) && is_array($listing) && !empty($listing)) {

            echo '
        <tr>
        <th>Date</th>
        <th>Name</th>
        <th>Cash</th>
        <th>Category</th>
        <th></th>
        <th></th>
        </tr>';

            $countItems = 1;
            foreach ($listing as $value) {
                $class = (($countItems % 2) == 0) ? 'class="odd"' : '';
                echo '<tr ' . $class . '>';
                echo '<td>' . $value[4] . '</td>';
                echo '<td>' . $value[1] . '</td>';
                echo '<td class="price">' . $value[2] . '</td>';
                echo '<td>' . $value[3] . '</td>';
                echo '<td><a href = "index.php?view=addExpense&task=edit&id=' . $value[0] . '">Edit</a></td>';
                echo '<td><a href = "index.php?task=remove&id=' . $value[0] . '">Remove</a></td>';
                echo '</tr>';
                $countItems++;
            }
            echo '<td>----</td><td>----</td><td class="sumResult"></td><td>----</td><td>----</td><td>----</td>';
        } else {
            echo '<p>Empty listing.</p>';
        }
        ?>
    </table>
</div>