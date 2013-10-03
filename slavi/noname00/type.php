<?php
$type1= array(0=>'All', 1=>'Food&Drinks', 2=>'Bills',3=>'Sport', 4=>'Clothes', 5=>'Other',);
function typesList($type1, $add=0)
{
    ?>
<select name="type">
<?php
                foreach($type1 as $key=>$value)
                {
                    if($add == 0 && $key == 0)
                    {
                        continue;
                    }
                    if((int)$_POST['type'] == $key)
                    {
                        echo "<option value=$key selected='selected'>$value</option>";
                    }
                    else
                    {
                        echo "<option value=$key>$value</option>";
                    }
                }
            ?>
</select>
<?php
}
?>