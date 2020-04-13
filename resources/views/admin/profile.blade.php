@extends('admin.layout.admin')
@section('title' , 'Profile')


@section('content')
<style type="text/css">
span[role="alert"]{
  color:red;
}
</style>

<div class="content-wrapper">
  <section class="content">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#home">Company introduction</a></li>
      <li><a data-toggle="tab" href="#certificates">Certificates</a></li>
       <li><a data-toggle="tab" href="#export">Export capabilty</a></li>
    </ul>

     <div class="tab-content">
      <div id="home" class="container tab-pane fade in active">
        <div class="row">
       @if(Session::has('message'))
        <div class="">
            <ul>
                <li class="label label-success"  style="font-size:15px;">{{ Session::get('message') }}</li>

            </ul>

        </div>
        @endif
            <form method="POST" action="#" enctype="multipart/form-data" id="updateProfile">
          @method('PATCH')
        @csrf
         <div class="row">
        <div class="col-md-4" style="margin-top:9px;">
          <label>About Us</label>
          <div class="form-group">
            <textarea class="form-control @error('about_us') is-invalid @enderror" id="about_us" name="about_us" >{{old('about_us') ?? $user_details->first()->about_us}}</textarea>
            @error('about_us')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
          </div>
           <label>Company name</label>
          <div class="form-group">
            <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{old('company_name') ?? $user_details->first()->company_name}}">
            @error('company_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
          </div>
            <label>Company Street Address</label>
          <div class="form-group">
            <input type="text" name="company_address"  class="form-control @error('company_address') is-invalid @enderror"value="{{old('company_address')?? $user_details->first()->company_address}}">
            @error('company_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
            <label>Zip Code</label>
          <div class="form-group">
            <input type="text" name="zip_code" class="form-control @error('zip_code') is-invalid @enderror" value="{{old('zip_code') ?? $user_details->first()->zip_code}}">
            @error('zip_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
          <label>Location</label>
          <div class="form-group">
            <strong><i class="fa fa-map-marker margin-r-5"></i><span class="text-muted"> South Africa</span></strong>
          </div>
            <label>Company contact number</label>
          <div class="form-group">
            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number')??$user_details->first()->phone_number }}">
            @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        <label>Industry</label>
        <div class="form-group">
         <span>{{ $user_details->first()->industry }}</span>
        </div>
        </div>
        </div>
        <div style="margin-top:12px;">
        <button class="btn btn-primary" id="submitFormBtnA" name="submitFormBtnA" type="submit">Update</button>
        </div>
      </form>
    </div>
      </div>
         <!--second content-->
          <div role="tabpanel" id="certificates" class="tab-pane">

            <div class="container">
                  <div id="result"></div>
                  <div id="valid" class="alert alert-danger" style="display:none;">
                  <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }} </li>

                    @endforeach
                  </ul>
                </div>
                <div class="row" style="margin-top:12px;">
                 <div class="col-md-8">
                       <form action="/u/profile/certificate" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                    <label for="File">File input</label>
                         <div class="dropzone" id="myDropzoneCertificate">
                            <div class="fallback">
                            <input type="file" id="file_upload" name="certificate[]"   multiple>
                            </div>
                        </div>
                    <p><strong>Note:</strong>
                    <div style="color:red;" class="dz-error-message" id="dz-error-message"></div>
                    <i style="">a max of 3 images, <br> Only .jpg, .jpeg, .gif, .png , .docx formats allowed to a max size of 5 MB.</i>
                    </p>
                    @error('file')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                      <input id="submitFormBtn" name="submitFormBtn"  disabled value="Insert" class="btn btn-success"  type="submit"  />
                   </form>
                 </div>

                <div class="col-md-4">
                @if(!empty($CompanyCertificate))
                <div class="">
                @foreach($CompanyCertificate as $company_img)
                <div class="">
                <span class="btn btn-danger btn-sm" style="margin:5px;position: absolute;" onclick="deleteCompanyCertificate({{ $company_img->id }})">delete</span>
                <img class="img-responsive" src="/storage/{{ $company_img->filename }}" alt="company image" width="100%" style="margin:10px;">
                 </div>
                @endforeach
                    </div>
                @endif
            </div>
                </div>
            </div>

           </div>

               <!--second content-->
          <div role="tabpanel"  id="export" class="tab-pane">
            @if(Session::has('message'))
               <div class="">
                <ul>
                    <li class="label label-success"  style="font-size:15px;">{{ Session::get('message') }}</li>

                </ul>

               </div>
               @endif
          <form method="POST" action="{{ route('export-capabilities') }}" id="export_capabilities">
              @method('PATCH')
            @csrf
           <div class="container">
            <div class="row">
                <div class="col-md-4" style="margin-top:9px;">
                    <label>Export percentage</label>
                    <div class="form-group">
                  <?php $export_percentages = ["50" , "40", "30"] ; ?>
                    @if(!empty($ExportCapability))
                    @foreach ($ExportCapability as $exportInfo)
                        <select id="export_percentage" name="export_percentage" class="form-control">

                        @foreach($export_percentages as $percentages)
                               <?php $action = $percentages == $exportInfo->first()->export_percentage ?  'selected' : ''  ?>
                            <option value="{{$percentages}}" {{ $action }}>{{$percentages}}</option>
                        @endforeach
                        </select>
                    @endforeach
                    @endif


                          @if($countExportCapability == 0)
                          <!--if ExportCapability is empty-->
                           <select id="export_percentage" name="export_percentage" class="form-control">
                             <option selected disabled>select</option>
                           @foreach($export_percentages as $percentages)
                            <option value="{{$percentages}}">{{$percentages}}</option>
                            @endforeach
                          </select>
                          @endif

                        <span class="percentage_res" value=""></span>
                           @error('export_percentage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                    </div>
                    <label>Main Markets</label>
                    <?php $main_markets = ["North America" , "Southeast Asia", "Mid East" , "Central America", "South Asia", "South America" , "Africa" , "Eastern Asia" , "Northern Europe" , "Domestic Market" , "Eastern Europe" , "Oceania" , "Western Europe" , "Southern Europe"] ; ?>
                    <div class="form-group">

                    @foreach($main_markets as $market)

                    @if(!empty($ExportCapability))
                       @foreach ($ExportCapability as $exportInfo)
                       <?php $markets = explode(',',$exportInfo->first()->main_markets ) ;?>
                        <?php $action = in_array($market ,$markets ) ?  'checked' : ''  ?>

                    <input type="checkbox" {{ $action }}  class="market" name="market[]" id="market" value="{{$market}}"> {{$market}}


                        @endforeach
                    @endif

                    @if($countExportCapability == 0)
                    <!--if this ExportCapability is empty-->
                    <input type="checkbox"   class="market" name="market[]" id="market" value="{{$market}}"> {{$market}}
                     @endif

                    @endforeach


                     @error('market')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                    </div>



                    <label>Year when company started exporting</label>
                    <div class="form-group">
                  <?php $export_years = ["2001" , "2002", "2003"] ; ?>
                    @if(!empty($ExportCapability))
                    @foreach ($ExportCapability as $exportInfo)

                        <select id="year_started_exporting" name="export_year" class="form-control">
                                  @foreach($export_years as $export_year)
            <?php $action = $export_year == $exportInfo->first()->export_started  ?  'selected' : ''  ?>
                            <option value="{{$export_year}}" {{ $action }}>{{$export_year}}</option>
                                   @endforeach
                        </select>
                    @endforeach
                    @endif


                        @if($countExportCapability == 0)
                          <!--if this is not empty-->
                           <select id="year_started_exporting" name="export_year" class="form-control">
                             <option selected disabled>select</option>
                           @foreach($export_years as $years)
                            <option value="{{$years}}">{{$years}}</option>
                            @endforeach
                          </select>
                          @endif

                          @error('export_year')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                    </div>
                </div>

            </div>
               <button class="btn btn-primary btn-sm" type="submit" id="save-export">Save!</button>
           </div>

        </form>
          </div>
          <!--second content ends here-->


    </div>

    <script src="{{ asset('u/js/validateProf.js') }}"></script>

  </section>

@endsection
