@extends('AdminLTE.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Record</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit Users to assign their designation and leads</h3>
              <button type="button" class="btn btn-info float-right"><i class="fas fa-plus"></i> <a href="/addUser" style="color: white;">Add Users</a></button>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>SN0</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Designation</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <?php $i = 0; ?>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                    <td><?php $i += 1;
                        echo $i;
                        ?></td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->gender}}</td>
                    <td>{{$user->designation}}</td>

                    <td><button type="button" id='{{$user->id}}' class='btn btn-primary editbtn'>Edit</button></td>
                  </tr>
                  @endforeach


                  </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<!-- model -->
<div class="modal fade" id="edit_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action='editUserAction' enctype="multipart/form-data" method="post" class="form-horizontal">
          @csrf
          <div class="card-body">
            <input type="hidden" class="form-control" id="inputId" name='id'>
            <input type="hidden" id='roleName' name='roleName'>


            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" name='name' placeholder="Name">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail" name='email' placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <label for="Gender" class="col-sm-2 col-form-label">Gender</label>
              <div class="col-sm-10">
                <div class="custom-control custom-radio">
                  <label class='radio-inline'>
                    <input type='radio' id='male' value='male' name='gender'>Male
                  </label>
                  <label class='radio-inline'>
                    <input type='radio' id='female' value='female' name='gender'>Female
                  </label>
                  <label class='radio-inline'>
                    <input type='radio' id='other' value='other' name='gender'>Other
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="Designation" class="col-sm-2 col-form-label">Designation</label>
              <div class="col-sm-10">
                <div class="custom-control custom-radio">
                  <label class='radio-inline'>
                    <input type='radio' id='lead' value='lead' name='designation'>Lead
                  </label>
                  <label class='radio-inline'>
                    <input type='radio' id='developer' value='developer' name='designation'>Developer
                  </label>
                </div>
              </div>
            </div>

            <div class='form-group row'>
              <label class='col-sm-2 col-form-label'>Roles</label>
              <div class='col-sm-10'> <select id='roles' name='roles' class='custom-select' onChange=<?php echo "checkRole()"; ?>>
                  <option disabled>Choose Role:</option>
                  @if($roles) @foreach($roles as $role)
                  <option value='{{$role->id}}'>{{$role->name}}</option>
                  @endforeach
                  @endif
                </select></div>
            </div>
            <div id="parent1"></div>


          </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
  //  To show Edit Modal
  $(document).ready(function() {
    $('.editbtn').on('click', function(e) {
      $('#edit_user').modal('show');
      var userId = e.target.id;
      $tr = $(this).closest('tr');
      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();
      var name = data[1];
      var email = data[2];
      var gender = data[3];
      var designation = data[4];

      if (designation) {
        var designationId = '#' + designation;
        $(designationId).prop("checked", true);
      } else {
        $('#lead').prop("checked", false);
        $('#developer').prop("checked", false);
      }
      $('#inputId').val(userId);
      $('#inputName').val(data[1]);
      $('#inputEmail').val(data[2]);
      var genderId = '#' + gender;
      $(genderId).prop("checked", true);
    })
  });

  function check() {
    var currentIdfield = document.getElementById('inputId');
    var currentId = currentIdfield.value;

  }

  function checkRole() {
    var selectRole = document.getElementById('roles');
    var aUrl = "/getRoleById/" + selectRole.value;
    $.ajax({
      url: aUrl,
      type: 'get',
      success: function(data) {
        document.getElementById('roleName').value = data
        if (data === 'Lead') {
          document.getElementById('parent1').innerHTML = ''

        }
        if (data === 'Developer') {
          document.getElementById('parent1').innerHTML = '';
          document.getElementById('parent1').insertAdjacentHTML("beforeend", " <div class='form-group row'> <label for='assignTo' class='col-sm-2 col-form-label'>Assign To</label> <div class='col-sm-10' > <select id='assignTo' name='assignTo' class='custom-select'> <option disabled>Choose Lead:</option> @if($users)  @foreach($users as $user)   @if($user->parent === 0 ) <option value='{{$user->id}}'>{{$user->name}}</option> @endif @endforeach @endif </select></div></div>");
        }


      }
    });


  }
</script>
@endsection