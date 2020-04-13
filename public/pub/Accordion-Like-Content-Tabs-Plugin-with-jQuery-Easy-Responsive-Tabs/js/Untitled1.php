<?php





$sql= $pdo->prepare('SELECT * FROM product_category WHERE pc_parent_id  = ? ORDER BY `product_category`.`pc_name` ASC') ;
$sql->bindValue(1, 0,PDO::PARAM_INT);
$sql->execute();


/*while($stmt = $sql->fetch(PDO::FETCH_ASSOC))
{

 echo $stmt['pc_name'] . '</br>';

}
*/
?>


<div class="page-wrapper" id="main">
<div class="container w3-center w3-border w3-border-blue w3-padding w3-hide-small w3-hide-meduim ">

<div class="row w3-display-container">
<div class="col-md-6">
<div class="w3-diplay-container">
<p class="text-primary" style="font-size:24px;">Fill a buying request and get quotes:</p>
<table class="table table-bordered w3-centered">
<thead>
<tr class="info ">
<th>No</th>
<th>Quantity</th>
<th>Price/Unit</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td>8000</td>
<td>ZAR R400</td>
</tr>
<tr>
<td>2</td>
<td>500</td>
<td>ZAR R600</td>
</tr>
<tr>
<td>3</td>
<td>3000</td>
<td>ZAR R1200</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="col-md-6">
<p class="text-primary " style="font-size:24px;">Customized sourcing:</p>
<div class="row ">
<ul>
<li>     <span class="fa fa-check" id="b"></span>  Use 5 minutes and receive up to 10 quotes</li>
<li>     <span class="fa fa-check" id="b"></span> Genuine-verified complaint free suppliers</li>
<li>     <span class="fa fa-check" id="b"></span> Payment protection program <a href"" class="" style="text-decoration:underline; pointer:hand;">Learn more</a></li>


</ul>

</div>

<button class="btn btn-success">Post buying request</button>
</div>

</div>

</div>



<div class="container w3-border w3-margin-top w3-hide-small w3-hide-medium">


<h2 class="" style="background-color:#eef;">Featured Products</h2>
<p></p>
<ul class="nav nav-tabs">
 <?php

while($parent = $sql->fetch(PDO::FETCH_ASSOC)){
    $parent_id =  $parent['pc_id'];
?>
<li class=""><a data-toggle="tab" href="#menu1"><?php echo $parent['pc_name'];?> </a></li>
<?php } ?>
</ul>

<div class="tab-content">
<div id="home" class="tab-pane fade in active">
<!--<h3>Agricultural  <span class="w3-tag w3-blue"> 23 New!</span></h3>-->
<ol class="breadcrumb">
 <?php

$sql2= $pdo->prepare('SELECT * FROM product_category WHERE pc_parent_id  = ? ') ;
$sql2->bindValue(1, $parent_id,PDO::PARAM_INT);
$sql2->execute();


while($child = $sql2->fetch(PDO::FETCH_ASSOC)){
    $child_id =  $child['pc_id'];
?>

<li><a href="category.php?id=<?php echo $child_id ;?>"><?php echo $child['pc_name'];?> </a></li>
<?php } ?>
</ol>
<div class="row">
<div class="col-md-3">
<img src="../../Dont mess with this/Southbulk.com/img/banner.jpg" width="370" height="200" alt=""></div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrobe</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>

</div>

</div>
<div id="menu1" class="tab-pane fade">
<ol class="breadcrumb">
 <?php

$sql2= $pdo->prepare('SELECT * FROM product_category WHERE pc_parent_id  = ? ') ;
$sql2->bindValue(1, $parent_id,PDO::PARAM_INT);
$sql2->execute();


while($child = $sql2->fetch(PDO::FETCH_ASSOC)){
    $child_id =  $child['pc_id'];
?>

<li><a href="category.php?id=<?php echo $child_id ;?>"><?php echo $child['pc_name'];?> </a></li>
<?php } ?>
</ol>
<div class="row">
<div class="col-md-3">
<img src="../../Dont mess with this/Southbulk.com/img/banner.jpg" width="370" height="200" alt=""></div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>

</div>
</div>
<div id="menu2" class="tab-pane fade">
<ol class="breadcrumb">
<li><a href="#">Agricultural & Food</a></li>
<li><a href="#">Plastic mechinary</a></li>
<li><a href="#">Textile mechinery</a></li>
<li><a href="#">Pictures</a></li>
</ol>
<div class="row">
<div class="col-md-3">
<img src="../../Dont mess with this/Southbulk.com/img/banner.jpg" width="370" height="200" alt=""></div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>

