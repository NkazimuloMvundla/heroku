
<?php

include "../common.php";



/*

$sql= "SELECT * FROM `product_category` WHERE pc_status = ? and pc_parent_id = ?  order by pc_name";
$stmt= $pdo->prepare($sql);
$stmt->bindValue(1, 1,PDO::PARAM_INT);
$stmt->bindValue(1, $parentID,PDO::PARAM_INT);
$stmt->execute();
*/
if(isset($_POST['id']))
$id=$_POST['id'];




$sql= "SELECT * FROM `product_category` WHERE pc_status = ? and pc_parent_id = ?  ";
$stmt= $pdo->prepare($sql);
$stmt->bindValue(1, 1,PDO::PARAM_INT);
$stmt->bindValue(2, $id,PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->rowCount();




$disp='';







if($count > 0){
  while($row=$stmt->fetch(PDO::FETCH_OBJ))
{
    $disp .= '<option value="' . htmlspecialchars($row->pc_id) . '"';

    /* Disable the option if the time is used */
    if ($row->pc_id == $id )
    {
        $disp .= ' selected="selected"';
    }

    $disp .= '>' . htmlspecialchars(ucfirst($row->pc_name)) . '</option>';
}
}else{
    echo '<option>Categories not available</option>';
}










$sql_c= "SELECT * FROM `product_category` WHERE pc_status = ? and pc_id = ?  ";
$st= $pdo->prepare($sql_c);
$st->bindValue(1, 1,PDO::PARAM_INT);
$st->bindValue(2, $id,PDO::PARAM_INT);
$st->execute();
$row_c = $st->fetch(PDO::FETCH_OBJ);
echo $disp.'|'.ucfirst($row_c->pc_name);





 ?>



















?>