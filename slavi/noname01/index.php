<?php

$pageTitle = 'expenses';
include './includes/header.php';
require './includes/constants.php';

?>

<div>
 <a href="form.php">add new expense</a>
   <form method="POST">
   <select name="filter" >
    <?php
            foreach ($expenseTypes as $key => $value) {
             echo '<option value="' . $key . '">' . $value . '</option>';
            }
    ?>

   </select>
   <input type="submit" value="filter" />
   </form>
</div>
    <table border="1">
    <thead>
    <tr>
    <th>date</th>
    <th>name</th>
    <th>sum</th>
    <th>type</th>
    </tr>
    </thead>

    <tbody>
    <tr>

<?php
            if (file_exists('record.txt')) {
                $recordedData = file('record.txt');
                if ($_POST) {
                    $selectedFilter = (int) $_POST['filter'];
                }
                foreach ($recordedData as $value) {
                    $colums = explode('!', $value);

                    if (($selectedFilter != 0) && ($selectedFilter != (trim($colums[3])))) {
                        continue;
                    }
                    echo '<tr>
                           <td>' . $colums[0] . '</td>
                           <td>' . $colums[1] . '</td>
                           <td>' . $colums[2] . '</td>
                           <td>' . $expenseTypes[trim($colums[3])] . '</td>
                          </tr>';
                          $total+= $colums[2];
                    }
                 }
?>
 </tr>
 </tbody>
 <tfoot>
 <tr>
 <td colspan="4">
<?php
        echo'total: ' . $total . ' lv.';
?>
 </td>
 </tr>
 </tfoot>
 </table>
<?php
 include './includes/footer.php';
?>