</div>
</div>
<div id="menu3" class="tab-pane fade">
<ol class="breadcrumb">
<li><a href="#">Fruit & Vegetables</a></li>
<li><a href="#">Sugar & Cotton</a></li>
<li><a href="#">Grain & Cops</a></li>
<li><a href="#">See all>>></a></li>
</ol>
<div class="row">
<div class="col-md-3">
<img src="../../Dont mess with this/Southbulk.com/img/banner.jpg" width="370" height="200" alt=""></div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive img-circle" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>

</div>
</div>
<div id="menu4" class="tab-pane fade">
<ol class="breadcrumb">
<li><a href="#">Fruit & Vegetables</a></li>
<li><a href="#">Sugar & Cotton</a></li>
<li><a href="#">Grain & Cops</a></li>
<li><a href="#">Pictures</a></li>
</ol>
<div class="row">
<div class="col-md-3">
<img src="../../Dont mess with this/Southbulk.com/img/banner.jpg" width="370" height="200" alt=""></div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive " src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive " src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>
<div class="col-md-3">
<div class="w3-border w3-btn w3-hover-border-green w3-display-container"><a href=""><img class="photo" class="img-responsive " src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="100" height="100" align="absmiddle"></a>
<!--<div class="w3-display-topleft w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Save"><i class="fa fa-heart w3-text-red"></i></button>
</div>-->
<div class="w3-display-topright w3-display-hover w3-large">
<button type="button" class="w3-green w3-animate-opacity w3-btn w3-margin w3-round" title="Share"><i class="fa fa-paper-plane w3-text-grey"></i></button>
</div>
<!-- <div class="w3-display-bottom w3-display-hover w3-large">
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>-->
<p class="w3-display-container text-center"><h5><a href="">Wardrope</a></h5></p>
<strong class="price text-danger">ZAR R120.00-R130.00</strong>
<p clas="minimu-oder text-danger">MOQ:10 Pieces</p>
<button type="button" class="w3-orange w3-animate-opacity w3-btn w3-round"><a href="" style="color:#fff"><span class="fa fa-envelope"></span> Contact merchant</a></button>
</div>
</div>

</div>
</div>

</div>
</div>


<!--featured-products-->
<div class="container" id="featured-products">
 <div class="row w3-margin-top">
  <h3 class="bg-info" >Featured Products</h3>
    <div class="col-xs-6 col-md-2 w3-border w3-hover-shadow  w3-padding"><img class="" src="img/oranges.jpg" id="bigImage" align="absmiddle" alt="">
     <p class=""><a href="">Fresh oranges</a></p>
     <span class="btn btn-success btn-sm"><span style="font-size: 10pt">Add to Qoute</span></span>
      <p class="minimum-order">MOQ:10/carton</p>
     </div>


     <div class="col-xs-6 col-md-2 w3-border w3-hover-shadow w3-padding"><img class="" src="img/1484915707w10.jpg" id="bigImage" alt="Wardrobe" width="170" height="170" align="absmiddle">
      <p class="title"><a href="">Men's Watch</a></p>
      <span class="btn btn-success btn-sm"><span style="font-size: 10pt">Add to Qoute</span></span>
      <p class="minimum-order">MOQ:7/Pieces</p>
      </div>

      <div class="col-xs-6 col-md-2 w3-border w3-hover-shadow  w3-padding"><img class="" src="img/wardrobe design.jpg" id="" alt="Wardrobe" align="absmiddle">
       <p class="title"><a href="">Wardrope</a></p>
      <span class="btn btn-success btn-sm"><span style="font-size: 10pt">Add to Qoute</span></span>
      <p class="minimum-order">MOQ:1/set</p>

     </div>
     <div class="col-xs-6 col-md-2 w3-border w3-hover-shadow w3-padding"><img class="" src="img/1482213336e12.jpg" id="" alt="fresh potatoes" >

      <p class="title"><a href="">Potatoes for export</a></p>
       <span class="btn btn-success btn-sm"><span style="font-size: 10pt">Add to Qoute</span></span>
      <p class="minimum-order">MOQ:100/metric</p>

     </div>

       <div class="col-xs-6 col-md-2 w3-border w3-hover-shadow  w3-padding"><img class="" src="img/ClgMDFnfm2OARIp8AABX4R8MwOQ989.jpg" id=""  alt="watermeloen">

      <p class="title"><a href="">Juicy watermelon</a></p>
     <span class="btn btn-success btn-sm"><span style="font-size: 10pt">Add to Qoute</span></span>
      <p class="minimum-order">MOQ:10/metric</p>

     </div>
     <div class="col-xs-6 col-md-2 w3-border w3-hover-shadow w3-padding"><img class="" src="img/pepe-jeans-men-s-polo-t-shirt.jpg" id="" alt="Wardrobe" >

      <p class="title"><a href="">Fresh oranges</a></p>
          <span class="btn btn-success btn-sm"><span style="font-size: 10pt">Add to Qoute</span></span>
      <p class="minimum-order">MOQ:5 / piece</p>

     </div>
 </div>
