<?php
mb_internal_encoding('UTF-8');
$pageTitle='Expenses';
include 'includes/header.php';
$groups=array(1=>'Food',2=>'Clothes',3=>'Transport',4=>'Education',5=>'Medicines',6=>'Holiday',7=>'Others');
$sum=0;
?>
<a href="list.php">Add new expense</a>
<button>Filter</button>
<table>
    <tr>
        <td>Name</td>
        <td>Kind</td>
        <td>Price BGN</td>
        <td>Date</td>
    </tr>
<?php
    if(file_exists('data.txt')){
    $result=file('data.txt');
    foreach ($result as $value){
        $columns= explode('!', $value);
        echo '<tr>
                <td>'.$columns[0].'</td>
                <td>'.$groups[trim($columns[2])].'</td>
                <td>'.$columns[1].'</td>
                <td>'.$columns[3].'</td>
             </tr>';
        $sum += $columns[1];
    }
}
?>
    <tr>
        <td></td>
        <td></td>
        <?php echo '<td>'.$sum.'</td>' ?>
        <td></td>
    </tr>
</table>
<?php
include 'includes/footer.php';      
?>