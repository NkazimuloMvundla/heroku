<?php

include "../common.php";


echo "<div class='hidden-lg hidden-md' id='featured-products'>
<h2 class='featured'>Trending <b>Products</b></h2>
<div class='row w3-margin-top'>
<?php

while($parent = $sql2->fetch(PDO::FETCH_ASSOC)):
$parent_id =  filterInt($parent['pd_id']);
$user_id = filterInt($parent['pd_u_id']);
?>

<?php
$sql3= $pdo->prepare('SELECT * FROM photo WHERE ph_photo_id = ? ORDER BY RAND()') ;
$sql3->bindParam(1, $parent_id ,PDO::PARAM_INT);
$sql3->execute();
$data = $sql3->fetch(PDO::FETCH_ASSOC);
?>

<div class='row-1 col-xs-6 col-md-2 w3-padding'>
<a href='products.php?p=<?php echo filterInt($parent_id );?>'>

<img src='<?php echo filterString($data['ph_fileName']);?>' >


<div class='row'>
<p><a href='products.php?p=<?php echo filterInt($parent_id) ;?>'><?php echo filterString($parent['pd_name']);?></a></p>
<a href='contact-supplier.php?p=<?php echo filterInt($parent_id );?> & u=<?php echo filterInt($user_id ); ?>'><span class='btn btn-success btn-sm w3-hide'  name='contact-now' style='margin-top:6px;'><span style='font-size: 10pt'>Contact Now</span></span></a>
<p class='minimum-order'>MOQ : <?php echo filterInt($parent['pd_min_order_qty']);?></p>

</div>
</a>
</div>
<?php endwhile; ?>
</div>


</div>	
";


?>