</div>

<!--featured-suppliers-->
<div class="container w3-hide-small w3-hide-meduim" id="featured-products" >
<div class="row w3-margin-top w3-display-container">
<h3 class="text-center w3-border"style="background-color:#eef;" ><span class="">Featured Suppliers</span><span class="pull-right">See more</span></h3>
<div class="col-xs-6 col-md-3 w3-border w3-hover-shadow  w3-display-container"><a href=""><img class="" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="170" height="170" align="absmiddle"></a>

<p class="w3-display-container text-center"><a href=" " class="btn btn-success btn-sm">Visit store</a></p>
<strong class="price"><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span><span class="fa fa-star-half" id="b"></span> Better Earth</strong>
<p class="minimum-order">Home Furniture</p>

</div>
<div class="col-xs-6 col-md-3 w3-border w3-hover-shadow  w3-display-container"><a href=""><img class="" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="170" height="170" align="absmiddle"></a>

<p class="w3-display-container text-center"><a href=" " class="btn btn-success btn-sm">Visit store</a></p>
<strong class="price"><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span> Better Earth</strong>
<p class="minimum-order">Home Furniture</p>

</div>

<div class="col-xs-6 col-md-3 w3-border w3-hover-shadow  w3-display-container"><a href=""><img class="" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="170" height="170" align="absmiddle"></a>

<p class="w3-display-container text-center"><a href=" " class="btn btn-success btn-sm">Visit store</a></p>
<strong class="price"><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span> <span class="fa fa-star-half" id="b"></span>  Better Earth</strong>
<p class="minimum-order">Home Furniture</p>

</div>
<div class="col-xs-6 col-md-3 w3-border w3-hover-shadow  w3-display-container"><a href=""><img class="" src="img/wardrobe design.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="170" height="170" align="absmiddle"></a>

<p class="w3-display-container text-center"><a href=" " class="btn btn-success btn-sm">Visit store</a></p>
<strong class="price"><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span><span class="fa fa-star" id="b"></span>Better Earth</strong>
<p class="minimum-order">Home Furniture</p>

</div>
</div>
</div>


<div class="container w3-margin-top w3-center w3-border w3-hide-small w3-hide-meduim" id="services">
<div class="w3-panel w3-border w3-round-large">
<h2 class="">Southbulk.com Markeplace services <span class="w3-tag w3-blue">new!</span></h2>
</div>
<div class="w3-row-padding">
<div class="col-xs-6 col-md-6 w3-margin-top w3-border w3-padding">
<a href=""> <img class="photo"  src="img/icons/medal.png" id="bigImage" alt="premium memberships" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="70" height="70" align="absmiddle">
<h6>Premium memberships</h6>
<p>Enjoy exclusive privileges</p>
</a>
</div>
<div class="col-xs-6 col-md-6 w3-margin-top  w3-border w3-padding">
<a href=""><img class="photo" src="img/icons/advertising.png" id="bigImage" alt="advertising" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="70" height="70" align="absmiddle">
<h6>Digital Marketing</h6>
<p>Get 100+ times more brand and product exposure </p>
</a>
</div>
<!-- <div class="col-xs-4 col-md-4 w3-margin-top  ">
<a href="">  <img class="photo" class="img-responsive" src="img/1236.jpg" id="bigImage" alt="Wardrobe" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="70" height="70" align="absmiddle">
<p>Get 100+ times more brand and product exposure  </p>
</a>
</div>-->
</div>
</div>

</div>
</div>