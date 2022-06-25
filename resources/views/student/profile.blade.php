@extends('layout.layout_student')

@section('title','Profile')
@section('name',auth()->user()->name)
@section('role',auth()->user()->role)

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header border-bottom">
          <h4 class="card-title">Profile Details</h4>
        </div>
        <div class="card-body py-2 my-25">
          <form class="validate-form mt-2 pt-50" action="{{url('/student/profile/update')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="d-flex mb-2">
                <a href="#" class="me-25">
                  <img
                    id="account-upload-img"
                    class="uploadedAvatar rounded me-50"
                    alt="profile image"
                    height="100"
                    width="100"
                    src="{{asset('user/'.$user[0]->images)}}"
                  />
                </a>
                <div class="d-flex align-items-end mt-75 ms-1">
                    <div class="">
                        <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75" id="up-btn">Upload</label>
                        <input type="file" id="account-upload" accept="image/*" name="files" style="opacity: 0;width: 0px;"/>
                        <button type="button" id="account-reset" class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
                        <p class="mb-0">Allowed file types: png, jpg, jpeg.</p>
                        @error('files')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountFirstName">Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="accountFirstName"
                  name="name"
                  placeholder="John"
                  value="{{$user[0]->name}}"
                  data-msg="Please enter first name"
                />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountEmail">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="accountEmail"
                  name="email"
                  placeholder="Email"
                  value="{{$user[0]->email}}"
                />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountPhoneNumber">Phone Number</label>
                <input
                  type="number"
                  class="form-control account-number-mask"
                  id="accountPhoneNumber"
                  name="phone"
                  placeholder="Phone Number"
                  value="{{$user[0]->phone}}"
                />
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-12 col-sm-6 mb-1">
                <label class="form-label" for="accountPhoneNumber">Class Code</label>
                <input
                  type="text"
                  class="form-control account-number-mask"
                  id="accountPhoneNumber"
                  name="class_code"
                  placeholder="Class Code"
                  value="{{$user[0]->class_code}}"
                />
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-12">
                <input type="submit" class="btn btn-primary mt-1 me-1" value="Save changes">
              </div>
            </div>
          </form>
        </div>
      </div>
</div>
@endsection
@section('script')
<script>
  $('#account-upload').change(function(){
    var file = $(this)[0].files[0];
    var reader = new FileReader();
    reader.onload = function(e){
      $('#account-upload-img').attr('src',e.target.result);
    };
    reader.readAsDataURL(file);
  });
  $('#account-reset').click(function(){
    $('#account-upload-img').attr('src',"{{asset('user/'.$user[0]->images)}}");
  });
</script>
@endsection