<?php
$pageTitle='Списък';
include 'includes/header.php';

?>
<a href="form.php">Add new expense</a>
<form method="POST">
	<select name="group">
		<?php
		echo '<option value="0">All</option>';
		foreach ($groups as $key=>$value) {
			echo '<option value="'.$key.'">' . $value .
					'</option>';
		}
		?>
	</select>
	<input type="submit" value="Filter" />
</form>
<table border="1">
    <tr>
        <th>Date</th>
        <th>Name</th>
        <th>ExpenseType</th>
        <th>Sum</th>
    </tr>
    <?php
	
	if(file_exists('data.txt')){
		$result=  file('data.txt');
		$sum=0;
		$selectedGroup = 0;
        if ($_POST) {
            $selectedGroup = (int) $_POST['group'];
        }
		foreach ($result as $value) {
			$columns=  explode('!', $value);
			if($selectedGroup != $columns[3] && $selectedGroup != 0){
				continue;
			}
			$sum+= $columns[2];	
			echo '<tr>
				<td>'.$columns[0].'</td>
				<td>'.$columns[1].'</td>
				<td>'.$groups[trim($columns[3])].'</td>
				<td>'.$columns[2].'</td>
				</tr>';
		}
	}
	$sum=number_format($sum, 2);
	echo '<tr>
			<td colspan=4><strong>Total</strong>:  '.$sum.'</td>
		  </tr>';
    
    ?>

    
</table>
<?php
include 'includes/footer.php';
?>
