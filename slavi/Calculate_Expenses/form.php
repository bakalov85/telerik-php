<?php
mb_internal_encoding('UTF-8');
$pageTitle = 'Expenses Form';
include 'includes/header.php';

if($_POST){
    $name=trim($_POST['name']);
    $name=  str_replace('!', '', $name);
    $sum=trim($_POST['sum']);
	$sum=number_format($sum, 2);
    $sum=  str_replace('!', '', $sum);
    $selectedGroup=(int)$_POST['group'];
	$currentDate = date("m.d.y");
    $error=false;
    if(mb_strlen($name)<2){
        echo '<p>Invalid name!</p>';
        $error=true;
    }
    
    if(!is_numeric($sum)){
        echo '<p>Invalid sum!</p>';
        $error=true;
    }   
	
    if(!array_key_exists($selectedGroup, $groups)){
        echo '<p>Invalid group!</p>';
        $error=true;
    }
    
    if(!$error){
        $result=$currentDate.'!'.$name.'!'.$sum.'!'.$selectedGroup."\n";
        if(file_put_contents('data.txt', $result,FILE_APPEND))
        {
            echo '<p>Expense successfully added!</p>';
        }
    }
    
    
}


?>
<a href="index.php">All Expenses</a>
<form method="POST">
    <div>Name:<input type="text" name="name" /></div>
    <div>Sum:<input type="text" name="sum" /></div>
    <div>
        <select name="group">
            <?php
            foreach ($groups as $key=>$value) {
                echo '<option value="'.$key.'">' . $value .
                        '</option>';
            }
            ?>
        </select>           
    </div>        
    <div><input type="submit" value="Submit" /></div>
</form>
<?php
include 'includes/footer.php';
?>