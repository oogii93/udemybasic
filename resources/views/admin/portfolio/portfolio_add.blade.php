@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Portfolio </h4>

            <form method="post" action="{{ route('store.portfolio') }}" enctype="multipart/form-data">
                @csrf


            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Portfolio Name</label>
                <div class="col-sm-10">
                    <input name="portfolio_name" class="form-control" type="text"   id="example-text-input">
                    <!--controll deer validation hiihed error garwal endeh code ajilna-->
                    @error('portfolio_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Portfolio title </label>
                <div class="col-sm-10">
                    <input name="portfolio_title" class="form-control" type="text"  id="example-text-input">

                    @error('portfolio_title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- end row -->





            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Portfolio Description </label>
                <div class="col-sm-10">
                    <textarea id="elm1" name="portfolio_description">
                    </textarea>
                </div>
            </div>
            <!-- end row -->

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Portfolio image </label>
                <div class="col-sm-10">
                    <input name="portfolio_image" class="form-control" type="file"   id="image">
                    @error('portfolio_image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- end row -->


              <div class="row mb-3">
                 <label for="example-text-input" class="col-sm-2 col-form-label">  </label>
                <div class="col-sm-10">
                    <img id="showImage" class="rounded avatar-lg" src="{{url('upload/no_image.jpg') }}" alt="Card image cap">
                </div>
            </div>
            <!-- end row -->
<input type="submit" class="btn btn-info waves-effect waves-light" value="Insert portfolio page">
            </form>



        </div>
    </div>
</div> <!-- end col -->
</div>



</div>
</div>


<script type="text/javascript">

    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>

@endsection
