@extends('admin.admin_master')
@section('admin')

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Change password </h4><br><br>

            @if (count($errors))
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger alert-mismissible fade show">
                {{ $error }}
            </p>

            @endforeach

            @endif


            <form method="post" action="{{ route('update.password') }}" >
                @csrf

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Old password</label>
                <div class="col-sm-10">
                    <input type="password" name="oldpassword" class="form-control" id="oldpassword">
                </div>
            </div>

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
                <div class="col-sm-10">
                    <input type="password" name="newpassword" class="form-control" id="newpassword">
                </div>
            </div>

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                </div>
            </div>

           <input type="submit" class="btn btn-info waves-effect waves-light" value="Change Password">
        </form>
            <!-- end row -->

            <!-- end row -->



            <!-- end row -->


            <!-- end row -->






        </div>
    </div>
</div> <!-- end col -->
</div>



</div>
</div>




@endsection
