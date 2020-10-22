@inject('area','App\Area')
@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-10"><h3 class="font-weight-bold">{{ Auth::user()->name }}</h3></div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-4 bg-light profile-container"><!--left col-->
      <div class="card">
        <div class="card-header">User Information</div>
        <div class="card-body">
          <div class="profile">
            @if(Auth::user()->img !== "NA")
              <img src="{{ url('img/profile').'/'.Auth::user()->img }}" class="img-fluid-center avatar circle-img" alt="avatar" id="profile_img" />
            @else
              <img src="{{ asset('img/profile/default.png') }}" class="img-fluid-center avatar text-center circle-img" alt="avatar" id="profile_img" />
            @endif
            <label class="new-avatar hidden"><span class="far fa-plus-square"></span>
              <input name="img" id="img" type="file" class="text-center center-block file-upload"/>
            </label>
            <span id="spn_img_message"></span>
          </div>
          <br><br>
          <ul class="list-group">
            @if(Auth::user()->user_role == 1)
              <li class="list-group-item"><strong class="text-muted">Assigned Location :</strong> <label>&nbsp;{{ $area->area_name }}</label></li>
              <li class="list-group-item"><strong class="text-muted">No. assigned Stores :</strong> <label>&nbsp;5</label></li>
            @endif
            <li class="list-group-item"><strong class="text-muted">Employee ID : </strong>&nbsp;{{ Auth::user()->id }}</li>
            <li class="list-group-item">
              <span class="pull-left"><strong class="text-muted">Status :</strong></span>
              @if(Auth::user()->is_active == 1)
              <span class="text-success font-weight-bold">Active</span>
              @else
              <span class="text-danger font-weight-bold">In-Active</span>
              @endif
            </li>
          </ul>
        </div>
      </div>
    </div><!--/col-3-->

    <div class="col-sm-12 col-md-6 col-lg-8">
      <div class="card">
        <div class="card-header-1">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile-tab-data" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="change-pass-tab" data-toggle="tab" href="#change-pass-tab-data" role="tab" aria-controls="change password" aria-selected="false">Change Password</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile-tab-data" role="tabpanel">
              <form id="profileForm" name="profileForm">
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" value="{{ Auth::user()->fname }}" required onkeypress="return onlyLetters(event)"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="mname">Middle Name</label>
                        <input type="text" class="form-control" name="mname" id="mname" placeholder="Middle Name" value="{{ Auth::user()->mname }}" required onkeypress="return onlyLetters(event)"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" value="{{ Auth::user()->lname }}" required onkeypress="return onlyLetters(event)"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="email">Address</label>
                        <input type="text" class="form-control" name="address" id="address"  placeholder="Address" title="enter a location" value="{{ Auth::user()->address }}" required onkeypress="return onlyLetters(event)"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="phone">Contact Number</label>
                        <input type="text" class="form-control" name="contact_num" id="contact_num" placeholder="Contact Number" value="{{ Auth::user()->contact_num  }}" required onkeypress="return onlyNumbers(event)"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" disabled="" data-toggle="tooltip" data-placement="top" title="Email address should not be changed."  placeholder="Email Address" value="{{ Auth::user()->email  }}" required/>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary full-width-button">Update</button>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="change-pass-tab-data" role="tabpanel">
              <form id="changeProfile" name="changeProfile">
                <input type="hidden" name="reset_id" id="reset_id" value="{{ Auth::user()->id }}">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="old_password">Old Password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" required/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                        <label for="confirm">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm" name="confirm" required/>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary full-width-button">Reset</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><!--/col-9-->
  </div>
</div>

<script type="text/javascript">

  //ajax setup
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  //when there is an image selected
  $('#img').on('change',function(ev){

    //get the data value
    var filedata = this.files[0];
    var imgtype = filedata.type;

    var match = ['image/jpeg','image/jpg','image/png'];

    if(!imgtype==match[0] || !imgtype==match[1] || !imgtype==match[2]) {
      $('#spn_img_message').html('<p style="color:red">Please select a valid type image. <br/> Only JPG/JPEG/PNG file is allowed!</p>');

    }else{

      $('#spn_img_message').empty();

      var postData = new FormData();
      postData.append('img',this.files[0]);
      postData.append('user_id', $("#user_id").val());

      $.ajax({
        async:true,
        type:"POST",
        contentType:false,
        url: "{{url('profile_upload')}}",
        data: postData,
        processData:false,
        success:function(response){
          $("#img").val('');
          swal("Information", response.message);
          $("#profile_img").attr("src", response.uploaded_image);
        }
      });

    }
  });

  // when button update profile is clicked
  $('#profileForm').on('submit', function (e) {
      e.preventDefault();
      // $(this).html('Saving..');

      $.ajax({
        data: $('#profileForm').serialize(),
        url: "{{ url('profile_update') }}",
        type: "POST",
        dataType: 'json',
        success: function (response) {
          $("#fname").val(response.fname);
          $("#mname").val(response.mname);
          $("#lname").val(response.lname);
          $("#address").val(response.address);
          $("#contact_num").val(response.contact_num);

          swal("Information", response.message);
        },
        error: function (data) {
          console.log('Error:', data);
          swal("Information", data);
        }
      });
  });

  // when button change password button is clicked
  $('#changeProfile').on('submit', function (e) {
    e.preventDefault();

    var oldpass = $("#old_password").val();
    var pass = $("#password").val();
    var confirm = $("#confirm").val();

    var error_output = '';

    if(oldpass == ''){
      error_output += 'Please fill in your old password!\n';
    }if(pass == ''){
      error_output += 'Please fill in your new password!\n';
    }if(confirm == ''){
      error_output += 'Please fill in your confirm password!\n';
    }if(pass != confirm){
      error_output += 'Password mismatched!\n';
    }

    //check if there is an error
    if(error_output != ''){
      swal("Error", error_output);
    }else{

      $.ajax({
        data: $('#changeProfile').serialize(),
        url: "{{ url('profile_pass_reset') }}",
        type: "POST",
        dataType: 'json',
        success: function (response) {
          $("#old_password").val('');
          $("#password").val('');
          $("#confirm").val('');
          swal("Information", response.message);
        },
        error: function (data) {
          console.log('Error:', data);
          swal("Error", data.responseText);
        }
      });
    }
  });



</script>

@endsection