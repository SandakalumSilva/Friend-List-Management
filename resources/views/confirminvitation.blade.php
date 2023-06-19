@extends('app.layout')

@section('title')
Confirm-Invitation
@endsection

@section('content')
<section>
    <div>
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-10">
              <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Confirm Invitation</h3>
                      <form id="inviteFriends">
                        @csrf

                        <div class="row">
                            @foreach($id as $id)
                            <input type="hidden" name="friendId" value="{{$id}}">
                            @endforeach
                            @foreach($user_id as $user_id)
                            <input type="hidden" name="userId" value="{{$user_id}}">
                            @endforeach
                        </div>

                        <div class="row">
                          
                          <div class="col-md-6 mb-6">
          
                            <div class="form-outline">
                                <label class="form-label" for="otp">Enter Name</label>
                                <ul id="error_msg"></ul>
                              <input type="text" placeholder="name" name="name" id="email" class="form-control form-control-lg" />                              
                            </div>
          
                          </div>
                          {{-- <div class="col-md-6 mb-6">
          
                            <div class="form-outline">
                                <label class="form-label" for="otp">Enter Email</label>
                                <ul id="error_msg"></ul>
                              <input type="text" placeholder="Email" name="email" id="email" class="form-control form-control-lg" />                              
                            </div>
          
                          </div> --}}
                          
                        </div>  
                        <div class="row">
                            <div class="col-md-6 mb-6">
                                <div class="mt-4 pt-2">
                                    <button type="submit" id="btncheck"  class="btn btn-primary btn-lg">Accept</button>
                                  </div>
                              </div>    
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

<div id="success_msg1" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3>You Accept friend request.</h3>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
  </div>


<script>
    $("#inviteFriends").on('submit', function (e) {
        e.preventDefault();
        
        $.ajax({
          type: "POST",
          url: "/accept-invitation",
          data: new FormData(this),
          dataType: "json",
          processData: false,
          contentType: false,
          cache: false,
          success: function (response) {
            if(response.status==200){  
                $('#success_msg1').modal('show');
            }
            else{
            //   $('#success_msg1').modal('show');
            $.each(response.validate, function (key, err_values) { 
                $('#error_msg').append('<li class="alert alert-danger">'+err_values+'</li>');
            });
            }
          }
        });
      
      });
  </script>

@endsection