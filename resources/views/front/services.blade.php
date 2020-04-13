
@extends('layouts.main')
@section('content')
<div class="w3-container">
        <div class="row w3-margin-top w3-center" id="services" >
            <div class="col-md-12">
                    <div class="w3-panel w3-round-large">
                            <h2 class="featured">Southbulk.com Markeplace services <span class="w3-tag w3-blue">new!</span></h2>
                            </div>
                            <div>
                            <div class="col-xs-12 col-md-6 w3-margin-top row-1 w3-padding">
                            <a href=""> <img class="photo"  src="/storage/icons/medal.png" id="bigImage" alt="premium memberships" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="70" height="70" align="absmiddle">
                            <h6>Premium memberships</h6>
                            <p>Enjoy exclusive privileges</p>
                            </a>
                            </div>
                            <div class="col-xs-12 col-md-6 w3-margin-top  row-1 w3-padding">
                            <a href=""><img class="photo" src="/storage/icons/advertising.png" id="bigImage" alt="advertising" onload="AE.util.resizeImage(this.src, this, 250, 250);setElementMiddle(250, 250, get('bigImage'));" width="70" height="70" align="absmiddle">
                            <h6>Digital Marketing</h6>
                            <p>Get 100+ times more brand and product exposure </p>
                            </a>
                            </div>
                            </div>
        
            </div>    
          
                </div>


</div>
@endsection