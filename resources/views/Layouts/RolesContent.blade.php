@extends('AdminLTE.layout');

@section ('content')
<div class="content-wrapper">
    <div class='container-fluid'>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Roles</h1>
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
                                <button type="button" data-toggle="modal" data-target="#addTaskModal" class="btn btn-info float-right"><i class="fas fa-plus"></i> Add Roles</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>SNO</th>
                                            <th>Roles</th>
                                            <th>Permissions</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 0; ?>
                                    <tbody>
                                        @foreach($roles as $role)


                                        <tr>
                                            <td><?php $i += 1;
                                                echo $i;
                                                ?></td>
                                            <td>{{$role->name}}</td>
                                            <td>
                                                @foreach($role->permissions as $permission)

                                                <span id='{{$permission->id}}' class="badge badge-success">{{$permission->name}}</span>
                                                @endforeach
                                            </td>

                                            <td>
                                                <button type="button" id='{{$role->id}}' class='btn btn-primary editbtn'>Edit</button>
                                                <button type="button" id='{{$role->id}}' class='btn btn-primary deletebtn' onclick='function_alert("{{$role->id}}")'>Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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

    <div class="modal fade" id="addTaskModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Roles</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action='addRole' enctype="multipart/form-data" method="post" class="form-horizontal">
                        @csrf
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Roles</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="roles" name='name' placeholder="Roles">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Permissions</label>
                                <select class="select2bs4" multiple="multiple" name="permissions[]" data-placeholder="Select Permissions" style="width: 100%;">
                                    @foreach($permissions as $permission)
                                    <option value='{{$permission->id}}'>{{$permission->name}}</option>
                                    @endforeach
                                </select>
                            </div>
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


    <div class="modal fade" id="editRoleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Roles</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action='updateRole' enctype="multipart/form-data" method="post" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" id='id' name='id'>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Roles</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="rolefield" name='roles' placeholder="Roles">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Permissions</label>
                                <select class="select2bs4" multiple="multiple" name="permissions[]" id="permissionSelect" data-placeholder="Select Permissions" style="width: 100%;">
                                    @foreach($permissions as $permission)
                                    <option value='{{$permission->id}}'>{{$permission->name}}</option>
                                    @endforeach
                                </select>
                            </div>

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
 

</div>
<script src="{{ URL::asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- model -->
<script src="{{ URL::asset('js/role.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>



@endsection