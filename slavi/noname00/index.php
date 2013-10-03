<?php
include './type.php';
{
echo '<a href="addNew.php">Add New</a><br>' 
?>
<form method="post" action="index.php"> 
<?php typesList($type1,[0]); ?> <input type="submit" value="Filter">
</form>
<?php
$expenses=file('data.txt');
echo'<table border=1>
    <tr><td>Date</td><td>Name</td><td>Type</td><td>Sum<td></tr>';
foreach ($expenses as $value)
{
    $tmp=  explode('|', $value);
    foreach ($tmp as $value1)
    {
        $tmp2=  explode(':', $value1);
        if ($tmp2[0]=='date')
        {
            $date=$tmp2[1];
        }
        
        elseif ($tmp2[0]=='name')
        {
            $name=$tmp2[1];
        }
        elseif ($tmp2[0]=='type')
        {
            $type=$tmp2[1];

        }
        elseif ($tmp2[0]=='sum')
        {
            $sum=$tmp2[1];
            $total+=(float)$tmp2[1];
        }
     }
    echo'<tr><td>'.$date.'</td><td>'.$name.'</td><td>'.$type.'</td><td>'.$sum.'</td><td>';
}
echo'</table>';
echo 'Total : ',$total;
}
?>
