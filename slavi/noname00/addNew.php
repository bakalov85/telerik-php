<?php
include './type.php';
?>
<a href="index.php">List</a><br />
<?php
 if($_POST)
 {
    $name=trim($_POST['name']);
     $sum=trim($_POST['sum']);
    if(strlen($name)>3 && strlen($sum)>0)
    {
        $date = date("d.m.Y");
        $type=trim($_POST['type']);
        $temp= 'date:'.$date.'|type:'.$type.'|name:'.$name.'|sum:'.$sum.'|';
        file_put_contents('data.txt',$temp."\n",FILE_APPEND);
        echo'Saved';
    }
    if(strlen($name)<=3)
    {
      echo'The name must be at least 3 characters!';
    }
    if(strlen($sum)<=0)
    {
       echo'The sum must be a positive number!'; 
    }
 }
?>
<form method="post" action="addNew.php"> 
Name:<input type="text" name="name"><br>
Sum:<input type="text" name="sum"><br>
Type: <?php typesList($type1); ?><br />
<input type="submit" value="Add">
</form>
<?php
