                   @if(Auth::check())
                      @foreach ($fav as  $f)
                      @php
                      $array = $fav->toArray() ;  
                      @endphp			

                      @if( $product->pd_id != $f && !in_array($product->pd_id,$array ) )
                      <a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
                      </a> 
                      <?php break;?>
                      @else
                      <a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart fa-red btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
                      </a> 
                      <?php break;?>
                      @endif
                      @endforeach

                    

                      @endif

                      @if(!Auth::check())
                      <a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
                      </a> 
                      @endif