<?php

include "../common.php";

$id=$_POST['id'];

$sql="select s.pc_id pd_pc_id,m.pc_name mc_name,c.pc_name c_name,s.pc_name sc_name from product_category m,product_category c,product_category s where s.pc_id='".$id."' and m.pc_id=c.pc_parent_id and c.pc_id=s.pc_parent_id";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

$disp=ucfirst($row->mc_name)." >> ".ucfirst($row->c_name)." >> ".ucfirst($row->sc_name);
echo $disp;

?>