@extends('app.layout')

@section('title')
Login
@endsection

@section('content')
<style>
    .gradient-custom-2 {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
}

@media (min-width: 768px) {
.gradient-form {
height: 100vh !important;
}
}
@media (min-width: 769px) {
.gradient-custom-2 {
border-top-right-radius: .3rem;
border-bottom-right-radius: .3rem;
}
}
</style>

<section>
    <div class="container">
        <section class="h-100 gradient-form" style="background-color: #eee;">
            <div class="container py-5 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                  <div class="card rounded-3 text-black">
                    <div class="row g-0">
                      <div class="col-lg-12">
                        <div class="card-body p-md-5 mx-md-4">
          
                          <div class="text-center">
                            <h4 class="mt-1 mb-5 pb-1">Friend List Manager</h4>
                          </div>
          
                          <form id='login'>
                            @csrf
                            <p>Please login to your account</p>
                            <ul id="error_msg"></ul>
                            <div class="form-outline mb-4">
                              <input type="email" name="email" id="form2Example11" class="form-control"
                                placeholder=" email address" />
                              <label class="form-label" for="form2Example11">Email</label>
                            </div>
          
                            <div class="form-outline mb-4">
                              <input type="password" name="password" id="form2Example22" class="form-control" />
                              <label class="form-label" for="form2Example22">Password</label>
                            </div>
          
                            <div class="text-center pt-1 mb-5 pb-1">
                              <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" >Log
                                in</button>
                              <a class="text-muted" href="/forgot-password">Forgot password?</a>
                            </div>
          
                            <div class="d-flex align-items-center justify-content-center pb-4">
                              <p class="mb-0 me-2">Don't have an account?</p>
                              <a href="/register" class="btn btn-outline-danger">Create new</a>
                              
                            </div>
          
                          </form>
          
                        </div>
                      </div>
                      
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
          <h3>Please verify your email!</h3>
          <h3>Email Or Password Incorrect!</h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<script>
  $("#login").on('submit', function (e) {
      e.preventDefault();
      
      $.ajax({
        type: "POST",
        url: "/login",
        data: new FormData(this),
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
          if(response.status==200){            
            window.location = response.redirect_location;
          }
          else{
            $('#success_msg1').modal('show');
          }
        }
      });
    
    });
</script>

@endsection