@extends('app.layout')

@section('title')
Friend List
@endsection

@section('content')
<nav class="navbar navbar-light bg-light">
    <a href="/logout" class="navbar-brand btn btn-info">Log Out</a>
    <a href="/friend-list" class="navbar-brand btn btn-info">Home</a>
    <a href="/invite-friends" class="navbar-brand btn btn-info">Invite_friends</a>
    <a class="navbar-brand">Search Friend using name</a>
        
      <form class="form-inline" action="/searchby-name"  method="post">
        @csrf
        <input class="form-control mr-sm-2" id="friendName" name="friendName"  placeholder="Friend Name" aria-label="Search">
      <button class="btn btn-dark my-2 " type="submit">Search</button>
    </form>
  </nav>

<div class="container">
    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Invitation Type</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
            {{ $counter=1 }}
            @foreach($data as $datas)
          <tr>
            <th scope="row">{{$counter++ }}</th>
            <td>{{$datas->name }}</td>
            <td>{{$datas->email }}</td>
            <td>{{$datas->invitation_type }}</td>
            <td><button type="button" onclick="getAction({{$datas->id  }})" class="btn btn-danger">Remove</button></td>
          </tr>
          @endforeach
        </tbody>
        
      </table>
      {{ $data->links('pagination::bootstrap-4') }}
</div>


<div id="success_msg1" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3>Are you want remove this friend?</h3>
            <input type="hidden" id="friendId">
          </div>
          <div class="modal-footer">
            <button type="button" onclick="remove()" class="btn btn-warning">Remove</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
  </div>

<script>
    function getAction($id){
        $('#success_msg1').modal('show');
        $('#friendId').val($id);
    }

    function remove(){
        var friendId=$('#friendId').val();
        $.ajax({
            type: "post",
            url: "/remove-friend",
            data: {
                "_token": "{{ csrf_token() }}",
                id:friendId
            },
            dataType: "json",
            success: function (response) {
                if(response.status==200){            
            window.location = response.redirect_location;
          }
            }
        });
    }

    function friendSearch(){
        var friendName=$('#friendName').val();
        $.ajax({
            type: "post",
            url: "/searchby-name",
            data: {
                "_token": "{{ csrf_token() }}",
                friendName:friendName
            },
            dataType: "json",
            success: function (response) {
                
            }
        });
    }

    // $('#nameSearch').on(submit, function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         type: "post",
    //         url: "/searchby-name",
    //         data: new FormData(this),
    //         dataType: "json",
    //         success: function (response) {
                
    //         }
    //     });
    // });
</script>

@endsection