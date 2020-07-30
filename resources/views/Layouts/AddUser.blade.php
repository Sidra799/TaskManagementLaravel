@extends('AdminLTE.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add User</h1>
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
                        <div class="card-body">
                            <form action='addUser' enctype="multipart/form-data" method="post" class="form-horizontal">
                                @csrf
                                @if(Session::has('error'))
                                <p class="alert alert-danger">{{ Session::get('error') }}</p>
                                @endif
                                @if(session()->has('success'))
                                <p class="alert alert-success">{{ Session::get('success') }}</p>
                                @endif
                                <input type="hidden" id='roleName' name='roleName'>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName1" name='name' placeholder="Name">
                                        @if ($errors->has('name'))
                                        <p style="color:red">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail1" name='email' placeholder="Email">
                                        @if ($errors->has('email'))
                                        <p style="color:red">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name='password' id="inputPassword" class="form-control" placeholder="Password">
                                        @if ($errors->has('password'))
                                        <p style="color:red">{{ $errors->first('password') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Confirm </label>
                                    <div class="col-sm-10">
                                        <input type="password" name='password_confirmation' id="confirm_password" class="form-control" placeholder="Confirm Password">
                                        @if ($errors->has('password_confirmation'))
                                        <p style="color:red">{{ $errors->first('password_confirmation') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Gender" class="col-sm-2 col-form-label">Gender</label>
                                    <div class="col-sm-10">
                                        <div class="custom-control custom-radio">
                                            <label class='radio-inline'>
                                                <input type='radio' id='male1' value='male' name='gender'>Male
                                            </label>
                                            <label class='radio-inline'>
                                                <input type='radio' id='female1' value='female' name='gender'>Female
                                            </label>
                                            <label class='radio-inline'>
                                                <input type='radio' id='other1' value='other' name='gender'>Other
                                            </label>
                                        </div>
                                        @if ($errors->has('gender'))
                                        <p style="color:red">{{ $errors->first('gender') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Designation" class="col-sm-2 col-form-label">Designation</label>
                                    <div class="col-sm-10">
                                        <div class="custom-control custom-radio">
                                            <label class='radio-inline'>
                                                <input type='radio' id='lead1' value='lead' name='designation' ?>Lead
                                            </label>
                                            <label class='radio-inline'>
                                                <input type='radio' id='developer1' value='developer' name='designation' ?>Developer
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
                                <button type="submit" class="btn btn-primary float-right">Save changes</button>
                        </div>
                        </form>
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

<script>
    function checkRole() {
        var selectRole = document.getElementById('roles');
        var aUrl = "/getRoleById/" + selectRole.value;
        $.ajax({
            url: aUrl,
            type: 'get',
            success: function(data) {
                document.getElementById('roleName').value = data
                if (data === 'Lead') {
                    document.getElementById('parent1').innerHTML = '';
                }
                if (data === 'Developer') {
                    document.getElementById('parent1').innerHTML = '';
                    document.getElementById('parent1').insertAdjacentHTML("beforeend", " <div class='form-group row'> <label for='assignTo' class='col-sm-2 col-form-label'>Assign To</label> <div class='col-sm-10' > <select id='assignTo' name='assignTo' class='custom-select'> <option disabled>Choose Lead:</option> @if($users)  @foreach($users as $user)   @if($user->parent == 0 ) <option value='{{$user->id}}'>{{$user->name}}</option> @endif @endforeach @endif </select></div></div>");
                }
            }
        });


    }
</script>
@endsection