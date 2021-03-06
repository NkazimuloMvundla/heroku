


<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="ui-form-item form-group">
		<label class="ui-form-label" for="commonCategoryName">
		Product Category:       </label>
        <div class="form-group">
            <div id="product-category">
<div class="form-group row">
    <div class="col-md-4">
    <label for="text">Select a Main category</label>
    <select class="form-control " id="mc_id"  name="mainCategory">
        <option selected="selected" disabled selected>Main category</option>
        @forelse($parent_category as $category)
        <option value="{{ $category->pc_id }} ">{{$category->pc_name}}</option>
        <?php $pc_id = $category->pc_id ;?>
        @empty
        <option value="">No categories</option>
        @endforelse
    </select>
        @error('mainCategory')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    <span class="help-block"></span>
    </div>
 

  <div class="col-md-4" >
    <label for="category">Select a Category</label>
    <select class="form-control coin"  name="c_id"  id="c_id">
     <option selected disabled>Category</option>
    </select>
    @error('Category')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror

    <span class="help-block"></span>
</div>
<div class="col-md-4 ">

<label for="number">Select a Sub Category </label>
<div id="last">
  <select class="form-control"  name="subCategory"  id="sc_id">
        <option selected disabled>Sub Category</option>
  </select>
  @error('subCategory')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</div>
<span class="help-block"></span>
</div>
</div>

</div>
</div>
</div>
<script nonce="{{ csp_nonce() }}">
 $(document).ready(function(){
    $("#mc_id").on('change', function(){
        showCat(this.value);
    })
})

</script>
