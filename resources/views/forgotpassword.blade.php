@extends('app.layout')

@section('title')
OTP-CHECK
@endsection

<style>
    .gradient-custom {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to bottom right, rgba(240, 147, 251, 1), rgba(245, 87, 108, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to bottom right, rgba(240, 147, 251, 1), rgba(245, 87, 108, 1))
}

.card-registration .select-input.form-control[readonly]:not([disabled]) {
font-size: 1rem;
line-height: 2.15;
padding-left: .75em;
padding-right: .75em;
}
.card-registration .select-arrow {
top: 13px;
}
</style>

@section('content')

<section>
    <div>
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
              <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Reset Password</h3>
                      <form id="emailValidation">
                        @csrf

                        

                        <div class="row">
                            
                          <div class="col-md-8 mb-8">
          
                            <div class="form-outline">
                                <label class="form-label" for="otp">Email</label>
                              <input type="email" placeholder="Enter your registered email" name="email" id="email" class="form-control form-control-lg" />                              
                            </div>
          
                          </div>
                          <div class="col-md-4 mb-4">
                            <div class="mt-4 pt-2">
                                <button type="submit" id="btncheck"  class="btn btn-primary btn-lg">Send Link</button>
                              </div>
                          </div>
                        </div>     
                        <div class="row">
                            <ul id="error_msg"></ul>
                        </div>
                      </form>
                      
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
    </div>
</section>

 {{-- Success Masg Show Modal --}}
 <div id="success_msg1" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3>Your Email is verified.Please Login!</h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
  </div>

<script>


$("#emailValidation").on('submit', function (e) {
      e.preventDefault();
      
      $.ajax({
        type: "POST",
        url: "/send-password-links",
        data: new FormData(this),
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
          if(response.status==200){            
            $('#success_msg1').modal('show');
            // setTimeout(function(){ window.location = '/' }, 3000);
          }else{
            $.each(response.validate, function (key, err_values) { 
                $('#error_msg').append('<li class="alert alert-danger">'+err_values+'</li>');
            });
            
          }
        }
      });
    
    });

    // $("#resendOtp").on('submit', function (e) {
    //   e.preventDefault();
      
    //   $.ajax({
    //     type: "GET",
    //     url: "/resend-otp",
    //     dataType: "json",
    //     processData: false,
    //     contentType: false,
    //     cache: false,
    //     success: function (response) {
    //       if(response.status==200){ 
    //         $('#error_msg').append('<li class="alert alert-primary">'+response.msg+'</li>');
    //       }else{
    //         $.each(response.validate, function (key, err_values) { 
    //             // $('#error_msg').append('<li class="alert alert-danger">'+err_values+'</li>');
    //         });
    //         $('#success_msg').modal('show');
    //       }
    //     }
    //   });
    
    // });

    
    
    
    </script>

@endsection