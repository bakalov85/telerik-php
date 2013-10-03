<?php
mb_internal_encoding('UTF-8');
$pageTitle='Add new expense';
include 'includes/header.php';
$date=date("d.m.Y");
$groups=array(1=>'Food',2=>'Clothes',3=>'Transport',4=>'Education',5=>'Medicines',6=>'Holiday',7=>'Others');
$error=false;
if($_POST){
    $name=trim($_POST['name']);
    $name=str_replace('!', '', $name);
    $price=trim($_POST['price']);
    $price=str_replace('!', '', $price);
    $selectedGroup=(int)$_POST['kind'];
    
    if(mb_strlen($name)<4){
        echo '<p>Name is too short!</p>';
        $error=true;
    }
    if(mb_strlen($price<=0)&&$price<=0){
        echo '<p>Not valid price!</p>';
        $error=true;
    }
    if(!array_key_exists($selectedGroup, $groups)){
        echo '<p>Not valid group!</p>';
        $error=true;
    }
    if(!$error){
        $result=$name.'!'.$price.'!'.$selectedGroup.'!'.$date."\n";
        if(file_put_contents('data.txt', $result,FILE_APPEND)){
            
        }
    }
}
?>
<a href="index.php">Expenses</a>
<form method="POST">    
    <div>Name:<input type="text" name="name" /></div>
    <div>Price BGN:<input type="text" name="price" /></div>
    <div>
        <select name="kind">
            <?php
            foreach ($groups as $key=>$value){
                echo '<option value="'.$key.'">'.$value.'</option>';
            }
            ?>
        </select>
    </div>
    <div><input type="submit" value="Add" /></div>
</form>
<?php
include 'includes/footer.php';
?>
